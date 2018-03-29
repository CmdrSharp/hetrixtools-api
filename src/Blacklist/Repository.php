<?php
declare(strict_types=1);

namespace CmdrSharp\HetrixtoolsApi\Blacklist;

use CmdrSharp\HetrixtoolsApi\Traits\Validator;
use CmdrSharp\HetrixtoolsApi\AbstractApi;
use Psr\Http\Message\ResponseInterface;

class Repository extends AbstractApi implements RepositoryInterface
{
    use Validator;

    /** @var string */
    private $apiKey;

    /**
     * Factory constructor.
     * @param String $apiKey
     */
    public function __construct(String $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * @param int|null $page
     * @param int|null $per_page
     * @return ResponseInterface
     * @throws \ErrorException
     */
    public function listMonitors(?int $page = null, ?int $per_page = null): ResponseInterface
    {
        $uri = 'blacklist/monitors/';

        if ($page === null) {
            $uri .= '0/';
        }

        if ($per_page === null) {
            $uri .= '100/';
        }

        return AbstractApi::get($this->apiKey, 'v2', $uri);
    }

    /**
     * @param String $target
     * @param null|String $date
     * @return ResponseInterface
     * @throws \ErrorException
     */
    public function blacklistReport(String $target, ?String $date = null): ResponseInterface
    {
        if (!$this->isValidIp($target) && !$this->isValidHostname($target)) {
            throw new \InvalidArgumentException('Target must be an IP, or a Hostname');
        }

        $uri = 'blacklist/report/' . $target . '/';

        if ($date !== null) {
            if (!$this->isValidDate($date)) {
                throw new \InvalidArgumentException('The date specified must be a valid YYYY-MM-DD format');
            }

            $uri .= $date . '/';
        }

        return AbstractApi::get($this->apiKey, 'v2', $uri);
    }

    /**
     * @param String $target
     * @return ResponseInterface
     * @throws \ErrorException
     */
    public function manualCheck(String $target): ResponseInterface
    {
        if ($this->isValidIp($target)) {
            $type = 'ipv4';
        } elseif ($this->isValidHostname($target)) {
            $type = 'domain';
        } else {
            throw new \InvalidArgumentException('Target must be an IP, or a Hostname');
        }

        $uri = 'blacklist-check/' . $type . '/' . $target . '/';

        return AbstractApi::get($this->apiKey, 'v2', $uri);
    }
}
