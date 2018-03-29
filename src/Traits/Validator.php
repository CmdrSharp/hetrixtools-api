<?php

namespace CmdrSharp\HetrixtoolsApi\Traits;

trait Validator
{
    /**
     * Validates whether the input is a valid IP.
     *
     * @param String $input
     * @return bool
     */
    public function isValidIp(String $input)
    {
        return filter_var($input, FILTER_VALIDATE_IP) ? true : false;
    }

    /**
     * Validates whether the input is a valid CIDR.
     *
     * @param String $input
     * @return bool
     */
    public function isValidCidr(String $input)
    {
        if (!preg_match("/^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}(\/[0-9]{1,2})?$/", $input)) {
            return false;
        }

        $parts = explode("/", $input);
        $ip = $parts[0];
        $cidr = isset($parts[1]) ? $parts[1] : null;
        $octets = explode(".", $ip);

        foreach ($octets as $octet) {
            if ($octet > 255) {
                return false;
            }
        }

        if ($cidr && $cidr > 32) {
            return false;
        }

        return true;
    }

    /**
     * Validates whether the input is a valid hostname.
     *
     * @param String $input
     * @return bool
     */
    public function isValidHostname(String $input)
    {
        return preg_match(
            '/(?=^.{4,253}$)(^((?!-)[a-zA-Z0-9-]{1,63}(?<!-)\.)+[a-zA-Z]{2,63}$)/',
            $input
        ) ? true : false;
    }

    /**
     * Validates whether the input is a valid URL
     *
     * @param String $input
     * @return bool
     */
    public function isValidUrl(String $input)
    {
        return filter_var($input, FILTER_VALIDATE_URL) ? true : false;
    }
}
