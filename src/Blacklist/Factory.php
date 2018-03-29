<?php
declare(strict_types=1);

namespace CmdrSharp\HetrixtoolsApi\Blacklist;

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
     * @param String $apiKey
     */
    public function __construct(String $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * Create a Blacklist Monitor
     *
     * @return ResponseInterface
     * @throws \ErrorException
     */
    public function create(): ResponseInterface
    {
        return AbstractApi::post($this->apiKey, 'v2', 'blacklist/add/', $this->post);
    }

    /**
     * Edit a Blacklist Monitor
     *
     * @return ResponseInterface
     * @throws \ErrorException
     */
    public function patch(): ResponseInterface
    {
        return AbstractApi::post($this->apiKey, 'v2', 'blacklist/edit/', $this->post);
    }

    /**
     * Delete a Blacklist Monitor
     *
     * @return ResponseInterface
     * @throws \ErrorException
     */
    public function delete(): ResponseInterface
    {
        return AbstractApi::post($this->apiKey, 'v2', 'blacklist/delete/', $this->post);
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
        if (!$this->isValidIP($target) && !$this->isValidCidr($target) && !$this->isValidHostname($target)) {
            throw new \InvalidArgumentException('Invalid target specified. Targets can be either a Hostname, an IP Address, or a CIDR Range');
        }

        $this->post['target'] = $target;

        return $this;
    }

    /**
     * Set the label
     *
     * @param String $label
     * @return FactoryInterface
     * @throws \InvalidArgumentException
     */
    public function label(String $label): FactoryInterface
    {
        if (!preg_match('/^[A-Za-z0-9 .-]+$/', $label)) {
            throw new \InvalidArgumentException('Invalid label specified. Labels can consist of: A-Za-z0-9, spaces, periods and dashes');
        }

        $this->post['label'] = $label;

        return $this;
    }

    /**
     * Set the contact
     *
     * @param int|null $contact
     * @return FactoryInterface
     */
    public function contact(?int $contact = null): FactoryInterface
    {
        $this->post['contact'] = $contact;

        return $this;
    }
}
