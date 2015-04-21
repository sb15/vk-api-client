<?php

namespace Sb\ApiClient\Vk\Method;

abstract class AbstractMethod
{
    private $apiClient = null;

    public function __construct($apiClient)
    {
        $this->apiClient = $apiClient;
    }

    /**
     * @return \Sb\ApiClient\Vk
     */
    public function getApiClient()
    {
        return $this->apiClient;
    }
}

