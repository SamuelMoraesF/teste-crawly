<?php

use PHPUnit\Framework\TestCase;
use Project\PageContent;

final class PageContentTest extends TestCase
{
    public function testDomDocument(): void
    {
        $pageContent = new PageContent('Teste');

        $this->assertInstanceOf(DOMDocument::class, $pageContent->getDomDocument());
        $this->assertEquals('Teste', $pageContent->getDomDocument()->textContent);
    }

    public function testResponseBody(): void
    {
        $pageContent = new PageContent('Teste');

        $this->assertEquals('Teste', $pageContent->getResponseBody());
    }

    public function testGetFirstXpathItem(): void
    {
        $element = (new PageContent('Teste <span id="test">Content</span>'))
            ->getFirstXpathItem('//span[@id="test"]');

        $this->assertEquals('span', $element->nodeName);
        $this->assertEquals('Content', $element->textContent);
    }

    public function testGetToken(): void
    {
        $token = (new PageContent('Content <input id="token" value="123" />'))
            ->getToken();

        $this->assertEquals('123', $token);
    }

    public function testGetAnswer(): void
    {
        $answer = (new PageContent('Content <span id="answer">Content</span>'))
            ->getAnswer();

        $this->assertEquals('Content', $answer);
    }
}
