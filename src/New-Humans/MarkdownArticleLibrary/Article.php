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

use League\CommonMark\CommonMarkConverter;


/**
 * Each article represents an actual .md Markdown file. This is a READ-only class. Assumes files exist (handled in ArticleLibrary)
 */
class Article
{
    /**
     * Raw string of the Markdown content.
     *
     * @var string
     */
    private $content;

    /**
     * Identifying key of the article in the ArticleLibrary's subject. Unused in the Article class.
     *
     * @var string
     */
    private $key;

    /**
     * Create a new Article instance
     *
     * @param string $key
     * @param string $content
     */
    public function __construct($key, $content)
    {
        $this->content = $content;
        $this->key = $key;
    }

    /**
     * Output this Article's Markdown content as HTML
     *
     * @return string
     */
    public function toHtml()
    {
        $converter = new CommonMarkConverter;
        return $converter->convertToHtml($this->content);
    }

    /**
     * Output this Article's Markdown content as-is
     *
     * @return string
     */
    public function toMarkdown()
    {
        return $this->content;
    }
}
