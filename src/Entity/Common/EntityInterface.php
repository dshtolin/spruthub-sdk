<?php

namespace Spruthub\Entity\Common;

interface EntityInterface
{
    public function requestInstances();
    public function requestInstance(int $id);
}