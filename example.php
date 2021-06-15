<?php
include dirname(__FILE__).'/config.php';

$result = [];
$accessories = $sdk->accessory->requestInstances();
foreach($accessories as $accessory) {
    $result[] = $accessory->export();
}
echo json_encode($result, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);