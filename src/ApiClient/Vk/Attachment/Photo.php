<?php

namespace Sb\ApiClient\Vk\Attachment;

use \Sb\ApiClient\Exception\FileNotFound;

class Photo extends AbstractAttachment
{

    private $publicId = null;

    public function setAttachment($attachment)
    {
        if (!is_file($attachment)) {
            throw new FileNotFound;
        }

        $this->attachment = $attachment;
    }

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
        $this->publicId = abs($publicId);

        return $this;
    }

    public function getId()
    {
        $photosGetWallUploadServer = $this->getApiClient()->getMethodPhotosGetWallUploadServer();
        $photosGetWallUploadServer->setPublicId($this->getPublicId());
        $uploadUrl = $photosGetWallUploadServer->call();

        $photosSaveWallPhoto = $this->getApiClient()->getMethodPhotosSaveWallPhoto();
        $photosSaveWallPhoto->setPublicId($this->getPublicId());
        $photosSaveWallPhoto->setUploadUrl($uploadUrl);
        $photosSaveWallPhoto->setFile($this->getAttachment());

        return $photosSaveWallPhoto->call();
    }
}