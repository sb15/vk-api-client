# vk-api-client

```
    $accessToken = '';
    $publicId = '';
    $vk = new \Sb\ApiClient\Vk(['access_token' => $accessToken]);
    $vk->getMethodWallPost()
        ->setPublicId($publicId)
        ->setMessage('message')
        ->addTag('tag')  
        ->addAttachmentPhoto(realpath('/tmp/1.jpg'))
        ->addAttachmentLink('http://link.com')
        ->call();
```
