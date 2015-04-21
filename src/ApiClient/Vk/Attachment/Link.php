<?php

namespace Sb\ApiClient\Vk\Attachment;

class Link extends AbstractAttachment
{
    public function getId()
    {
        return $this->attachment;
    }
}