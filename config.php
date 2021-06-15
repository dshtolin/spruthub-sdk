<?php
/**
 * Created by PhpStorm.
 * User: dshtolin
 * Date: 15/06/21
 * Time: 23:03
 */

require_once 'vendor/autoload.php';
$apiurl = 'http://spruthub.local:55555/api';
$email = '';
$password = '';
$sdk = \Spruthub\Sdk::instance($apiurl, $email, $password);