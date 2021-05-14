<?php

namespace Spruthub\Entity\Common;

interface CharacteristicInterface
{
    public function requestInstances(int $accessoryid, int $serviceid);
    public function requestInstance(int $id, int $accessoryid);
}