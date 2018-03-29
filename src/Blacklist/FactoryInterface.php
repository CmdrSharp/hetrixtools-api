<?php

namespace CmdrSharp\HetrixtoolsApi\Blacklist;

use Psr\Http\Message\ResponseInterface;

interface FactoryInterface
{
    /**
     * @return ResponseInterface
     * @throws \ErrorException
     * @throws \InvalidArgumentException
     */
    public function create(): ResponseInterface;

    /**
     * @return ResponseInterface
     * @throws \ErrorException
     * @throws \InvalidArgumentException
     */
    public function patch(): ResponseInterface;

    /**
     * @return ResponseInterface
     * @throws \ErrorException
     * @throws \InvalidArgumentException
     */
    public function delete(): ResponseInterface;

    /**
     * @param String $target
     * @return FactoryInterface
     * @throws \InvalidArgumentException
     */
    public function target(String $target): FactoryInterface;

    /**
     * @param String $label
     * @return FactoryInterface
     * @throws \InvalidArgumentException
     */
    public function label(String $label): FactoryInterface;

    /**
     * @param int|null $contactList
     * @return FactoryInterface
     */
    public function contact(?int $contactList = null): FactoryInterface;
}
