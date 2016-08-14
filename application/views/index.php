<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">  
	<title>学长学姐帮帮忙</title>
	<link rel="stylesheet" href="<?php echo base_url('static/css/index.debug.css');?>">
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
	<div class="top-wp">
		<div class="top">
			<div class="top-left click">
				最新问题
			</div>
			<div class="top-right">
				最热问题
			</div>
		</div>
	</div>
	<div class="search-box">
		<img src="<?php echo base_url('static/img/search.png'); ?>" alt="">
		<input type="text">
	</div>
	<div class="new">
		<?php
		foreach ($render as $question) {
			?>
			<a href="<?php base_url('index.php/start/detail/'.$question['Id']); ?>" class="content">
				<div class="content-top">
					<img class="userPic" src="<?php echo $question['headImg']; ?>" alt="">
					<span class="userName"><?php echo $question['name']; ?></span>
					<img class="arrow" src="<?php echo base_url('static/img/arrow-r.png'); ?>" alt="">
				</div>
				<div class="content-main">
					<h1><?php echo $question['title']; ?></h1>
					<p><?php echo $question['content']; ?></p>
				</div>
				<?php
				if(!empty($question['pic_name'])){
					?>
					<div class="content-pic">
						<?php
						foreach ($question['pic_name'] as $pic){
							?>
							<img src="<?php echo base_url('index.php/api/showImg/'.$pic); ?>" alt="">
							<?php
						}
						?>
					</div>
					<?php
				}
				?>
				<div class="content-bottom">
					<span class="time"><?php echo $question['time'];?></span>
					<span class="comment"><?php echo $question['reply_count'];?>评论</span>
				</div>
			</a>
			<?php
		}
		?>

	</div>
    <footer>
        <div class="index">
            <a href="<?php echo base_url('index.php/start/index'); ?>">
                <img src="<?php echo base_url('static/img/index-icon-c.png');?>" alt="">
                首页
            </a>
        </div>
        <div class="question">
            <a href="<?php echo base_url('index.php/start/question')?>">
                <img src="<?php echo base_url('static/img/question-icon.png');?>" alt="">
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
<script>
window.onload =function () {
	var left = document.querySelector('.top-left');
	var right = document.querySelector('.top-right');
	var pageH = 1,pageN = 1,page = 1;
	var body = $('body');
	var by,startY = body.scrollTop() ,endY;
	document.querySelector(".top").addEventListener('click',function (event) {
		if(event.target.innerText == "最新问题") {
			by = "最新问题";
			left.className = "top-left click";
			right.className = "top-right";
			document.querySelector('.new').style.display = "block";
			document.querySelector('.hot').style.display = "none";
		} else if(event.target.innerText == "最热问题") {
			by = "最热问题";
			left.className = "top-left";
			right.className = "top-right click";
			document.querySelector('.hot').style.display = "block";
			document.querySelector('.new').style.display = "none";
			if (pageH == 1) {
				$.ajax({
					type: 'GET',
					url: '<?php echo base_url('index.php/api/getQuestion/'); ?>' + by + pageH,
					dataType: 'json',
					timeout: 300,
					success: function(data){
						data.forEach(function(item,index,data){
							var picM, node;
							if (data[index].pic_name.length == 0) {
								node = '<a href="detail.html/' + data[index].id + 
								'"class="content"><div class="content-top"><img class = "userPic" src="' + data[index].headImg + 
								'" alt=""><span class = "userName">' + data[index].name + 
								'</span><img class = "arrow" src="static/img/arrow-r.png" alt=""></div><div class="content-main"><h1>' + data[index].title + 
								'</h1><p>' + data[index].content + 
								'</p></div><div class="content-bottom"><span class = "time">' + data[index].time + 
								'</span><span class="comment">' + data[index].reply_count + 
								'</span></div></a>';
							} else if(data[index].pic_name.length != 0) {
								for(var i = 0; i < data[index].pic_name.length ; i++ ) {
									picM = picM +  '<img src="index.php/api/showImg/' + data[index].pic_name[i] + '" alt="">';
								}
								node = '<a href="detail.html/' + data[index].id + 
								'"class="content"><div class="content-top"><img class = "userPic" src="' + data[index].headImg + 
								'" alt=""><span class = "userName">' + data[index].name + 
								'</span><img class = "arrow" src="static/img/arrow-r.png" alt=""></div><div class="content-main"><h1>' + data[index].title + 
								'</h1><p>' + data[index].content + 
								'</p></div><div class="content-pic">' + picM + 
								'</div><div class="content-bottom"><span class = "time">' + data[index].time + 
								'</span><span class="comment">' + data[index].reply_count + 
								'</span></div></a>';
							}
							$(".hot").append(node);
						}) 
					},
					error: function(xhr, type){
						alert('Ajax error!')
					}
				})
			}
		}
		
	})
	body.on('touchend',function (e) {
		endY = body.scrollTop();
		if (by == "最新问题") {
			pageN ++;
			page = pageN;
		} else if (by == "最热问题") {
			pageH ++;
			page = pageH;
		}
		if ((endY - startY) > 100) {
			startY = endY;
			$.ajax({
				type: 'GET',
				url: '<?php echo base_url('index.php/api/getQuestion/'); ?>' + by + page,
				dataType: 'json',
				timeout: 300,
				success: function(data){
					data.forEach(function(item,index,data){
						var picM, node;
						if (data[index].pic_name.length == 0) {
							node = '<a href="detail.html/' + data[index].id + 
							'"class="content"><div class="content-top"><img class = "userPic" src="' + data[index].headImg + 
							'" alt=""><span class = "userName">' + data[index].name + 
							'</span><img class = "arrow" src="static/img/arrow-r.png" alt=""></div><div class="content-main"><h1>' + data[index].title + 
							'</h1><p>' + data[index].content + 
							'</p></div><div class="content-bottom"><span class = "time">' + data[index].time + 
							'</span><span class="comment">' + data[index].reply_count + 
							'</span></div></a>';
						} else if(data[index].pic_name.length != 0) {
							for(var i = 0; i < data[index].pic_name.length ; i++ ) {
								picM = picM +  '<img src="index.php/api/showImg/' + data[index].pic_name[i] + '" alt="">';
							}
							node = '<a href="detail.html/' + data[index].id + 
							'"class="content"><div class="content-top"><img class = "userPic" src="' + data[index].headImg + 
							'" alt=""><span class = "userName">' + data[index].name + 
							'</span><img class = "arrow" src="static/img/arrow-r.png" alt=""></div><div class="content-main"><h1>' + data[index].title + 
							'</h1><p>' + data[index].content + 
							'</p></div><div class="content-pic">' + picM + 
							'</div><div class="content-bottom"><span class = "time">' + data[index].time + 
							'</span><span class="comment">' + data[index].reply_count + 
							'</span></div></a>';
						}
						if (by == "最新问题") {
							$(".new").append(node);
							pageN ++;
						} else if (by == "最热问题") {
							pageH ++;
							$(".hot").append(node);
						}
					}) 
				},
				error: function(xhr, type){
					alert('Ajax error!')
				}
			})
		}

	})

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