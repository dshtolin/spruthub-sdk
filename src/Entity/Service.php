<?php

namespace Spruthub\Entity;
use Spruthub\Entity\Common\AbstractEntity;
use Spruthub\Entity\Common\ServiceInterface;

/**
 * Class AbstractService
 *
 * @property int $id
 * @property int $a_id
 * @property string $name
 * @property string $rawName
 * @property string cl
 * @property string appleType
 * @property array appleTypeName
 * @property string googleType
 * @property string yandexType
 * @property string mailRuType
 * @property bool hidden
 */
class Service extends AbstractEntity implements ServiceInterface {

    protected static function defineProperties() {
        return [
            'id' => [],
            'a_id' => [],
            'name' => [],
            'rawName' => [],
            'cl' => [],
            'appleType' => [],
            'appleTypeName' => [],
            'googleType' => [],
            'yandexType' => [],
            'mailRuType' => [],
            'hidden' => []
        ];
    }

    /**
     * @param int $accessoryid
     *
     * @return Service[]
     */
    public function requestInstances(int $accessoryid) {
        return parent::defaultRequestInstances("/accessories/{$accessoryid}/services");
    }

    /**
     * @param int $id
     * @param int $accessoryid
     *
     * @return Service
     */
    public function requestInstance(int $id, int $accessoryid)
    {
        return parent::defaultRequestInstance("/accessories/{$accessoryid}/services/{$id}");
    }
}