<?php
/**
 * Created with PhpStorm.
 * User: $严顺宽
 * Date: 2015/11/1
 * Description：
 */
$url="http://localhost/index.php/user/delete";
echo "地址是：".$url;

echo "<br>";
echo "<br>";
echo "<br>";

$test = pathinfo("http://localhost/index.php/user/delete");
print_r($test);


echo "<br>";
echo "<br>";
echo "<br>";

$test = parse_url("http://localhost/index.php/user/delete");
print_r($test);

echo "<br>";
echo "<br>";
echo "<br>";

$test = basename("http://localhost/index.php/user/delete");
echo $test;