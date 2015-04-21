<?php

namespace Sb\ApiClient\Vk\Method;

use Sb\ApiClient\Vk\Attachment\Link;
use Sb\ApiClient\Vk\Attachment\Photo;

class WallPost extends AbstractMethod
{
    protected $message = null;
    protected $tags = [];
    protected $ownerId = null;
    protected $fromGroup = 1;
    protected $attachments = [];

    const METHOD = 'wall.post';

    /**
     * @return null
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param null $message
     * @return $this
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return array
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param array $tags
     * @return $this
     */
    public function setTags($tags)
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * @return null
     */
    public function getOwnerId()
    {
        return $this->ownerId;
    }

    /**
     * @param null $ownerId
     * @return $this
     */
    public function setOwnerId($ownerId)
    {
        $this->ownerId = $ownerId;

        return $this;
    }

    public function setPublicId($publicId)
    {
        $this->ownerId = -$publicId;

        return $this;
    }


    /**
     * @return int
     */
    public function getFromGroup()
    {
        return $this->fromGroup;
    }

    /**
     * @param int $fromGroup
     * @return $this
     */
    public function setFromGroup($fromGroup)
    {
        $this->fromGroup = $fromGroup;

        return $this;
    }

    /**
     * @return array
     */
    public function getAttachments()
    {
        return $this->attachments;
    }

    /**
     * @param array $attachments
     * @return $this
     */
    public function setAttachments($attachments)
    {
        $this->attachments = $attachments;

        return $this;
    }

    public function addTag($tag)
    {
        $this->tags[] = trim($tag);

        return $this;
    }

    public function addAttachmentPhoto($fileName)
    {
        $attachmentObject = new Photo($this->getApiClient());
        $attachmentObject->setPublicId($this->getOwnerId());
        $attachmentObject->setAttachment($fileName);

        $this->attachments[] = $attachmentObject;

        return $this;
    }

    public function addAttachmentLink($link)
    {
        $attachmentObject = new Link($this->getApiClient());
        $attachmentObject->setAttachment($link);

        $this->attachments[] = $attachmentObject;

        return $this;
    }

    protected function getAttachmentsForCall()
    {
        $result = [];

        $attachments = $this->getAttachments();

        /** @var \Sb\ApiClient\Vk\Attachment\AbstractAttachment $attachment */
        foreach ($attachments as $attachment) {
            $result[] = $attachment->getId();
        }

        return $result ? implode(",", $result) : false;
    }

    protected function getMessageWithTags()
    {
        $text = $this->getMessage();
        $tags = $this->getTags();

        if ($text && $tags) {
            $text .= "\n\n";
        }
        foreach ($tags as $tag) {
            $text .= ' #' . str_replace(' ', '_', $tag);
        }

        return html_entity_decode(trim($text));
    }

    public function call()
    {
        $attachments = $this->getAttachmentsForCall();
        $callParams = [
            'owner_id' => $this->getOwnerId(),
            'from_group' => $this->getFromGroup(),
            'message' => $this->getMessageWithTags(),
        ];
        if ($attachments) {
            $callParams['attachments'] = $attachments;
        }

        $response = $this->getApiClient()->api(self::METHOD, $callParams);
        return $response->post_id;
    }

}