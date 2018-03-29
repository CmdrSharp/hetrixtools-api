<?php

use CmdrSharp\HetrixtoolsApi\Blacklist\Factory as HetrixFactory;
use CmdrSharp\HetrixtoolsApi\Blacklist\Repository as HetrixRepository;
use PHPUnit\Framework\TestCase;

class HetrixtoolsBlacklistApiTest extends TestCase
{
    /** @var HetrixFactory */
    protected $hetrixFactory;

    /** @var HetrixRepository */
    protected $hetrixRepository;

    public function setUp()
    {
        $this->hetrixFactory = new HetrixFactory('testKey');
        $this->hetrixRepository = new HetrixRepository('testKey');
    }

    /** @test */
    public function an_invalid_create_throws_exception()
    {
        $this->expectException(\ErrorException::class);

        $this->hetrixFactory->create();
    }

    /** @test */
    public function an_invalid_target_throws_exception()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->hetrixFactory->target('0.0.0.0/512');
        $this->hetrixFactory->target('http://google.com');
        $this->hetrixFactory->target('512.512.512.512');
    }

    /** @test */
    public function a_valid_target_works()
    {
        $this->hetrixFactory->target('8.8.8.8');
        $this->hetrixFactory->target('foobar.com');
        $this->hetrixFactory->target('server1.foobar.com');
        $this->hetrixFactory->target('192.168.0.1/24');

        $this->assertTrue(true);
    }

    /** @test */
    public function an_invalid_label_throws_exception()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->hetrixFactory->label('Foo^bar#bit%bot');
    }

    /** @test */
    public function a_valid_label_works()
    {
        $this->hetrixFactory->label('AZaz0-9 .-');

        $this->assertTrue(true);
    }

    /** @test */
    public function a_valid_contact_works()
    {
        $this->hetrixFactory->contact(0);
        $this->hetrixFactory->contact('0');

        $this->assertTrue(true);
    }

    /** @test */
    public function an_invalid_blacklist_report_throws_exception()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->hetrixRepository->blacklistReport('foobar');
    }

    /** @test */
    public function an_invalid_date_in_blacklist_report_throws_exception()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->hetrixRepository->blacklistReport('server.foobar.com', 'yyyy-mm-dd');
        $this->hetrixRepository->blacklistReport('server.foobar.com', '2018-05-55');
    }

    /** @test */
    public function a_manual_blacklist_check_throws_exception_if_not_ip_or_hostname()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->hetrixRepository->manualCheck('foobar');
        $this->hetrixRepository->manualCheck('152.000.1900.1');
    }
}