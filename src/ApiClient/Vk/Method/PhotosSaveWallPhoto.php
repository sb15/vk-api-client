<?php

namespace Sb\ApiClient\Vk\Method;

class PhotosSaveWallPhoto extends AbstractMethod
{
    const METHOD = 'photos.saveWallPhoto';

    private $publicId = null;
    private $uploadUrl = null;
    private $file = null;

    /**
     * @return null
     */
    public function getPublicId()
    {
        return $this->publicId;
    }

    /**
     * @param null $publicId
     * @return $this
     */
    public function setPublicId($publicId)
    {
        $this->publicId = $publicId;

        return $this;
    }

    /**
     * @return null
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param null $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * @return null
     */
    public function getUploadUrl()
    {
        return $this->uploadUrl;
    }

    /**
     * @param null $uploadUrl
     * @return $this
     */
    public function setUploadUrl($uploadUrl)
    {
        $this->uploadUrl = $uploadUrl;

        return $this;
    }


    public function call()
    {
        $response = $this->getApiClient()->curl($this->getUploadUrl(), true, [
            'photo' => new \CurlFile(realpath($this->getFile()))
        ]);

        $response = json_decode($response);

        $response = $this->getApiClient()->api(self::METHOD, [
            'group_id' => $this->getPublicId(),
            'photo' => $response->photo,
            'server' => $response->server,
            'hash' => $response->hash,
        ]);

        return $response[0]->id;
    }
}