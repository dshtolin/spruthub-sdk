<?php

namespace Spruthub\Entity\Common;

interface ServiceInterface
{
    public function requestInstances(int $accessoryid);
    public function requestInstance(int $id, int $accessoryid);
}