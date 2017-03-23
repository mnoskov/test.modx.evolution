<?php namespace ModxEvo\Tests\DocumentParser;

use ModxEvo\Tests\ModxAbstract;

class getTagsFromContentTest extends ModxAbstract {
    /**
     * @var \ReflectionClass
     */
    protected $method;

    public function setUp() {
        parent::setUp();

        $this->method = $this->getMethod($this->modx, "getTagsFromContent");
    }

    public function testBaseOnePlaceholderSuccess()
    {
        $filters = $this->method->invoke($this->modx, '[+a+]');
        $this->assertEquals(array(array('[+a+]'), array('a')), $filters);
    }

    public function testBaseTwoPlaceholderSuccess()
    {
        $filters = $this->method->invoke($this->modx, '[+a+] [+b+]');
        $this->assertEquals(array(array('[+a+]', '[+b+]'), array('a', 'b')), $filters);
    }

    public function testBaseOneChunkSuccess()
    {
        $filters = $this->method->invoke($this->modx, '{{a}}', '{{', '}}');
        $this->assertEquals(array(array('{{a}}'), array('a')), $filters);
    }

    public function testBaseTwoChunkSuccess()
    {
        $filters = $this->method->invoke($this->modx, '{{a}} {{b}}', '{{', '}}');
        $this->assertEquals(array(array('{{a}}', '{{b}}'), array('a', 'b')), $filters);
    }

    public function testBaseOneSnippetSuccess()
    {
        $filters = $this->method->invoke($this->modx, '[[a]]', '[[', ']]');
        $this->assertEquals(array(array('[[a]]'), array('a')), $filters);
    }

    public function testBaseTwoSnippetSuccess()
    {
        $filters = $this->method->invoke($this->modx, '[[a]] [[b]]', '[[', ']]');
        $this->assertEquals(array(array('[[a]]', '[[b]]'), array('a', 'b')), $filters);
    }

    public function testOneSnippetWithParamsSuccess()
    {
        $filters = $this->method->invoke($this->modx, '[[a? &test=`qwe`]]', '[[', ']]');
        $this->assertEquals(array(array('[[a? &test=`qwe`]]'), array('a? &test=`qwe`')), $filters);
    }
}

