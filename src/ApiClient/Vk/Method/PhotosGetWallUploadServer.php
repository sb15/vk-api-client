<?php


namespace Sb\ApiClient\Vk\Method;

class PhotosGetWallUploadServer extends AbstractMethod
{
    const METHOD = 'photos.getWallUploadServer';

    private $publicId = null;

    /**
     * @return null
     */
    public function getPublicId()
    {
        return $this->publicId;
    }

    /**
     * @param null $publicId
     */
    public function setPublicId($publicId)
    {
        $this->publicId = $publicId;
    }

    public function call()
    {
        $response = $this->getApiClient()->api(self::METHOD, [
            'group_id' => $this->getPublicId(),
        ]);

        var_dump($response);

        return $response->upload_url;
    }
}