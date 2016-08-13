<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">  
	<title>学长学姐帮帮忙</title>
	<link rel="stylesheet" href="<?php echo base_url('static/css/sign.debug.css'); ?>">
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
	<div class="mainPic">
		<img src="<?php echo base_url('static/img/mainPic.png'); ?>" alt="">
	</div>
	<div class = "form">
		<div class="user">
			<img src="<?php echo base_url('static/img/people.png'); ?>" alt="">
			<input id = "user" type="text" placeholder="姓名">
		</div>
		<div class="pwd">
			<img src="<?php echo base_url('static/img/lock.png'); ?>" alt="">
			<input id = "pwd" type="password" placeholder="考生号后6位">
		</div>
		<p id = "msg">
			通过审核的学长学姐用学号和身份证后六位
		</p>
		<button>登录</button>
	</div>
	<span id = "index_url" url = "<?php echo base_url('index.php/start/index'); ?>"></span>
	<i>
		&copy红岩网校工作站
	</i>
</body>
<script src="http://a.alipayobjects.com/??amui/zepto/1.1.3/zepto.js,static/fastclick/1.0.6/fastclick.min.js"></script>
<script>FastClick.attach(document.body);</script>
<script>
	(function login() {
		$("button").on("click",function () {
			var user =  $('#user').val();
			var pwd = $('#pwd').val();
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url('index.php/start/doLogin'); ?>',
				// data to be added to query string:
				data: { stuNum : user, idNum : pwd },
				// type of data we are expecting in return:
				dataType: 'json',
				timeout: 3000,
				success: function(data){
					if(data.status == 200) {
						window.location = document.querySelector('#index_url').getAttribute('url');
					} else if (data.status == 401){
						document.querySelector("#msg").innerText = "账号密码错误";
					} else if (data.status == 400) {
						document.querySelector("#msg").innerText = "账号密码不能为空";
					}
				},
				error: function(xhr, type){
					alert('Ajax error!')
				}
			});
		})
	})();
</script>
</html>