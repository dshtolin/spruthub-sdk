<?php

namespace Spruthub\Entity\Common;

interface DeviceInterface
{
    public function requestInstances(string $controller);
    public function requestInstance(string $id, string $controller);
}