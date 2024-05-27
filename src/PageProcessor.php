<?php

declare(strict_types=1);

namespace DouglasGreen\Wiktionary;

class PageProcessor
{
    /**
     * @var \SimpleXMLElement The SimpleXMLElement object representing the page XML.
     */
    private readonly \SimpleXMLElement|bool $xml;

    /**
     * Constructor for the PageProcessor class.
     *
     * @param string $xmlString The XML string representing the Wiktionary page.
     */
    public function __construct(string $xmlString)
    {
        $this->xml = simplexml_load_string($xmlString);
    }

    /**
     * Retrieves the title of the page.
     *
     * @return string The title of the page.
     */
    public function getTitle(): string
    {
        return (string) $this->xml->title;
    }

    /**
     * Retrieves the namespace of the page.
     *
     * @return string The namespace of the page.
     */
    public function getNamespace(): string
    {
        return (string) $this->xml->ns;
    }

    /**
     * Retrieves the ID of the page.
     *
     * @return string The ID of the page.
     */
    public function getId(): string
    {
        return (string) $this->xml->id;
    }

    /**
     * Retrieves the title of the redirect page, if applicable.
     *
     * @return string The title of the redirect page, or an empty string if not a redirect.
     */
    public function getRedirectTitle(): string
    {
        return (string) $this->xml->redirect['title'];
    }

    /**
     * Retrieves the ID of the page revision.
     *
     * @return string The ID of the page revision.
     */
    public function getRevisionId(): string
    {
        return (string) $this->xml->revision->id;
    }

    /**
     * Retrieves the ID of the parent revision.
     *
     * @return string The ID of the parent revision.
     */
    public function getParentId(): string
    {
        return (string) $this->xml->revision->parentid;
    }

    /**
     * Retrieves the timestamp of the page revision.
     *
     * @return string The timestamp of the page revision.
     */
    public function getTimestamp(): string
    {
        return (string) $this->xml->revision->timestamp;
    }

    /**
     * Retrieves the username of the contributor who made the page revision.
     *
     * @return string The username of the contributor.
     */
    public function getContributorUsername(): string
    {
        return (string) $this->xml->revision->contributor->username;
    }

    /**
     * Retrieves the ID of the contributor who made the page revision.
     *
     * @return string The ID of the contributor.
     */
    public function getContributorId(): string
    {
        return (string) $this->xml->revision->contributor->id;
    }

    /**
     * Retrieves the comment associated with the page revision.
     *
     * @return string The comment associated with the page revision.
     */
    public function getComment(): string
    {
        return (string) $this->xml->revision->comment;
    }

    /**
     * Retrieves the content model of the page.
     *
     * @return string The content model of the page.
     */
    public function getModel(): string
    {
        return (string) $this->xml->revision->model;
    }

    /**
     * Retrieves the content format of the page.
     *
     * @return string The content format of the page.
     */
    public function getFormat(): string
    {
        return (string) $this->xml->revision->format;
    }

    /**
     * Retrieves the text content of the page.
     *
     * @return string The text content of the page.
     */
    public function getText(): string
    {
        return (string) $this->xml->revision->text;
    }

    /**
     * Retrieves the SHA-1 hash of the page content.
     *
     * @return string The SHA-1 hash of the page content.
     */
    public function getSha1(): string
    {
        return (string) $this->xml->revision->sha1;
    }
}
