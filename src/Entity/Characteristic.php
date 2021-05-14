<?php

namespace Spruthub\Entity;
use Spruthub\Entity\Common\AbstractEntity;
use Spruthub\Entity\Common\CharacteristicInterface;


/**
 * Class Characteristic
 *
 * @property int $id
 * @property string $cl
 * @property array $name
 * @property string $type
 * @property string $gType
 * @property string $yType
 * @property string $mType
 * @property string $format
 * @property bool $writable
 * @property bool $readable
 * @property string $description
 * @property string $value
 *
 */
class Characteristic extends AbstractEntity implements CharacteristicInterface {

    protected static function defineProperties() {
        return [
            'id' => [],
            'cl' => [],
            'name' => [],
            'type' => [],
            'gType' => [],
            'yType' => [],
            'mType' => [],
            'format' => [],
            'writable' => [],
            'readable' => [],
            'description' => [],
            'value' => [],
        ];
    }

    /**
     * @param int $accessoryid
     *
     * @return Characteristic[]
     */
    public function requestInstances(int $accessoryid, int $serviceid) {
        return parent::defaultRequestInstances("/accessories/{$accessoryid}/services/{$serviceid}/characteristics");
    }

    /**
     * @param int $id
     * @param int $accessoryid
     *
     * @return Characteristic
     */
    public function requestInstance(int $id, int $accessoryid)
    {
        return parent::defaultRequestInstance("/accessories/{$accessoryid}/characteristics/{$id}");
    }
}