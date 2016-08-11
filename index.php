<?php
/**
 * Created by PhpStorm.
 * User: 张鹏翼
 * Date: 2016/8/10
 * Time: 18:00
 */
header('Content-type:text/html;charset=utf-8');
include './php/FindFullText.class.php';
$fen = new FindFullText();
$action = isset($_GET['action'])? $_GET['action'] : '';
if ($action!=''){
    $result =$fen->search($action);
    $all = $result;
}else{
    $all = $fen->select();
}

include 'blog.html';
