<?php

namespace NewHumans\MarkdownArticleLibrary;


use League\CommonMark\CommonMarkConverter;


/**
 * Each article represents an actual .md Markdown file. This is a READ-only class.
 */

class Article
{
    private $content;   // Perhaps most important - the MD text string for the article
    private $key;   // Less useful, just an identifier.

    public function __construct($k, $c) { // Existence is guranteed by library. Don't worry about that here, just build article.
        $this->content = $c;
        $this->key = $k;
    }

    public function toHtml() { // Input: none - Output: its content parsed to HTML
        $converter = new CommonMarkConverter;
        return $converter->convertToHtml($this->content);
    }

    public function toMarkdown() { //Input: none - Output: its content
        return $this->content;
    }
}
