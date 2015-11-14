<?php
/**
 * Created by PhpStorm.
 * author: 严顺宽
 * description：绘制验证码（生成）
 */

session_start();

$length = 4; //验证码的长度
$str = getCode($length, 0);// 使用下面的自定义函数，获取需要的验证码值

//1. 创建一个画布、分配颜色
$width = $length * 20;//宽度
$height = 30;//高度
$im = imagecreatetruecolor($width, $height);//创建一个画布

//定义几个颜色（输出不同颜色的验证码）
$color[] = imagecolorallocate($im, 111, 0, 55);
$color[] = imagecolorallocate($im, 0, 77, 0);
$color[] = imagecolorallocate($im, 0, 0, 160);
$color[] = imagecolorallocate($im, 221, 111, 0);
$color[] = imagecolorallocate($im, 220, 0, 0);
$bg = imagecolorallocate($im, 240, 240, 240);//背景

//2. 开始绘画
imagefill($im, 0, 0, $bg);
imagerectangle($im, 0, 0, $width - 1, $height - 1, $color[rand(0, 4)]);

//随机添加干扰点
for ($i = 0; $i < 200; $i++) {
    $c = imagecolorallocate($im, rand(0, 255), rand(0, 255), rand(0, 255));//随机一个颜色
    imagesetpixel($im, rand(0, $width), rand(0, $height), $c);
}

//随机添加干扰线
for ($i = 0; $i < 5; $i++) {
    $c = imagecolorallocate($im, rand(0, 255), rand(0, 255), rand(0, 255));//随机一个颜色
    imageline($im, rand(0, $width), rand(0, $height), rand(0, $width), rand(0, $height), $c);
}

//绘制验证码内容（一个一个字符绘制）：
for ($i = 0; $i < $length; $i++) {
    imagettftext($im, 18, rand(-40, 40), 8 + (18 * $i), 24, $color[rand(0, 4)], "font/msyh.ttf", $str[$i]);
}

//3. 输出图像
header("Content-Type:images/png");//设置响应头信息(注意此函数实行前不可以有输出)
imagepng($im);

//4. 销毁图片（释放内容）
imagedestroy($im);


/**
 * 随机生成一个验证码的内容的函数
 * @param int $m 验证码的个数（默认为4）
 * @param int $type 验证码的类型：0：纯数字 1：数字+小写字母  2：数字+大小写字符
 * @return string
 */
function getCode($m = 4, $type = 0) {
    $str = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $t = array(35, 35, strlen($str) - 1);

    //随机生成验证码所需内容
    $c = "";
    for ($i = 0; $i < $m; $i++) {
        $c .= $str[rand(0, $t[$type])];
    }

    $_SESSION['checkCode'] = $c;
    return $c;
}

//echo getCode();