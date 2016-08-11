<?php
/**
 * Created by PhpStorm.
 * User: 张鹏翼
 * Date: 2016/8/10
 * Time: 15:46
 */

require './php/FindFullText.class.php';
$fen = new FindFullText();
echo '<br/>';
//echo  $fen->add('停车做爱枫林晚','爱在黎明破晓前');
$body = str_replace("'","-",$_POST['body']);
$title = str_replace("'","-",$_POST['title']);
$num = $fen->add($title, $body);
if($num>=1){
    echo '<script>alert("发布成功");location="index.php"</script>';
}else{
    echo '<script>alert("发布失败");location="edit.html"</script>';
}