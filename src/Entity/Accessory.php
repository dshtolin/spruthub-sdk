<?php

namespace Spruthub\Entity;

use Spruthub\AbstractRoom;
use Spruthub\Entity\Common\AbstractEntity;
use Spruthub\Entity\Common\EntityInterface;

/**
 * Class AbstractAccessory
 *
 * @property int $id
 * @property string $name
 * @property string $rawName
 * @property string $controller
 * @property int $roomId
 * @property string $roomName
 * @property int $deviceId
 * @property bool $hasOptions
 * @property bool $hidden
 * @property Service[] $services
 */
class Accessory extends AbstractEntity implements EntityInterface {

    protected static function defineProperties() {
        return [
            'id' => [],
            'name' => [],
            'rawName' => [],
            'controller' => [],
            'roomId' => [],
            'roomName' => [],
            'deviceId' => [],
            'hasOptions' => [],
            'hidden' => [],
            'services' => [],
        ];
    }

    /**
     * @return Accessory[]
     */
    public function requestInstances(string $expand='services,characteristics') {
        return parent::defaultRequestInstances("/accessories?expand={$expand}");
    }

    /**
     * @param int $id
     *
     * @return Accessory
     */
    public function requestInstance(int $id, string $expand='services,characteristics') {
        return parent::defaultRequestInstance("/accessories/{$id}?expand={$expand}");
    }

    /**
     * @param int $roomId
     */
    public function requestRoomInstances(int $roomId) {
        $accessories = $this->requestInstances();
        foreach($accessories as $n => $accessory) {
            if ($accessory->roomId != $roomId) {
                unset($accessories[$n]);
            }
        }
        return $accessories;
    }

    /**
     * @param array $objectdata
     */
    public function fillInstance(array $objectdata) {
        if (array_key_exists('services', $objectdata)) {
            $services = [];
            foreach($objectdata['services'] as $servicedata) {
                $service = new Service($this->apiurl);
                $service->fillInstance($servicedata);
                $services[] = $service;
            }
            $this->__set('services', $services);
            unset($objectdata['services']);
        }
        parent::fillInstance($objectdata);
    }

    public function export() {
        $result = parent::export();
        if (array_key_exists('services', $result)) {
            foreach($result['services'] as $k => $service) {
                $result['services'][$k] = $service->export();
            }
        }
        return $result;
    }
}