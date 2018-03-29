<?php

use CmdrSharp\HetrixtoolsApi\Uptime\Factory as HetrixFactory;
use PHPUnit\Framework\TestCase;

class HetrixtoolsMonitorApiTest extends TestCase
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

        $this->hetrix->name('Test')->create();
    }

    /** @test */
    public function an_invalid_type_throws_exception()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->hetrix->type('foobar');
    }

    /** @test */
    public function a_valid_type_works()
    {
        $this->hetrix->type('website');
        $this->hetrix->type('ping');
        $this->hetrix->type('service');
        $this->hetrix->type('smtp');

        $this->assertTrue(true);
    }

    /** @test */
    public function an_invalid_name_throws_exception()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->hetrix->name('foo%bar#penguin!llama');
    }

    /** @test */
    public function a_valid_name_works()
    {
        $this->hetrix->name('Foobar Monitor 123 - Foobar.com');

        $this->assertTrue(true);
    }

    /** @test */
    public function an_invalid_target_throws_exception()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->hetrix->target('0');
        $this->hetrix->target('abcdefg');
        $this->hetrix->target('www.https://foobar.com');
        $this->hetrix->target('9.8.9.9.9');
    }

    /** @test */
    public function a_valid_target_works()
    {
        $examples = [
            'foobar.com',
            'http://foobar.com',
            'http://www.foobar.com',
            'https://foobar.com',
            'https://www.foobar.com',
            'https://foobar.com/test/machine',
            'https://foobar.com/tests/machine?1',
            'https://foobar.com/tests/machine?1=1&2=2',
            'foobar-server.foobar.com',
            '8.8.8.8',
            '192.168.0.1'
        ];

        foreach ($examples as $example) {
            $this->hetrix->target($example);
        }

        $this->assertTrue(true);
    }

    /** @test */
    public function an_invalid_timeout_throws_exception()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->hetrix->timeout(1);
    }

    /** @test */
    public function a_valid_timeout_works()
    {
        $this->hetrix->timeout(3);
        $this->hetrix->timeout(5);
        $this->hetrix->timeout(10);

        $this->assertTrue(true);
    }

    /** @test */
    public function an_invalid_frequency_throws_exception()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->hetrix->frequency(2);
    }

    /** @test */
    public function a_valid_frequency_works()
    {
        $this->hetrix->frequency(1);
        $this->hetrix->frequency(3);
        $this->hetrix->frequency(5);
        $this->hetrix->frequency(10);

        $this->assertTrue(true);
    }

    /** @test */
    public function an_invalid_fails_before_alert_throws_exception()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->hetrix->failsBeforeAlert(0);
    }

    /** @test */
    public function a_valid_fails_before_alert_works()
    {
        $this->hetrix->failsBeforeAlert(1);
        $this->hetrix->failsBeforeAlert(2);
        $this->hetrix->failsBeforeAlert(3);

        $this->assertTrue(true);
    }

    /** @test */
    public function an_invalid_failed_locations_throws_exception()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->hetrix->failedLocations(1);
    }

    /** @test */
    public function a_valid_failed_locations_works()
    {
        for ($i = 2; $i < 12; $i++) {
            $this->hetrix->failedLocations($i);
        }

        $this->assertTrue(true);
    }

    /** @test */
    public function an_invalid_alert_after_throws_exception()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->hetrix->alertAfter(0);
        $this->hetrix->alertAfter('foobar');
    }

    /** @test */
    public function a_valid_alert_after_works()
    {
        for ($i = 1; $i < 10; $i++) {
            $this->hetrix->alertAfter($i);
        }

        $this->hetrix->alertAfter(15);
        $this->hetrix->alertAfter(20);

        for ($i = 30; $i < 60; $i += 10) {
            $this->hetrix->alertAfter($i);
        }

        $this->assertTrue(true);
    }

    /** @test */
    public function an_invalid_repeat_times_throws_exception()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->hetrix->repeatTimes(-1);
        $this->hetrix->repeatTimes(55);
    }

    /** @test */
    public function a_valid_repeat_times_works()
    {
        for ($i = 0; $i < 30; $i++) {
            $this->hetrix->repeatTimes($i);
        }

        $this->assertTrue(true);
    }

    /** @test */
    public function an_invalid_repeat_every_throws_exception()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->hetrix->repeatEvery(0);
    }

    /** @test */
    public function a_valid_repeat_every_works()
    {
        for ($i = 1; $i < 10; $i++) {
            $this->hetrix->repeatEvery($i);
        }

        $this->hetrix->repeatEvery(15);
        $this->hetrix->repeatEvery(20);

        for ($i = 30; $i < 60; $i += 10) {
            $this->hetrix->repeatEvery($i);
        }

        $this->assertTrue(true);
    }

    /** @test */
    public function an_invalid_locations_throws_exception()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->hetrix->locations([]);
        $this->hetrix->locations([
            'nyc',
            'sfo'
        ]);
        $this->hetrix->locations([
            'nyc',
            'sfo',
            'foobar'
        ]);
    }

    /** @test */
    public function a_valid_locations_works()
    {
        $this->hetrix->locations([
            'nyc',
            'sfo',
            'tok'
        ]);

        $this->assertTrue(true);
    }

    /** @test */
    public function an_invalid_max_redirects_throws_exception()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->hetrix->maxRedirects(-1);
        $this->hetrix->maxRedirects(55);
    }

    /** @test */
    public function a_valid_max_redirects_works()
    {
        for ($i = 0; $i < 10; $i++) {
            $this->hetrix->maxRedirects($i);
        }

        $this->assertTrue(true);
    }

    /** @test */
    public function an_invalid_port_throws_exception()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->hetrix->port(-1);
        $this->hetrix->port(55);
    }

    /** @test */
    public function a_valid_port_works()
    {
        for ($i = 0; $i < 65535; $i++) {
            $this->hetrix->port($i);
        }

        $this->assertTrue(true);
    }
}
