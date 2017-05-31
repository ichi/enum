<?php

namespace Ichi\Enum;

use ReflectionClass;
use JsonSerializable;
use Doctrine\Common\Inflector\Inflector;

abstract class Enum implements JsonSerializable
{
    private static $cachedAll;
    protected static $contents = [];
    private $id;

    public function __construct($id){
        $ref = new \ReflectionObject($this);
        $consts = $ref->getConstants();
        if (!in_array($id, $consts, false)) { // ゆるく
            throw new \InvalidArgumentException;
        }

        $this->id = $id;
    }

    public static function byId($id){
        return new static($id);
    }

    public static function all($name = null){
        if(is_null($name)){
            $class = get_called_class();
            if(empty(self::$cachedAll[$class])){
                $ref = new ReflectionClass($class);

                $ids = $ref->getConstants();
                $instances = array_map(function($id)use($class){
                    return new $class($id);
                }, $ids);
                return array_combine($ids, $instances);

            }
            return self::$cachedAll[$class];
        }

        // $nameがあれば [$enum->id() => $num->name()] のような配列返す
        $enums = static::all();
        return array_reduce($enums, function($hash, $enum)use($name){
            $hash[$enum->id] = $enum->{$name};
            return $hash;
        }, []);
    }

    public static function filter($callback){
        if (is_string($callback)) {
            $callback = function($e)use($callback){ return $e->{$callback}; };
        }

        $all = static::all();
        return is_callable($callback) ? array_filter($all, $callback) : array_filter($all);
    }

    public function contents(){
        return @static::$contents[$this->id];
    }

    public function get($name){
        if($name == 'id') return $this->id;

        $contents = $this->contents();
        if(empty($contents) || !isset($contents[$name])) return null;
        return $contents[$name];
    }

    public function jsonSerialize(){
        return array_merge($this->contents(), ['id' => $this->id]);
    }

    /* ----- magic methods ----- */

    public static function __callStatic($name, $args){
        // 1文字目が大文字
        if($name[0] == strtoupper($name[0])){
            $id = constant("static::$name");
            return new static($id);
        }
        return parent::__callStatic($name, $args);
    }

    public function __get($name){
        if(method_exists($this, $name)) return $this->{$name}();

        return $this->get($name);
    }

    public function __toString(){
        return (string) $this->id;
    }

    public function __isset($name){
        if(isset($this->{$name})) return true;

        if(method_exists($this, $name)) return true;

        return isset($this->contents()[$name]);
    }
}
