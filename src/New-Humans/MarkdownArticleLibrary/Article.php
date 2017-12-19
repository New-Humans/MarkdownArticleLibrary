<?php

namespace NewHumans\MarkdownArticleLibrary;


/**
 * Each article represents an actual .md Markdown file.
 */

class Article
{
    private $filename;  // Representative of literal file name in subject directory

    public function __construct($f) { // Check existence. Throw error if it doesn't exist.
        $this->filename = $f;
    }

    public function test() {
        echo __DIR__;
    }



}
