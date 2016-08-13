<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">  
	<title>学长学姐帮帮忙</title>
	<link rel="stylesheet" href="<?php echo base_url('static/css/search.debug.css');?>">
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
	<div class="search-box">
		<img src="<?php echo base_url('static/img/search-w.png');?>" alt="">
		<input type="text">
	</div>
	<div class="tip">学习</div>
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
	<?php
	include './application/views/footer.php';
	?>
<script>
	window.onload = function () {
	// body...
	var tips = document.querySelectorAll('.tip');

	for (var i = tips.length - 1; i >= 0; i--) {
		(function(i){
			tips[i].addEventListener('click',function () {
				if (tips[i].className == "tip") {
					tips[i].className = "tip click";
				} else {
					tips[i].className = "tip";
				}
				window.location = '<?php echo base_url('index.php/start/searchResult/tag/'); ?>' + tips[i].innerText;
			})
		})(i);
	}
	(function () {
		document.querySelector('input').addEventListener('keyup',function (event) {
			if (event.keyCode == 13) {
				var keyWord = document.querySelector('input').value;
				window.location = '<?php echo base_url('index.php/start/searchResult/word/'); ?>' + keyWord;
			}
		})
	})();
}
</script>
</html>