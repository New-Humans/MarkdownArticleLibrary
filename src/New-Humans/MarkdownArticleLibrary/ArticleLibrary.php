<?php

namespace NewHumans\MarkdownArticleLibrary;



/**
 * Mostly just a container for actual Articles. One Article Library per subject!
 */

class ArticleLibrary
{
    private $path;      // Actual on-file path
    private $subjects; // This could be a class of its own, maybe. Not now though. Could make this node/tree style.

    public function __construct($b) { // Check existence of directory. Throw error if it doesn't exist.
        if (!is_dir($b))
            throw new Exception("Error: Cannot read library directory '{$b}'");
        $this->path = $b;

        $this->subjects = array();
    }

    public function newSubject($sd) { // Input is the directory name of the subject. Purpose is to initialize subject
        if (!is_dir($this->path.'/'.$sd))
            throw new Exception("Error: Cannot read subject directory '{$this->path}/{$sd}'");

        $this->subjects[$sd]['path'] = $this->path.'/'.$sd;   // Set it. They can retrieve via the same $sd value
        $this->subjects[$sd]['articles'] = array();   // Fill with Article objects
    }

    public function getSubject($sd) { // Input is subject directory. Output is a subject (path + articles array).
        if (!isset($this->subjects[$sd]))
            throw new Exception("Error: Subject '{$sd}' in this library has not been initialized.");
        return $this->subjects[$sd];
    }

    public function newArticle($sd, $mdFile, $key) { // Input is subject + MD file name (should end in .md) +
                                                     // unique key (for array). Inits article into library,
                                                     // and also returns it

        // If the subject doesn't exist, try to initialize it first
        try {
            $subject = $this->getSubject($sd);
        } catch (Exception $e) {
            $this->newSubject($sd);
            $subject = $this->getSubject($sd);
        }

        // Create an article. The article should not be responsible for confirming its own existence, the library guarantees it.
        // In fact, the library creates it (inits it with the markdown string).

        // Make sure the article exists first
        if (!is_file($subject['path'].'/'.$mdFile))
            throw new Exception("Error: Article '{$subject['path']}/{$mdFile}' cannot be read.");

        // Read the MD content into a string
        $mdContent = file_get_contents($subject['path'].'/'.$mdFile);

        $this->subjects[$sd]['articles'][$key] = new Article($key, $mdContent);
    }

    public function getArticle($sd, $key) { // Input is subject directory. Output is Article object of specific key
        $subject = $this->getSubject($sd);
        if (!isset($subject['articles'][$key]))
            throw new Exception("Error: Article '{$key}' in subject '{$sd}' has not been initialized.");
        return $subject['articles'][$key];
    }

    public function readArticle($sd, $key) {    // HTML output
        $article = $this->getArticle($sd, $key);
        return $article->toHtml();
    }

    public function downloadArticle($sd, $key) { // MD file download output. This will end the HTTP request!
        $article = $this->getArticle($sd, $key);
        header('Content-Type: text/markdown; charset-UTF-8');
        print $article->toMarkdown();
    }
}
