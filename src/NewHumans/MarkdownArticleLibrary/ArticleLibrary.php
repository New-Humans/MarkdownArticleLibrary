<?php

/*
 * This file is part of the new-humans/markdown-article-library package.
 *
 * Juniper McIntyre <junipermcintyre@gmail.com>
 *
 * MarkDown parsing from league/commonmark package (https://github.com/thephpleague/commonmark). File system wrapping by me.
 *
 * For the full copyright and license information please view he LICENSE file distributed with this source code.
 */

namespace NewHumans\MarkdownArticleLibrary;


/**
 * Handles file-system interaction for Articles. Uses the concepts of 'subjects' as subdirectories and 'articles' as MarkDown files.
 */
class ArticleLibrary
{
    /**
     * Absolute path to the article library base directory.
     *
     * @var string
     */
    private $path;

    /**
     * Associative array of subjects, by key. Subjects contain a 'path'
     * index, and an 'articles' index.
     *
     * Could consider substituting with its own wrapper class, instead of associate array
     *
     * @var string
     */
    private $subjects;

    /**
     * Create a new ArticleLibrary instance
     *
     * @param string $baseDir
     */
    public function __construct($baseDir)
    {
        if (!is_dir($baseDir))              // Check for baseDirectory's existence first
            throw new Exception("Error: Cannot read library directory '{$baseDir}'");
        $this->path = rtrim($baseDir, '/'); // If all OK, set it as the path (remove trailing slash too)
        $this->subjects = array();          // Initialize subjects array
    }

    /**
     * Create a new subject within an ArticleLibrary instance. The subect key is synonymous with its directory name.
     *
     * @param string $subjectKey
     */
    public function newSubject($subjectKey)
    {
        if (!is_dir($this->path.'/'.$subjectKey))                   // Check for the subject directory's existence first
            throw new Exception("Error: Cannot read subject directory '{$this->path}/{$subjectKey}'");
        $this->subjects[$subjectKey]['path'] = $this->path.'/'.$subjectKey; // Create/set the subject. They can retrieve via the same key later
        $this->subjects[$subjectKey]['articles'] = array();                 // Initialize with empty array of articles to start
    }

    /**
     * Retrieve a subject by key, within an ArticleLibrary instance
     *
     * @param string $subjectKey
     *
     * @return array
     */
    public function getSubject($subjectKey)
    {
        if (!isset($this->subjects[$subjectKey]))   // If it doesn't exist, throw an error
            throw new Exception("Error: Subject '{$subjectKey}' in this library has not been initialized.");
        return $this->subjects[$subjectKey];        // If it did exist, then return it
    }

    /**
     * Create a new article within a subject, within an ArticleLibrary instance
     *
     * @param string $subjectKey
     * @param string $mdFile
     * @param string $articleKey
     */
    public function newArticle($subjectKey, $mdFile, $articleKey)
    {
        $subject = $this->getSubject($subjectKey);                              // Grab the subject we want
        if (!is_file($subject['path'].'/'.$mdFile))                             // Confirm the new article file exists
            throw new Exception("Error: Article '{$subject['path']}/{$mdFile}' cannot be read.");
        $mdContent = file_get_contents($subject['path'].'/'.$mdFile);           // Read the whole file into a string
        // Create a new article in the subject, with the supplied identifying key.
        $this->subjects[$subjectKey]['articles'][$articleKey] = new Article($articleKey, $mdContent);
    }

    /**
     * Retrieve an article within a subject, within an ArticleLibrary instance
     *
     * @param string $subjectKey
     * @param string $articleKey
     *
     * @return Article
     */
    public function getArticle($subjectKey, $articleKey)
    {
        $subject = $this->getSubject($subjectKey);      // Grab the desired subject
        if (!isset($subject['articles'][$articleKey]))  // Make sure the article exists
            throw new Exception("Error: Article '{$articleKey}' in subject '{$subjectDirectory}' has not been initialized.");
        return $subject['articles'][$articleKey];       // If it does, return it. If it doesn't, throw the above exception.
    }

    /**
     * Read an article within a subject within an ArticleLibrary instance.
     * Read means return an HTML output of the article.
     *
     * @param string $subjectKey
     * @param string $articleKey
     *
     * @return string
     */
    public function readArticle($subjectKey, $articleKey)
    {
        $article = $this->getArticle($subjectKey, $articleKey); // Get the article...
        return $article->toHtml();                              // Return the HTML output...
    }

    /**
     * Download an article within a subject within an ArticleLibrary instance.
     * Download means return content-type headers and the output of the file for download.
     * Don't output anything to client before calling this if you want it to work!!
     *
     * @param string $subjectKey
     * @param string $articleKey
     *
     * @return text/markdown
     */
    public function downloadArticle($subjectKey, $articleKey)
    { // MD file download output. This will end the HTTP request!
        $article = $this->getArticle($subjectKey, $articleKey);
        header('Content-Type: text/markdown; charset-UTF-8');
        print $article->toMarkdown();
    }
}
