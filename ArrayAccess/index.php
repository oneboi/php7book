<?php 

require "./Config.php";

$base_dir= str_replace("\\",'/',__DIR__);
$config=new Config($base_dir.'/config'); 
print_r($config['database']);

print_r($config['redis']);






 ?>