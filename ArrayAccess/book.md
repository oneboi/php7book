php

# ArrayAccess（数组式访问）接口



## 一、接口原型

<https://www.php.net/manual/zh/class.arrayaccess.php>



1. 简介

> 提供像访问数组一样访问对象的能力的接口。


2. 接口摘要
```php
ArrayAccess {
/* 方法 */
abstract public offsetExists ( mixed $offset ) : boolean
abstract public offsetGet ( mixed $offset ) : mixed
abstract public offsetSet ( mixed $offset , mixed $value ) : void
abstract public offsetUnset ( mixed $offset ) : void
}
```

- [ArrayAccess::offsetExists](https://www.php.net/manual/zh/arrayaccess.offsetexists.php) — 检查一个偏移位置是否存在
- [ArrayAccess::offsetGet](https://www.php.net/manual/zh/arrayaccess.offsetget.php) — 获取一个偏移位置的值
- [ArrayAccess::offsetSet](https://www.php.net/manual/zh/arrayaccess.offsetset.php) — 设置一个偏移位置的值
- [ArrayAccess::offsetUnset](https://www.php.net/manual/zh/arrayaccess.offsetunset.php) — 复位一个偏移位置的值




3. 自己的说明

这是个接口，必须弄个类实现里面的方法



##  二、数组方式访问对象属性



### 例子1：

```php
class Foo implements ArrayAccess
{
    public function offsetExists( $offset ) {
        echo "这里是 offsetExists() 方法 你输入的参数是 {$offset}";
    }

    public function offsetGet( $offset ) {
        echo "这里是 offsetGet() 方法 你输入的参数是 $offset";
    }

    public function offsetSet( $offset, $value ) {
        echo "这里是 offsetSet() 方法 你输入的 {$offset}={$value}";
    }

    public function offsetUnset( $offset ) {
        echo "这里是 offsetUnset() 方法 你输入的参数是 {$offset}";
    }
}
```



```php
$foo = new Foo();

$foo['xxx'] 对应调用offsetGet方法。 获得

$foo['xxx'] = 'yyy' 对应调用offsetSet方法。 设置

isset($foo['xxx']) 对应调用offsetExists方法。 是否存在
 
unset($foo['xxx']) 对应调用offsetUnset方法。  删除
```



### 例子2：

```php
<?php
class Test implements ArrayAccess
{
    private $testData;

    public function offsetExists($key)
    {
        return isset($this->testData[$key]);
    }

    public function offsetSet($key, $value)
    {
        $this->testData[$key] = $value;
    }

    public function offsetGet($key)
    {
        return $this->testData[$key];
    }

    public function offsetUnset($key)
    {
        unset($this->testData[$key]);
    }
}

  $obj = new Test();

  //自动调用offsetSet方法
  $obj['data'] = 'data';

  //自动调用offsetExists
  if(isset($obj['data'])){
    echo 'has setting!';
  }
  //自动调用offsetGet
  var_dump($obj['data']);

  //自动调用offsetUnset
  unset($obj['data']);
  var_dump($test['data']);

  //输出：
  //has setting!
  //data  
  //null
```





<https://blog.csdn.net/wh2691259/article/details/52882880>



<https://learnku.com/articles/5595/introduction-and-use-of-arrayaccess>

ArrayAccess 的介绍与使用

<https://learnku.com/articles/5595/introduction-and-use-of-arrayaccess>



## 三 、ArrayAccess访问数组



database.php

```php
<?php 
$config = array(
    'mysql' => array(
        'type' => 'MySQL',
        'host' => '127.0.0.1',
        'user' => 'root',
        'password' => 'root',
        'dbname' => 'blog',
    )
);
//注意这里有个return
return $config;




 ?>
```



Config.php

```php
<?php 
class Config implements ArrayAccess{
    protected $path;
    protected $configs = array();

    public function __construct($path){
        $this->path=$path;
 
    }
    //获取配置值
    function offsetGet($key){

        if (empty($this->configs[$key]))
        {
            $file_path = $this->path.'/'.$key.'.php';
            $config = require $file_path;            
            $this->configs[$key] = $config;
        }
        return $this->configs[$key];
    }
    //设置配置值
    function offsetSet($key, $value)
    {
        throw new \Exception("cannot write config file.");
    }
    //检查配置是否存在
    function offsetExists($key)
    {
        return isset($this->configs[$key]);
    }
    //删除配置
    function offsetUnset($key)
    {
        unset($this->configs[$key]);
    }
 
}









 ?>
```



index.php

```php
require "./Config.php";

$base_dir= str_replace("\\",'/',__DIR__);
$config=new Config($base_dir.'/config'); 
print_r($config['database']);

print_r($config['redis']);


```



<https://www.phpsong.com/3022.html>
https://segmentfault.com/a/1190000007327174





## 四、php中定义网站根目录的常用方法

​    define('BASE_PATH',str_replace('\\','/',realpath(dirname(__FILE__).'/../')))

