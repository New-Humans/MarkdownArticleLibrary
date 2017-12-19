<?php

// Standard composer requirements
require_once __DIR__.'/vendor/autoload.php';

// Include our test classes (these will be autoloaded via composer into vendor normally)
require 'src/New-Humans/MarkdownArticleLibrary/ArticleLibrary.php';
require 'src/New-Humans/MarkdownArticleLibrary/Article.php';
use NewHumans\MarkdownArticleLibrary\ArticleLibrary as ArticleLibrary;
use NewHumans\MarkdownArticleLibrary\Article as Article;

// And for the actual tests! Assume directory structure in articles.
// Make an article! This... shouldn't be possible. All articles must exist within libraries.
$article = new Article("nada.md");
$article->test();

echo "\n\n"; // get outta the way

// Make an article library. It lives in a directory.
$articleLibrary = new ArticleLibrary(__DIR__.'/articles');
$articleLibrary->test();
