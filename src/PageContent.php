<?php

namespace Project;

use DOMDocument;
use DOMElement;
use DOMXPath;

class PageContent
{
    /**
     * HTTP request response
     *
     * @var string
     */
    protected $response;

    /**
     * Class constructor
     *
     * @param string $response
     */
    public function __construct(string $response)
    {
        $this->response = $response;
    }

    /**
     * Get response as DOM document
     *
     * @return DOMDocument
     */
    public function getDomDocument(): DOMDocument
    {
        $doc = new DOMDocument();
        $doc->loadHTML($this->response);

        return $doc;
    }

    /**
     * Get response body
     *
     * @return string
     */
    public function getResponseBody(): string
    {
        return $this->response;
    }

    /**
     * Get first item from xpath query
     *
     * @param string $path
     * @return DOMElement
     */
    public function getFirstXpathItem(string $path): DOMElement
    {
        return (new DOMXPath($this->getDomDocument()))
            ->query($path)
            ->item(0);
    }

    /**
     * Get token value from response
     *
     * @return string
     */
    public function getToken(): string
    {
        return $this->getFirstXpathItem('//input[@id="token"]')
            ->getAttribute('value');
    }

    /**
     * Get answer from response
     *
     * @return string
     */
    public function getAnswer(): string
    {
        return $this->getFirstXpathItem('//span[@id="answer"]')
            ->textContent;
    }
}
