<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">  
	<title>学长学姐帮帮忙</title>
	<link rel="stylesheet" href="static/css/question.debug.css">
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
	<div class="title">
		<input type="text" placeholder="标题(20字以内)">
	</div>
	<div class="describe">
		<textarea name="content" id="content" placeholder="问题描述(100字之内)"></textarea>
	</div>
	<div class="tips">
		<div class="tip click">学习</div>
		<div class="tip">生活</div>
		<div class="tip">考研</div>
		<div class="tip">就业</div>
		<div class="tip">娱乐</div>
		<div class="tip">通信</div>
		<div class="tip">计算机</div>
		<div class="tip">自动化</div>
		<div class="tip">光电</div>
		<div class="tip">生物</div>
		<div class="tip">数理</div>
		<div class="tip">经管</div>
		<div class="tip">法学院</div>
		<div class="tip">传媒</div>
		<div class="tip">体育</div>
		<div class="tip">软件</div>
		<div class="tip">外国语</div>
		<div class="tip">国际</div>
		<p>提示：政策性问题请向所在学院咨询</p>
	</div>
	<hr>
	<div class="addPics">
		<div class="add">
			<input type="file" id = "addPic">
			<label>+</label>
		</div>
	</div>
	<button>发布</button>
	<footer>
		<div class="index">
			<a href="index.php">
				<img src="static/img/index-icon.png" alt="">
				首页
			</a>
		</div>
		<div class="question">
			<a href="question.php">
				<img src="static/img/question-icon-c.png" alt="">
				提问
			</a>
		</div>
		<div class="search">
			<a href="search.php">
				<img src="static/img/search-icon.png" alt="">
				查找
			</a>
		</div>
		<div class="user">
			<a href="user.html">
				<img src="static/img/user-icon.png" alt="">
				个人中心
			</a>
		</div>
	</footer>
</body>
<script src="http://a.alipayobjects.com/??amui/zepto/1.1.3/zepto.js,static/fastclick/1.0.6/fastclick.min.js"></script>
<script>FastClick.attach(document.body);</script>
<script src = "static/js/question.js"></script>
</html>