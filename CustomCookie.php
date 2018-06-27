<?php

/**
 * Cookie的设置 删除 读取
 * Created by PhpStorm.
 * User: Meckey_Shu
 * Date: 2018/6/27
 * Time: 13:14
 */
class CustomCookie
{
    static private $_instance = null;
    private $expire = 0;
    private $path = '';
    private $domain = '';
    private $secure = false;
    private $httponly = false;

    private function __construct(array $options = [])
    {
        $this->setOptions($options);
    }

    /**
     * 设置相关选项
     * @param array $options
     */
    private function setOptions(array $options = [])
    {
        if (isset($options['expire'])) {
            $this->expire = (int)$options['expire'];
        }
        if (isset($options['path'])) {
            $this->path = $options['path'];
        }
        if (isset($options['domain'])) {
            $this->domain = $options['domain'];
        }
        if (isset($options['secure'])) {
            $this->secure = (bool)$options['secure'];
        }
        if (isset($options['httponly'])) {
            $this->httponly = (bool)$options['httponly'];
        }
    }

    /**
     * 单例模式
     * @param array $options
     * @return object 实例
     */
    public static function getInstance(array $options = [])
    {
        if (is_null(self::$_instance)) {
            $class = __CLASS__;
            self::$_instance = new $class($options);
        }
        return self::$_instance;
    }

    /**
     * 设置Cookie
     * @param $key
     * @param $val
     * @param array $options
     */
    public function set($key, $val, array $options = [])
    {
        if (is_array($options) && count($options) > 0) {
            $this->setOptions($options);
        }
        if (is_array($val) || is_object($val)) {
            $val = json_encode($val, JSON_FORCE_OBJECT);
        }
        setcookie($key, $val, $this->expire, $this->path, $this->domain, $this->secure, $this->httponly);
    }

    /**
     * 获取指定Cookie
     * @param $key
     * @return mixed
     */
    public function get($key)
    {
        if (isset($_COOKIE[$key])) {
            return substr($_COOKIE[$key], 0, 1) == '{' ? json_decode($_COOKIE[$key]) : $_COOKIE[$key];
        } else {
            return null;
        }
    }

    /**
     * 删除指定Cookie
     * @param $key
     * @param array $options
     */
    public function delete($key, array $options = [])
    {
        if (is_array($options) && count($options) > 0) {
            $this->setOptions($options);
        }
        if (isset($_COOKIE[$key])) {
            setcookie($key, '', time() - 1, $this->path, $this->domain, $this->secure, $this->httponly);
            unset($_COOKIE[$key]);
        }
    }

    public function deleteAll(array $options = [])
    {
        if (is_array($options) && count($options) > 0) {
            $this->setOptions($options);
        }
        if (!empty($_COOKIE)) {
            foreach ($_COOKIE as $name => $value) {
                $this->delete($name);
            }
        }
    }
}
