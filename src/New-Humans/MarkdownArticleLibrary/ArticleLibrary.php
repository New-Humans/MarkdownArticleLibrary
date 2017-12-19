<?php

namespace NewHumans\MarkdownArticleLibrary;


/**
 * Mostly just a container for actual Articles. One Article Library per subject!
 */

class ArticleLibrary
{
    private $libraryDir;

    public function __construct($b) {       // Check for directory existence first
        $this->libraryDir = $b;
    }

    public function test() {
        echo $this->libraryDir;
    }
}
