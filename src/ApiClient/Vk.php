<?php

namespace Sb\ApiClient;

class Vk
{
    private $accessToken;

    const PARAM_ACCESS_TOKEN = 'access_token';

    protected $methods = [];

    public function __construct($params)
    {
        if (isset($params[self::PARAM_ACCESS_TOKEN])) {
            $this->setAccessToken($params[self::PARAM_ACCESS_TOKEN]);
        }
    }

    public function setAccessToken($token)
    {
        $this->accessToken = $token;

        return $this;
    }

    public function getAccessToken()
    {
        return $this->accessToken;
    }

    public function api($method, $params = [])
    {
        $params[self::PARAM_ACCESS_TOKEN] = $this->getAccessToken();
        $url = 'https://api.vk.com/method/' . $method . '?' . http_build_query($params);
        $result = json_decode($this->curl($url));

        if (isset($result->response)) {

            // process captcha
            /*'captcha_sid' => '',
            'captcha_key' => ''*/

            return $result->response;
        }

        return $result;
    }

    public function curl($url, $post = false, $params = [])
    {
        // create curl resource
        $ch = curl_init();

        // set url
        curl_setopt($ch, CURLOPT_URL, $url);
        
        // return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        // disable SSL verifying
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        

        if ($post) {
            curl_setopt($ch, CURLOPT_POST, 1);
        }

        if (!empty($params)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        }

        // $output contains the output string
        $result = curl_exec($ch);

        if (!$result) {
            $errno = curl_errno($ch);
            $error = curl_error($ch);
        }

        // close curl resource to free up system resources
        curl_close($ch);

        if (isset($errno) && isset($error)) {
            throw new \Exception($error, $errno);
        }

        return $result;
    }


    /**
     * @param bool $newInstance
     * @return Vk\Method\WallPost
     */
    public function getMethodWallPost($newInstance = false)
    {
        if ($newInstance || !array_key_exists(Vk\Method\WallPost::METHOD, $this->methods)) {
            $this->methods[Vk\Method\WallPost::METHOD] = new Vk\Method\WallPost($this);
        }
        return $this->methods[Vk\Method\WallPost::METHOD];
    }

    /**
     * @param bool $newInstance
     * @return Vk\Method\PhotosGetWallUploadServer
     */
    public function getMethodPhotosGetWallUploadServer($newInstance = false)
    {
        if ($newInstance || !array_key_exists(Vk\Method\PhotosGetWallUploadServer::METHOD, $this->methods)) {
            $this->methods[Vk\Method\PhotosGetWallUploadServer::METHOD] = new Vk\Method\PhotosGetWallUploadServer($this);
        }
        return $this->methods[Vk\Method\PhotosGetWallUploadServer::METHOD];
    }

    /**
     * @param bool $newInstance
     * @return Vk\Method\PhotosSaveWallPhoto
     */
    public function getMethodPhotosSaveWallPhoto($newInstance = false)
    {
        if ($newInstance || !array_key_exists(Vk\Method\PhotosSaveWallPhoto::METHOD, $this->methods)) {
            $this->methods[Vk\Method\PhotosSaveWallPhoto::METHOD] = new Vk\Method\PhotosSaveWallPhoto($this);
        }
        return $this->methods[Vk\Method\PhotosSaveWallPhoto::METHOD];
    }

}