<?php

namespace Spruthub\Entity;
use Spruthub\Entity\Common\AbstractEntity;
use Spruthub\Entity\Common\CharacteristicInterface;
use Spruthub\Sdk;


/**
 * Class Characteristic
 *
 * @property int $id
 * @property int $a_id
 * @property int $s_id
 * @property string $cl
 * @property array $name
 * @property string $type
 * @property string $gType
 * @property string $yType
 * @property string $mType
 * @property string $format
 * @property bool $writable
 * @property bool $readable
 * @property int|float|null $minValue
 * @property int|float|null $maxValue
 * @property int|float|null $minStep
 * @property array|null validValues
 * @property string $description
 * @property string $value
 *
 */
class Characteristic extends AbstractEntity implements CharacteristicInterface {

    protected static function defineProperties() {
        return [
            'id' => [],
            'a_id' => [],
            's_id' => [],
            'cl' => [],
            'name' => [],
            'type' => [],
            'gType' => [],
            'yType' => [],
            'mType' => [],
            'format' => [],
            'writable' => [],
            'readable' => [],
            'minValue' => [],
            'maxValue' => [],
            'minStep' => [],
            'validValues' => [],
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

    public function newValue    ($value) {

        $accessoryid = $this->a_id;
        $characteristicid = $this->id;
        $apiurlpath = "/accessories/{$accessoryid}/characteristics/{$characteristicid}/value";
        $url = $this->apiurl . $apiurlpath;
        $headers = [Sdk::instance()->getAuthorizationHeader()];
        Sdk::instance()->requestJson($url, $headers, 'put', $value);
    }
}