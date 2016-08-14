<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">  
	<title>学长学姐帮帮忙</title>
	<link rel="stylesheet" href="<?php echo base_url('static/css/question.debug.css');?>">
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
</body>
<script src="http://a.alipayobjects.com/??amui/zepto/1.1.3/zepto.js,static/fastclick/1.0.6/fastclick.min.js"></script>
<script>FastClick.attach(document.body);</script>
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
			})
		})(i);
	}
	var picture = (function(){
		var addPic = document.querySelector('#addPic');
		var add = document.querySelector('.add');
		var showPic = document.querySelector('.addPics');
		var pic = [];
		var delets = [];
		var display;
		addPic.addEventListener('change', function(e){
		    var files = this.files;
		    if(files.length && pic.length < 3){
			     checkPic(this.files);

		    }
		})
		function checkPic(files){
			var newNode = document.createElement('div');
			newNode.className = "pic";
			var file = files[0];
			var reader = new FileReader();
			// show表示<div id='show'></div>，用来展示图片预览的
			if(!/image\/\w+/.test(file.type)){
				newNode.innerHTML = "错误的文件类型";
		        showPic.insertBefore(newNode,add);
		        return false;
		    }
		    // onload是异步操作
			reader.onload = function(e){
				newNode.innerHTML = '<div class="delet">×</div><img src="'+e.target.result+'" id = "pic" alt="img">';
				showPic.insertBefore(newNode,add);
				pic.push(e.target.result);
				delets = $('.delet');
				deletPic();
			}
			reader.readAsDataURL(file);
			if (pic.length >= 2) {
		    	add.style.display = "none";
		    }
		}

		function deletPic() {
			display = $('.pic');
			// delets.one('click',function(e){console.log(e)});
			for (var i = 0; i <= delets.length - 1; i++	) {
				(function(i){
					delets[i].addEventListener('click',function (event) {
						pic.splice(i,1);
						var displays = display.toArray();
						displays[i].remove();
						displays.splice(i,1)
						add.style.display = "block";
						pic = $('.pic').toArray();
						pic.forEach(function(item,index,array){
							array[index] = array[index].children.pic.src;
						})
					})
				})(i)
			}
		}
		
		document.querySelector('button').addEventListener('click',function (event) {
		var title = document.querySelector('input').value;
		var detail = document.querySelector('textarea').value;
		var clicks = document.querySelectorAll('.click');
		var clicked = [];
		(function () {
			for (var i = clicks.length - 1; i >= 0; i--) {
				clicked[i] = clicks[i].innerHTML;
			}
		})();
        for(var i = 0; i < pic.length; i++) {
            pic[i] = pic[i].toString();
        }
		$.ajax({
			  type: 'POST',
			  url: '<?php echo base_url('index.php/api/addQuestion'); ?>',
			  // data to be added to query string:
			  data: { title: title ,content : detail,tag : clicked,pic : pic},
			  // type of data we are expecting in return:
			  dataType: 'json',
			  timeout: 10000,
			  success: function(data){
			    if(data.status == 410 ) {
			    	alert("标题长度大于20");
			    } else if(data.status == 411) {
			    	alert("问题描述长度大于100")
			    } else if(data.status == 412) {
			    	alert("请选择标签")
			    } else  {
			    	window.location = '<?php echo base_url('index.php/start/index'); ?>'
			    }
			  },
			  error: function(xhr, type){
			    alert('Ajax error!')
			  }
			})
		})
	})();	
}
</script>
</html>