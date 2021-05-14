<?php

namespace Spruthub\Entity\Common;

use Mustache_Engine;
use Mustache_Loader_FilesystemLoader;
use Spruthub\Sdk;
use Spruthub\Config;

abstract class AbstractEntity
{

    protected static $mustache;
    protected $apiurl;

    public function __construct(string $apiurl) {
        $this->apiurl = $apiurl;
    }

    protected $apiurlpath = null;
    /** @var array The model data. */
    private $data = [];

    /**
     * Data setter.
     *
     * @param  string $property The property name.
     * @return $this
     */
    final public function __set($property, $value) {
        if (!static::__isset($property)) {
            throw new \Exception('Unexpected property \'' . $property .'\' requested.');
        }
        $methodname = 'set' . ucfirst($property);
        if (method_exists($this, $methodname)) {
            $this->$methodname($value);
            return $this;
        }
        return $this->rawSet($property, $value);
    }

    /**
     * Data getter.
     *
     * @param  string $property The property name.
     * @return mixed
     */
    final public function __get($property) {
        if (!static::__isset($property)) {
            throw new \Exception('Unexpected property \'' . $property .'\' requested.');
        }
        $methodname = 'get' . ucfirst($property);
        if (method_exists($this, $methodname)) {
            return $this->$methodname();
        }
        return $this->rawGet($property);
    }

    /**
     * Internal Data getter.
     *
     * @param  string $property The property name.
     * @return mixed
     */
    final protected function rawGet($property) {
        if (!static::__isset($property)) {
            throw new \Exception('Unexpected property \'' . $property .'\' requested.');
        }
        return $this->data[$property] ?? null;
    }

    /**
     * Data setter.
     *
     * @param  string $property The property name.
     * @param  mixed $value The value.
     * @return $this
     */
    final protected function rawSet($property, $value) {
        if (!static::__isset($property)) {
            throw new \Exception('Unexpected property \'' . $property .'\' requested.');
        }
        $this->data[$property] = $value;
        return $this;
    }


    /**
     * Return the custom definition of the properties of this model.
     *
     * Each property MUST be listed here.
     *
     * The result of this method is cached internally for the whole request.
     *
     * Example:
     *
     * array(
     *     'property_name' => array()
     * )
     *
     * @return array Where keys are the property names.
     */
    protected static function defineProperties() {
        return array();
    }

    /**
     * Get the properties definition of this model..
     *
     * @return array
     */
    final public static function propertiesDefinition() {

        static $def = null;
        if ($def !== null) {
            return $def;
        }

        $def = static::defineProperties();

        return $def;
    }

    /**
     * Returns whether or not a property was defined.
     *
     * @param  string $property The property name.
     * @return boolean
     */
    final public function __isset($property) {
        $properties = static::propertiesDefinition();
        return isset($properties[$property]);
    }

    protected function defaultRequestInstances(string $apiurlpath) {
        $instances = [];
        $url = $this->apiurl . $apiurlpath;
        $headers = [Sdk::instance()->getAuthorizationHeader()];
        $objectsdata = Sdk::instance()->requestJson($url, $headers);
        foreach ($objectsdata as $objectdata) {
            $instances[] = $this->createInstance($objectdata);
        }
        return $instances;
    }

    protected function defaultRequestInstance(string $apiurlpath)
    {
        $url = $this->apiurl . $apiurlpath;
        $headers = [Sdk::instance()->getAuthorizationHeader()];
        $objectdata = Sdk::instance()->requestJson($url, $headers);
        return $this->createInstance($objectdata);
    }

    public function createInstance(array $objectdata)
    {
        $instance = new static($this->apiurl);
        $instance->fillInstance($objectdata);
        return $instance;
    }

    public function fillInstance(array $objectdata) {
        foreach ($objectdata as $property => $value) {
            try
            {
                $this->__set($property, $value);
            } catch (\Exception $ex) {
                continue;
            }
        }
    }

    public function export() {
        return $this->data;
    }



}