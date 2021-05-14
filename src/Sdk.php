<?php

namespace Spruthub;

/**
 * Class Sdk
 *
 * @property \Spruthub\Entity\Accessory $accessory
 * @property \Spruthub\Entity\Room $room
 * @property \Spruthub\Entity\Service $service
 * @property \Spruthub\Entity\ServerLogin $serverLogin
 * @property \Spruthub\Entity\Characteristic $characteristic
 * @property \Spruthub\Entity\Device $device
 *
 */
class Sdk {

    private static $instance;
    private $entities = [];
    private $apiurl;
    private $email;
    private $password;

    protected function __construct(string $apiurl, string $email, string $password) {
        $this->apiurl = $apiurl;
        $this->email = $email;
        $this->password = $password;

        foreach(['Room', 'Accessory', 'Service', 'ServerLogin', 'Characteristic', 'Device'] as $entity) {
            $entityclass = '\\Spruthub\\Entity\\'.$entity;
            if (class_exists($entityclass)) {
                if ($entity == 'ServerLogin')
                {
                    $this->entities[$entity] = new $entityclass($this->apiurl, $this->email, $this->password);
                } else {
                    $this->entities[$entity] = new $entityclass($this->apiurl);
                }
            }
        }
    }

    public static function instance(string $apiurl=null, string $email=null, string $password=null) : Sdk
    {
        if (!isset(self::$instance)) {
            self::$instance = new static($apiurl, $email, $password);
        }

        return self::$instance;
    }

    public function __get($property) {

        if (array_key_exists(ucfirst($property), $this->entities)) {
            return $this->entities[ucfirst($property)];
        }
        return null;
    }

    public function getAuthorizationHeader() {
        $authdata = $this->entities['ServerLogin']->requestInstance($this->email, $this->password);
        return 'Authorization: Authorization ' . $authdata['token'];
    }


    public function requestJson(string $url, array $headers=null, string $method='get', $postfields=null) {
        $responsejson = $this->request($url, $headers, $method, $postfields);
        return json_decode($responsejson, true);
    }

    public function request(string $url, array $headers=null, string $method='get', $postfields=null)
    {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        // curl_setopt($ch, CURLOPT_VERBOSE, true);

        if (!is_null($headers)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }

        switch (strtolower($method))
        {
            case 'post':
                curl_setopt($ch, CURLOPT_POST, true);
                break;
            case 'put':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
                break;
            case 'delete':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
                break;
            case 'get':
            default:
                curl_setopt($ch, CURLOPT_HTTPGET, true);
                break;
        }

        if (!is_null($postfields))
        {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
        }

        $response = curl_exec($ch);

        $curlerror = curl_error($ch);
        curl_close ($ch);

        if ($curlerror) {
            throw new \Exception("cURL Error #:" . $curlerror);
        }

        return $response;
    }
}