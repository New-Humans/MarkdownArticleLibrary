# new-humans/markdown-article-library

**new-humans/markdown-article-library** is a PHP-based file system wrapper for [**leage/commonmark**](https://github.com/thephpleague/commonmark)'s Markdown parser. File system navigation emotionally inspired by [**new-humans/ubfs**](https://github.com/New-Humans/ubfs).

## Goals
* Let a writer interact with a relatively organize-able file system of Markdown files, in PHP.
* Let the writer offer these files as an HTML render for web browsers.
* Let the writer offer these files as downloads.

## Installation
This project can be installed via [Composer].
``` bash
$ composer require new-humans/markdown-article-library
```

## Basic Usage
The `ArticleLibrary` class provides a simple wrapper for loading a 1-level deep Markdown file system. A library directory is expected to exist in your project in the following format:
``` bash
/library
    - /notes
        - on-the-nature-of-the-universe.md
        - the-purpose-of-the-state.md
    - /ideas
        - persona-purpose-and-human-purpose.md
        - why-we-do-the-things-we-do.md
    - /lists
        - four-steps-for-preventing-career-bureacurism
```
Each subdirectory of `/library` represents a writing subject. Each file in the subdirectory represents a piece of writing within that subject, formatted in Markdown.

**Note:** Any of these names can be replaced - they're all supplied to the object by the developer, based on the actual files in the solution. The example in this repository includes subjects `/notes` and `/whimsy`.
``` php
use NewHumans\MarkdownArticleLibrary\ArticleLibrary;

// Instantiate the ArticleLibrary
$articleLibrary = new ArticleLibrary(__DIR__.'/articles');

// Instatiate the subject 'notes'
$articleLibrary->newSubject("notes");

// Instantiate the article 'grocery.md' to key 'grocery' within subject 'notes'
$articleLibrary->newArticle("notes", "grocery.md", "grocery");

// Output the article contents to client (HMTL or download)
echo $articleLibrary->readArticle("notes", "grocery");
// or $articleLibrary->downloadArticle("notes", "grocery");
```

## Documentation
Best place to look is inside! Just two classes in `/src`.
