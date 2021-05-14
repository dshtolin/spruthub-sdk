<?php

namespace Spruthub\Entity;
use Spruthub\Entity\Common\AbstractEntity;
use Spruthub\Entity\Common\CharacteristicInterface;
use Spruthub\Entity\Common\DeviceInterface;


/**
 * Class Device
 *
 * @property string $id
 * @property string $name
 * @property string $manufacturer
 * @property string $model
 *
 */
class Device extends AbstractEntity implements DeviceInterface {

    protected static function defineProperties() {
        return [
            'id' => [],
            'name' => [],
            'manufacturer' => [],
            'model' => [],
        ];
    }

    /**
     * @param int $accessoryid
     *
     * @return Device[]
     */
    public function requestInstances(string $controller) {
        return parent::defaultRequestInstances("/controllers/{$controller}/devices");
    }

    /**
     * @param int $id
     * @param int $accessoryid
     *
     * @return Device
     */
    public function requestInstance(string $id, string $controller)
    {
        $devices = $this->requestInstances($controller);
        foreach($devices as $device) {
            if ($id == explode('/', $device->id)[1]) {
                return $device;
            }
        }
        return null;
    }
}