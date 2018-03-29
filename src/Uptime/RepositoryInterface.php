<?php

namespace CmdrSharp\HetrixtoolsApi\Uptime;

use Psr\Http\Message\ResponseInterface;

interface RepositoryInterface
{
    /**
     * @return ResponseInterface
     */
    public function status(): ResponseInterface;

    /**
     * @param int|null $page
     * @param int|null $per_page
     * @return ResponseInterface
     */
    public function listUptimeMonitors(?int $page = null, ?int $per_page = null): ResponseInterface;

    /**
     * @param String $id
     * @return ResponseInterface
     */
    public function uptimeReport(String $id): ResponseInterface;

    /**
     * @return ResponseInterface
     */
    public function listContacts(): ResponseInterface;
}
