<?php

namespace Spruthub\Entity\Common;

interface ServerLoginInterface
{
    public function requestInstance(string $email, string $password);
}