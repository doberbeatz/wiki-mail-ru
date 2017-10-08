<?php

namespace app\models;

class Breadcrumb
{
    /** @var string $url */
    protected $title;

    /** @var string $url */
    protected $url;

    /**
     * Breadcrumb constructor.
     * @param string $title
     * @param string $url
     */
    public function __construct($title, $url)
    {
        $this->setTitle($title);
        $this->setUrl($url);
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = (string) $title;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = (string) $url;
    }
}