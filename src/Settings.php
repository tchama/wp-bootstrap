<?php
namespace Wpbootstrap;

class Settings
{
    private $obj;

    public function __construct($type = null)
    {
        if (!defined('BASEPATH')) {
            define('BASEPATH', dirname(dirname(__FILE__)));
        }

        $file = '';
        switch ($type) {
            case 'local':
                $file = '/localsettings.json';
                break;
            case 'app':
                $file = '/appsettings.json';
                break;
            default:
                $file = '/localsettings.json';
                break;
        }

        $this->obj = json_decode(file_get_contents(BASEPATH.$file));
        if (defined('TESTMODE') && TESTMODE) {
            $this->obj->environment = 'test';
            foreach ($obj as $param) {
                $parts = explode('_', $param);
                $name = $parts[0];
                if (isset($parts[1]) && $parts[1] == 'test') {
                    $this->obj->$name = $this->obj->$param;
                }
            }
        }
    }

    public function isValid()
    {
        return ($this->obj != false);
    }

    public function toString()
    {
        return json_encode($this->obj);
    }

    public function __get($name)
    {
        if (isset($this->obj->$name)) {
            return $this->obj->$name;
        }

        return;
    }

    public function __set($name, $value)
    {
        $this->obj->$name = $value;
    }

    public function __isset($name)
    {
        return isset($this->obj->$name);
    }
}