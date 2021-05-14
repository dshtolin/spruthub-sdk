<?php

namespace Spruthub\Entity;
use Spruthub\Entity\Common\AbstractEntity;
use Spruthub\Entity\Common\EntityInterface;


/**
 * Class AbstractRoom
 *
 * @property int $id
 * @property string $name
 * @property string $rawName
 */
class Room extends AbstractEntity implements EntityInterface {

    protected static function defineProperties() {
        return [
            'id' => [],
            'name' => [],
            'rawName' => []
        ];
    }

    /**
     * @return Room[]
     */
    public function requestInstances() {
        return parent::defaultRequestInstances("/rooms");
    }

    /**
     * @param int $id
     *
     * @return Room
     */
    public function requestInstance(int $id) {
        return parent::defaultRequestInstance("/rooms/{$id}");
    }
}