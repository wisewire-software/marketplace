<?php

/**
 * Created by PhpStorm.
 * User: ptocto
 * Date: 23/02/2016
 * Time: 10:16
 */
class WP_Intercom
{
    private $apiEndpoint = 'https://api.intercom.io/';
    private $apiPing = 'https://api-ping.intercom.io/';
    private $appId = null;
    private $apiKey = null;


    public function getUserAnonymous()
    {
        $data['app_id'] = $this->appId;
        return $this->httpCall($this->apiPing . 'ping', 'POST', json_encode($data));
    }

    public function __construct($appId, $appKey = null)
    {
        $this->appId = $appId;
        $this->apiKey = $appKey;
    }

    protected function httpCall($url, $method = 'GET', $post_data = null)
    {
        $headers = array('Accept:application/json', 'Content-Type: application/json');

        $ch = curl_init($url);

        if ($method == 'POST') {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
            curl_setopt($ch, CURLOPT_POST, true);
        }

        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_BUFFERSIZE, 4096);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);

        if ($this->appId && $this->apiKey) {
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_USERPWD, $this->appId . ':' . $this->apiKey);
        }

        $response = curl_exec($ch);

        return json_decode($response);
    }

    public function createMessage($user_id, $body)
    {
        $data = array();
        $data['body'] = $body;
        $data['from']['id'] = $user_id;
        $data['from']['type'] = 'user';

        return $this->httpCall($this->apiEndpoint . 'messages', 'POST', json_encode($data));
    }

    public function createUpdateUser($email, $isUser, $firstName, $lastName, $phone, $company, $title, $comments)
    {
        $data = array();
        $data['email'] = $email;
        if (!is_null($phone) && trim($phone) !== '') {
            $data['phone'] = $phone;
        }
        if (!is_null($firstName) && trim($firstName) !== '' && !is_null($lastName) && trim($lastName) !== '') {
            $data['name'] = $firstName . ' ' . $lastName;
        }
        $data['custom_attributes'] = array();
        if (!is_null($company) && trim($company) !== '') {
            $data['custom_attributes']['Company'] = $company;
        }
        if (!is_null($title) && trim($title) !== '') {
            $data['custom_attributes']['job_title'] = $title;
        }
        if (!is_null($comments) && trim($comments) !== '') {
            $data['custom_attributes']['Notes'] = $comments;
        }
        return $this->httpCall($this->apiEndpoint . ($isUser ? 'users' : 'contacts'), 'POST', json_encode($data));
    }
}