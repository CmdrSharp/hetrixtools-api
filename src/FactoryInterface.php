<?php

namespace CmdrSharp\HetrixtoolsApi;

use Psr\Http\Message\ResponseInterface;

interface FactoryInterface
{
    /**
     * @param String $method
     * @return ResponseInterface
     * @throws \ErrorException
     * @throws \InvalidArgumentException
     */
    public function call(String $method = 'POST'): ResponseInterface;

    /**
     * @param String $id
     * @return FactoryInterface
     */
    public function id(String $id): FactoryInterface;

    /**
     * @param String $type
     * @return FactoryInterface
     * @throws \InvalidArgumentException
     */
    public function type(String $type): FactoryInterface;

    /**
     * @param String $name
     * @return FactoryInterface
     * @throws \InvalidArgumentException
     */
    public function name(String $name): FactoryInterface;

    /**
     * @param String $target
     * @return FactoryInterface
     * @throws \InvalidArgumentException
     */
    public function target(String $target): FactoryInterface;

    /**
     * @param int $timeout
     * @return FactoryInterface
     * @throws \InvalidArgumentException
     */
    public function timeout(int $timeout): FactoryInterface;

    /**
     * @param int $frequency
     * @return FactoryInterface
     * @throws \InvalidArgumentException
     */
    public function frequency(int $frequency): FactoryInterface;

    /**
     * @param int $fails
     * @return FactoryInterface
     * @throws \InvalidArgumentException
     */
    public function failsBeforeAlert(int $fails): FactoryInterface;

    /**
     * @param int|null $failed
     * @return FactoryInterface
     * @throws \InvalidArgumentException
     */
    public function failedLocations(?int $failed = null): FactoryInterface;

    /**
     * @param int|null $contactList
     * @return FactoryInterface
     */
    public function contactList(?int $contactList = null): FactoryInterface;

    /**
     * @param null|String $category
     * @return FactoryInterface
     */
    public function category(?String $category = null): FactoryInterface;

    /**
     * @param int|null $time
     * @return FactoryInterface
     * @throws \InvalidArgumentException
     */
    public function alertAfter(?int $time = null): FactoryInterface;

    /**
     * @param int|null $times
     * @return FactoryInterface
     * @throws \InvalidArgumentException
     */
    public function repeatTimes(?int $times = null): FactoryInterface;

    /**
     * @param int|null $every
     * @return FactoryInterface
     * @throws \InvalidArgumentException
     */
    public function repeatEvery(?int $every = null): FactoryInterface;

    /**
     * @param bool $public
     * @return FactoryInterface
     */
    public function public(bool $public = false): FactoryInterface;

    /**
     * @param bool $show
     * @return FactoryInterface
     */
    public function showTarget(bool $show = false): FactoryInterface;

    /**
     * @param bool $verify
     * @return FactoryInterface
     */
    public function verify_ssl_certificate(bool $verify = false): FactoryInterface;

    /**
     * @param bool $verify
     * @return FactoryInterface
     */
    public function verify_ssl_host(bool $verify = false): FactoryInterface;

    /**
     * @param array $locations
     * @return FactoryInterface
     * @throws \InvalidArgumentException
     */
    public function locations(array $locations): FactoryInterface;

    /**
     * @param null|String $keyword
     * @return FactoryInterface
     */
    public function keyword(?String $keyword = null): FactoryInterface;

    /**
     * @param int $redirects
     * @return FactoryInterface
     * @throws \InvalidArgumentException
     */
    public function maxRedirects(int $redirects): FactoryInterface;

    /**
     * @param int $port
     * @return FactoryInterface
     * @throws \InvalidArgumentException
     */
    public function port(int $port): FactoryInterface;

    /**
     * @param bool $check
     * @return FactoryInterface
     */
    public function checkAuth(bool $check = false): FactoryInterface;

    /**
     * @param String $user
     * @return FactoryInterface
     */
    public function smtpUser(String $user): FactoryInterface;

    /**
     * @param String $pass
     * @return FactoryInterface
     */
    public function smtpPass(String $pass): FactoryInterface;
}
