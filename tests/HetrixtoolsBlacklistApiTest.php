<?php

use CmdrSharp\HetrixtoolsApi\Blacklist\Factory as HetrixFactory;
use PHPUnit\Framework\TestCase;

class HetrixtoolsBlacklistApiTest extends TestCase
{
    /** @var HetrixFactory */
    protected $hetrix;

    public function setUp()
    {
        $this->hetrix = new HetrixFactory('testKey');
    }

    /** @test */
    public function an_invalid_create_throws_exception()
    {
        $this->expectException(\ErrorException::class);

        $this->hetrix->create();
    }

    /** @test */
    public function an_invalid_target_throws_exception()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->hetrix->target('0.0.0.0/512');
        $this->hetrix->target('http://google.com');
        $this->hetrix->target('512.512.512.512');
    }

    /** @test */
    public function a_valid_target_works()
    {
        $this->hetrix->target('8.8.8.8');
        $this->hetrix->target('foobar.com');
        $this->hetrix->target('server1.foobar.com');
        $this->hetrix->target('192.168.0.1/24');

        $this->assertTrue(true);
    }

    /** @test */
    public function an_invalid_label_throws_exception()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->hetrix->label('Foo^bar#bit%bot');
    }

    /** @test */
    public function a_valid_label_works()
    {
        $this->hetrix->label('AZaz0-9 .-');

        $this->assertTrue(true);
    }

    /** @test */
    public function a_valid_contact_works()
    {
        $this->hetrix->contact(0);
        $this->hetrix->contact('0');

        $this->assertTrue(true);
    }
}
