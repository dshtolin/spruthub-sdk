<?php

require_once 'vendor/autoload.php';

$apiurl = 'http://spruthub.local:55555/api';
$email = '';
$password = '';

$sdk = \Spruthub\Sdk::instance($apiurl, $email, $password);

$result = [];

foreach($sdk->room->requestInstances() as $room) {

    if ($room->id == 0) {
        continue;
    }

    $roomkey = $room->name . ' [' . $room->id . ']';
    $result[$roomkey] = [];

    foreach ($sdk->accessory->requestRoomInstances($room->id) as $accessory) {


        if (empty($accessory->deviceId) || empty($accessory->controller)) {
            continue;
        }

        $device = $sdk->device->requestInstance($accessory->deviceId, $accessory->controller);

        $accessorykey = $accessory->name . ' [' . $accessory->id . '], ' . $device->model ;
        $result[$roomkey][$accessorykey] = [];

        foreach($sdk->service->requestInstances($accessory->id) as $service) {

            $servicekey = $service->appleType . ' [' . $service->id . ']';
            $result[$roomkey][$accessorykey][$servicekey] = [];

            foreach($sdk->characteristic->requestInstances($accessory->id, $service->id) as $characteristic) {

                $characteristickey = $characteristic->name['ru'] . ' [' . $characteristic->id . ']';
                $result[$roomkey][$accessorykey][$servicekey][$characteristickey] = $characteristic->value;

            }
        }
    }
}

echo json_encode($result, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);