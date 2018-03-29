<?php
declare(strict_types=1);

namespace CmdrSharp\HetrixtoolsApi\Uptime;

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
     *
     * @param String $apiKey
     */
    public function __construct(String $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * @return ResponseInterface
     * @throws \ErrorException
     */
    public function status(): ResponseInterface
    {
        return AbstractApi::get($this->apiKey, 'v1', 'status/');
    }

    /**
     * @param int|null $page
     * @param int|null $per_page
     * @return ResponseInterface
     * @throws \ErrorException
     */
    public function listUptimeMonitors(?int $page = null, ?int $per_page = null): ResponseInterface
    {
        $uri = 'uptime/monitors/';

        if ($page !== null) {
            $uri .= $page . '/';
        }

        if ($per_page !== null) {
            $uri .= $per_page . '/';
        }

        return AbstractApi::get($this->apiKey, 'v1', $uri);
    }

    /**
     * @param String $id
     * @return ResponseInterface
     * @throws \ErrorException
     */
    public function uptimeReport(String $id): ResponseInterface
    {
        return AbstractApi::get($this->apiKey, 'v1', 'uptime/report/' . $id);
    }

    /**
     * @return ResponseInterface
     * @throws \ErrorException
     */
    public function listContacts(): ResponseInterface
    {
        return AbstractApi::get($this->apiKey, 'v1', 'contacts/');
    }
}
