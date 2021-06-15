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
 * @property string $cl
 * @property string $appleType
 * @property array $appleTypeName
 * @property string $googleType
 * @property string $yandexType
 * @property string $mailRuType
 * @property bool $hidden
 * @property Characteristic[] $characteristics
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
            'hidden' => [],
            'characteristics' => [],
        ];
    }

    /**
     * @param int $accessoryid
     *
     * @return Service[]
     */
    public function requestInstances(int $accessoryid, string $expand='characteristics') {
        return parent::defaultRequestInstances("/accessories/{$accessoryid}/services?expand={$expand}");
    }

    /**
     * @param int $id
     * @param int $accessoryid
     *
     * @return Service
     */
    public function requestInstance(int $id, int $accessoryid, string $expand='characteristics')
    {
        return parent::defaultRequestInstance("/accessories/{$accessoryid}/services/{$id}?expand={$expand}");
    }


    /**
     * @param array $objectdata
     */
    public function fillInstance(array $objectdata) {
        if (array_key_exists('characteristics', $objectdata)) {
            $characteristics = [];
            foreach($objectdata['characteristics'] as $characteristicdata) {
                $characteristic = new Characteristic($this->apiurl);
                $characteristic->fillInstance($characteristicdata);
                $characteristics[] = $characteristic;
            }
            $this->__set('characteristics', $characteristics);
            unset($objectdata['characteristics']);
        }
        parent::fillInstance($objectdata);
    }

    public function export() {
        $result = parent::export();
        if (array_key_exists('characteristics', $result)) {
            foreach($result['characteristics'] as $k => $characteristic) {
                $result['characteristics'][$k] = $characteristic->export();
            }
        }
        return $result;
    }
}