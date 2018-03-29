<?php
declare(strict_types=1);

namespace CmdrSharp\HetrixtoolsApi\Uptime;

use CmdrSharp\HetrixtoolsApi\Traits\Validator;
use CmdrSharp\HetrixtoolsApi\AbstractApi;
use Psr\Http\Message\ResponseInterface;

class Factory extends AbstractApi implements FactoryInterface
{
    use Validator;

    /** @var string */
    private $apiKey;

    /** @var array */
    protected $post = [];

    /**
     * Factory constructor.
     *
     * @param String $apiKey
     */
    public function __construct(String $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * Create an Uptime Monitor
     *
     * @return ResponseInterface
     * @throws \ErrorException
     */
    public function create(): ResponseInterface
    {
        return AbstractApi::post($this->apiKey, 'uptime/add/', $this->post);
    }

    /**
     * Edit an Uptime Monitor
     *
     * @return ResponseInterface
     * @throws \ErrorException
     */
    public function patch(): ResponseInterface
    {
        return AbstractApi::post($this->apiKey, 'uptime/edit/', $this->post);
    }

    /**
     * Delete an Uptime Monitor
     *
     * @return ResponseInterface
     * @throws \ErrorException
     */
    public function delete(): ResponseInterface
    {
        return AbstractApi::post($this->apiKey, 'uptime/delete/', $this->post);
    }

    /**
     * Put an Uptime Monitor into maintenance mode.
     *
     * @param String $monitor_id
     * @param int $maintenance_mode
     * @return mixed
     * @throws \InvalidArgumentException
     * @throws \ErrorException
     */
    public function maintenance(String $monitor_id, int $maintenance_mode)
    {
        if ($maintenance_mode < 1 || $maintenance_mode > 3) {
            throw new \InvalidArgumentException('Maintenance mode must be between 1 and 3');
        }

        return AbstractApi::get($this->apikey, 'maintenance/' . $monitor_id . '/' . $maintenance_mode . '/');
    }

    /**
     * Set the ID
     *
     * @param String $id
     * @return FactoryInterface
     */
    public function id(String $id): FactoryInterface
    {
        $this->post['MID'] = $id;

        return $this;
    }

    /**
     * Set the type
     *
     * @param String $type
     * @return FactoryInterface
     * @throws \InvalidArgumentException
     */
    public function type(String $type): FactoryInterface
    {
        if (!in_array($type, ['website', 'ping', 'service', 'smtp'])) {
            throw new \InvalidArgumentException('Invalid type specified. Available types: website, ping, service, smtp');
        }

        $types = [
            'website' => 1,
            'ping' => 2,
            'service' => 2,
            'smtp' => 3
        ];

        $this->post['Type'] = $types[$type];

        return $this;
    }

    /**
     * Set the name
     *
     * @param String $name
     * @return FactoryInterface
     * @throws \InvalidArgumentException
     */
    public function name(String $name): FactoryInterface
    {
        if (!preg_match('/^[A-Za-z0-9 .-]+$/', $name)) {
            throw new \InvalidArgumentException('Invalid name specified. Names can consist of: A-Za-z0-9, spaces, periods and dashes');
        }

        $this->post['Name'] = $name;

        return $this;
    }

    /**
     * Set the target (URL, IP, Hostname)
     *
     * @param String $target
     * @return FactoryInterface
     * @throws \InvalidArgumentException
     */
    public function target(String $target): FactoryInterface
    {
        if (!$this->isValidHostname($target) && !$this->isValidIp($target) && !$this->isValidUrl($target)) {
            throw new \InvalidArgumentException('Invalid target specified. Targets can be either a URL, a Hostname or an IP Address');
        }

        $this->post['Target'] = $target;

        return $this;
    }

    /**
     * Set the timeout
     *
     * @param int $timeout
     * @return FactoryInterface
     * @throws \InvalidArgumentException
     */
    public function timeout(int $timeout): FactoryInterface
    {
        if (!in_array($timeout, [3, 5, 10])) {
            throw new \InvalidArgumentException('Invalid timeout specified. Available timeouts: 3, 5, 10');
        }

        $this->post['Timeout'] = $timeout;

        return $this;
    }

    /**
     * Set the frequency
     *
     * @param int $frequency
     * @return FactoryInterface
     * @throws \InvalidArgumentException
     */
    public function frequency(int $frequency): FactoryInterface
    {
        if (!in_array($frequency, [1, 3, 5, 10])) {
            throw new \InvalidArgumentException('Invalid frequency specified. Available frequencies: 1, 3, 5, 10');
        }

        $this->post['Frequency'] = $frequency;

        return $this;
    }

    /**
     * Set the number of fails
     *
     * @param int $fails
     * @return FactoryInterface
     * @throws \InvalidArgumentException
     */
    public function failsBeforeAlert(int $fails): FactoryInterface
    {
        if ($fails < 1 || $fails > 3) {
            throw new \InvalidArgumentException('Invalid failsBeforeAlert specified. Must be >= 1, <= 3');
        }

        $this->post['FailsBeforeAlert'] = $fails;

        return $this;
    }

    /**
     * Set the amount of failed locations
     *
     * @param int|null $failed
     * @return FactoryInterface
     * @throws \InvalidArgumentException
     */
    public function failedLocations(?int $failed = null): FactoryInterface
    {
        if ($failed !== null && ($failed < 2 || $failed > 12)) {
            throw new \InvalidArgumentException('Invalid failedLocations specified. Must be >= 2, <= 12');
        }

        $this->post['FailedLocations'] = $failed;

        return $this;
    }

    /**
     * Set the contact list
     *
     * @param int|null $contactList
     * @return FactoryInterface
     */
    public function contactList(?int $contactList = null): FactoryInterface
    {
        $this->post['ContactList'] = $contactList;

        return $this;
    }

    /**
     * Set the category
     *
     * @param null|String $category
     * @return FactoryInterface
     */
    public function category(?String $category = null): FactoryInterface
    {
        $this->post['Category'] = $category;

        return $this;
    }

    /**
     * Set the amount of time before alerts
     *
     * @param int|null $time
     * @return FactoryInterface
     * @throws \InvalidArgumentException
     */
    public function alertAfter(?int $time = null): FactoryInterface
    {
        if ($time !== null && !in_array($time, [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 15, 20, 30, 40, 50, 60])) {
            throw new \InvalidArgumentException('Invalid alertAfter specified. Must be >= 1, <= 10, or 15, 20, 30, 40, 50, 60');
        }

        $this->post['AlertAfter'] = $time;

        return $this;
    }

    /**
     * Set the amount of repeated alerts
     *
     * @param int|null $times
     * @return FactoryInterface
     * @throws \InvalidArgumentException
     */
    public function repeatTimes(?int $times = null): FactoryInterface
    {
        if ($times !== null && ($times < 0 || $times > 30)) {
            throw new \InvalidArgumentException('Invalid repeatTimes specified. Must be >= 0, <= 30');
        }

        $this->post['RepeatTimes'] = $times;

        return $this;
    }

    /**
     * Set how often to repeat alerts
     *
     * @param int|null $every
     * @return FactoryInterface
     * @throws \InvalidArgumentException
     */
    public function repeatEvery(?int $every = null): FactoryInterface
    {
        if ($every !== null && !in_array($every, [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 15, 20, 30, 40, 50, 60])) {
            throw new \InvalidArgumentException('Invalid repeatEvery specified. Must be >= 1, <= 10, or 15, 20, 30, 40, 50, 60');
        }

        $this->post['RepeatEvery'] = $every;

        return $this;
    }

    /**
     * Define whether monitor is public
     *
     * @param bool $public
     * @return FactoryInterface
     */
    public function public(bool $public = false): FactoryInterface
    {
        $this->post['Public'] = $public;

        return $this;
    }

    /**
     * Define whether monitor displays its target
     *
     * @param bool $show
     * @return FactoryInterface
     */
    public function showTarget(bool $show = false): FactoryInterface
    {
        $this->post['ShowTarget'] = $show;

        return $this;
    }

    /**
     * Define whether SSL Certificates are verified
     *
     * @param bool $verify
     * @return FactoryInterface
     */
    public function verify_ssl_certificate(bool $verify = false): FactoryInterface
    {
        $this->post['VerSSLCert'] = $verify;

        return $this;
    }

    /**
     * Define whether SSL Hosts are verified.
     *
     * @param bool $verify
     * @return FactoryInterface
     */
    public function verify_ssl_host(bool $verify = false): FactoryInterface
    {
        $this->post['VerSSLHost'] = $verify;

        return $this;
    }

    /**
     * Specify an array of locations to monitor from.
     *
     * @param array $locations
     * @return FactoryInterface
     * @throws \InvalidArgumentException
     */
    public function locations(array $locations): FactoryInterface
    {
        array_filter($locations, function ($key, $value) {
            $available_locations = [
                'nyc',
                'sfo',
                'dal',
                'ams',
                'lon',
                'fra',
                'sgp',
                'syd',
                'sao',
                'tok',
                'mba',
                'msw'
            ];

            if (in_array($key, $available_locations) && is_bool($value)) {
                return true;
            }
            return false;
        }, ARRAY_FILTER_USE_BOTH);

        $locations = array_unique($locations);

        if (count($locations) < 3) {
            throw new \InvalidArgumentException('Invalid locations specified. Number of locations must be 3 or more.');
        }

        $this->post['Locations'] = $locations;

        return $this;
    }

    /**
     * Specify a keyword to look for
     *
     * @param null|String $keyword
     * @return FactoryInterface
     */
    public function keyword(?String $keyword = null): FactoryInterface
    {
        $this->post['Keyword'] = $keyword;

        return $this;
    }

    /**
     * Specify the max number of redirects
     *
     * @param int $redirects
     * @return FactoryInterface
     * @throws \InvalidArgumentException
     */
    public function maxRedirects(int $redirects): FactoryInterface
    {
        if ($redirects < 0 || $redirects > 10) {
            throw new \InvalidArgumentException('Invalid maxRedirects specified. Must be >= 0, <= 10');
        }

        $this->post['MaxRedirects'] = $redirects;

        return $this;
    }

    /**
     * Specify a port
     *
     * @param int $port
     * @return FactoryInterface
     * @throws \InvalidArgumentException
     */
    public function port(int $port): FactoryInterface
    {
        if ($port < 0 || $port > 65535) {
            throw new \InvalidArgumentException('Invalid port specified. Must be >= 0, <= 65535');
        }

        $this->post['Port'] = $port;

        return $this;
    }

    /**
     * Define whether SMTP should check Auth
     *
     * @param bool $check
     * @return FactoryInterface
     */
    public function checkAuth(bool $check = false): FactoryInterface
    {
        $this->post['CheckAuth'] = $check;

        return $this;
    }

    /**
     * Define the SMTP User for Auth
     *
     * @param String $user
     * @return FactoryInterface
     */
    public function smtpUser(String $user): FactoryInterface
    {
        $this->post['SMTPUser'] = $user;

        return $this;
    }

    /**
     * Define the SMTP Password for Auth.
     *
     * @param String $pass
     * @return FactoryInterface
     */
    public function smtpPass(String $pass): FactoryInterface
    {
        $this->post['SMTPPass'] = $pass;

        return $this;
    }
}
