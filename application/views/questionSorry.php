<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">  
	<title>学长学姐帮帮忙</title>
	<link rel="stylesheet" href="<?php echo base_url('static/css/questionSorry.debug.css');?>">
	<style>
		@media screen and (min-width:320px) {
		    html {
		        font-size: 32px;
		    }
		}
		@media screen and (min-width: 360px){
		    html {
		        font-size: 36px;
		    }
		}
		@media screen and (min-width: 375px){
		    html {
		        font-size: 37.5px;
		    }
		}
		@media screen and (min-width: 410px) {
		    html {
		        font-size: 41px;
		    }
		}
		@media screen and (min-width: 425px) {
		    html {
		        font-size: 42.5px;
		    }
		}
	</style>
</head>
<body>
	<div class="main">
		<img src="<?php echo base_url('static/img/sorry.png');?>" alt="">
	</div>
	<footer>
        <div class="index">
            <a href="<?php echo base_url('index.php/start/index'); ?>">
                <img src="<?php echo base_url('static/img/index-icon.png');?>" alt="">
                首页
            </a>
        </div>
        <div class="question">
            <a href="<?php echo base_url('index.php/start/question')?>">
                <img src="<?php echo base_url('static/img/question-icon-c.png');?>" alt="">
                提问
            </a>
        </div>
        <div class="search">
            <a href="<?php echo base_url('index.php/start/search')?>">
                <img src="<?php echo base_url('static/img/search-icon.png');?>" alt="">
                查找
            </a>
        </div>
        <div class="user">
            <a href="<?php echo base_url('index.php/start/user'); ?>">
                <img src="<?php echo base_url('static/img/user-icon.png');?>" alt="">
                个人中心
            </a>
        </div>
    </footer>
</body>
<script src="http://a.alipayobjects.com/??amui/zepto/1.1.3/zepto.js,static/fastclick/1.0.6/fastclick.min.js"></script>
<script>FastClick.attach(document.body);</script>
</html>