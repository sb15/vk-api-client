<?php

namespace Sb\ApiClient\Vk\Attachment;

abstract class AbstractAttachment
{
    private $apiClient = null;
    protected $attachment = null;

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

    /**
     * @return null
     */
    public function getAttachment()
    {
        return $this->attachment;
    }

    /**
     * @param null $attachment
     * @return $this
     */
    public function setAttachment($attachment)
    {
        $this->attachment = $attachment;

        return $this;
    }

    abstract public function getId();
}