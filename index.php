<?php

// Standard composer requirements
require_once __DIR__.'/vendor/autoload.php';

// Include our test classes (these will be autoloaded via composer into vendor normally)
require 'src/New-Humans/MarkdownArticleLibrary/Article.php';
require 'src/New-Humans/MarkdownArticleLibrary/ArticleLibrary.php';
use NewHumans\MarkdownArticleLibrary\Article as Article;
use NewHumans\MarkdownArticleLibrary\ArticleLibrary as ArticleLibrary;

// And for the actual tests! Assume directory structure in articles.
$method = "read";   // Switch this to 'download' to get the markdown output for the library.

// Make an article library. It lives in a directory. The constructor makes sure the directory's A-ok or it throws an error.
$articleLibrary = new ArticleLibrary(__DIR__.'/articles');
$articleLibrary->newSubject("notes");
$articleLibrary->newArticle("notes", "grocery.md", "grocery");
if ($method === "read")
    echo $articleLibrary->readArticle("notes", "grocery");  // We can only do one or the other
if ($method === "download")
    $articleLibrary->downloadArticle("notes", "grocery");   // Because if we're dowloading something... like.. that's it. That's the response.
