<?php

namespace Spruthub\Entity;

use Spruthub\Sdk;
use Spruthub\Entity\Common\AbstractEntity;
use Spruthub\Entity\Common\ServerLoginInterface;

class ServerLogin extends AbstractEntity implements ServerLoginInterface
{
    private $email;
    private $password;

    public function __construct(string $apiurl, string $email, string $password) {
        $this->apiurl = $apiurl;
        $this->email = $email;
        $this->password = $password;
    }

    protected static function defineProperties() {
        return [
            'token' => [],
        ];
    }

    /**
     * @param int $id
     *
     * @return Room
     */
    public function requestInstance(string $email, string $password) {
        $url = $this->apiurl . "/server/login/{$email}";
        $method = 'post';
        $postfields = $password;
        return Sdk::instance()->requestJson($url, null, $method, $postfields);
    }
}