<?php

namespace CmdrSharp\HetrixtoolsApi\Blacklist;

use Psr\Http\Message\ResponseInterface;

interface RepositoryInterface
{
    /**
     * @param int|null $page
     * @param int|null $per_page
     * @return ResponseInterface
     */
    public function listMonitors(?int $page = null, ?int $per_page = null): ResponseInterface;

    /**
     * @param String $target
     * @param null|String $date
     * @return ResponseInterface
     */
    public function blacklistReport(String $target, ?String $date = null): ResponseInterface;

    /**
     * @param String $target
     * @return ResponseInterface
     */
    public function manualCheck(String $target): ResponseInterface;
}