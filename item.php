<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="bootstrap3.0.3/css/bootstrap.css">
    <title>Document</title>
    <script src="bootstrap3.0.3/js/jquery.min.js"></script>
    <style type="text/css">
        body {
            background-color: #ccc;
        }

        .widget {
            padding: 21px 30px;
            background: #ffffff;
            margin-bottom: 35px;
        }

        /*.text-mysql {*/
            /*height: 200px;*/
            /*overflow: hidden;*/
            /*font-size: 18px;*/
            /*margin-bottom: 15px;*/
        /*}*/

        /*.span-right {*/
            /*float: right;*/
        /*}*/

    </style>
    <script>

    </script>
</head>
<body>
<div class="container">
    <nav class="navbar navbar-default row" role="navigation">
        <div class="navbar-header col-lg-2">
            <a class="navbar-brand" href="index.php">博客之家</a>
        </div>
        <div class="col-lg-6">
            <ul class="nav navbar-nav">
                <li class="active"><a href="index.php">首页</a></li>
                <li><a href="#">订阅</a></li>
                <li><a href="#">联系</a></li>
                <li><a href="#">管理</a></li>
                <li><a href="edit.html">发表</a></li>
            </ul>
        </div>
        <div class="col-lg-4">
            <form class="navbar-form navbar-left" role="search" action="index.php" method="get">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Search" name="action">
                </div>
                <button type="submit" class="btn btn-default">搜索</button>
            </form>
        </div>
    </nav>

    <div class="row">
        <div class="col-lg-9 main-content" style="background-color: #ffffff">
            <div class="col-xs-12">

                <div class="page-header">
<!--                    <h1><p class="text-center">这是标题</p></h1>-->
<!--                    <blockquote >-->
<!--                        <p class="text-center">-->
<!--                            <span>作者：</span>-->
<!--                            •-->
<!--                            <span>时间</span>-->
<!--                        </p>-->
<!--                    </blockquote>-->
<!--                        <p class="lead">-->
<!--                            zheshi这是内容！！！-->
<!--                        </p>-->
                    <?php
                    include './php/FindFullText.class.php';
                    $fen = new FindFullText();
                    $id=$_GET['id'];
                    $resultText = $fen->selectOne($id);
                    foreach ($resultText as $vText){
                        echo '<h1><p class="text-center">'.$vText['title'].'</p></h1>';
                        echo '<blockquote ><p class="text-center"><span>作者：'.$vText['author'].'</span> • ';
                        echo '<span>'.$vText['time'].'</span></p></blockquote>';
                        echo '<p class="lead">'.$vText['body'].'</p>';
                    }
                    ?>
                </div>


        </div>
    </div>
    <div class="col-lg-3">
        <div class="widget">
            <h4><p>个人资料</p></h4>
            <hr>
            <p>昵称：<a href="">haha</a></p>
            <p>圆龄：<a href="">1年5个月</a></p>
            <p>粉丝：<a href="">500+</a></p>
            <p>关注：<a href="">200+</a></p>
            <p><a href="">加关注</a></p>
        </div>

        <div class="widget">
            <h4><p>文章分类</p></h4>
            <hr>
            <p><a href="">Web</a></p>
            <p><a href="">PHP</a></p>
            <p><a href="">MySql</a></p>
            <p><a href="">Java</a></p>
            <p><a href="">程序人生</a></p>
        </div>

        <div class="widget">
            <h4><p>文章存档</p></h4>
            <hr>
            <p><a href="">2016年7月</a></p>
            <p><a href="">2016年6月</a></p>
            <p><a href="">2016年5月</a></p>
            <p><a href="">2016年4月</a></p>
            <p><a href="">2016年3月</a></p>
        </div>
    </div>
    </main>

</div>
</body>
</html>