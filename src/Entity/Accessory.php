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
 * @property int $deviceId
 * @property bool $hasOptions
 * @property bool $hidden
 * @property string
 * @property string
 */
class Accessory extends AbstractEntity implements EntityInterface {

    protected static function defineProperties() {
        return [
            'id' => [],
            'name' => [],
            'rawName' => [],
            'controller' => [],
            'roomId' => [],
            'deviceId' => [],
            'hasOptions' => [],
            'hidden' => [],
        ];
    }

    /**
     * @return Accessory[]
     */
    public function requestInstances() {
        return parent::defaultRequestInstances("/accessories");
    }

    /**
     * @param int $id
     *
     * @return Accessory
     */
    public function requestInstance(int $id) {
        return parent::defaultRequestInstance("/accessories/{$id}");
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
}