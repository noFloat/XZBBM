<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">  
	<title>学长学姐帮帮忙</title>
	<link rel="stylesheet" href="<?php echo base_url('static/css/detail.debug.css'); ?>">
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
	<div class="content-wp">
		<div class="content" questionId="<?php echo $render['question']['Id'];?>">
			<div class="content-top">
				<img class = "userPic" src="<?php echo $render['question']['headImg'] ?>" alt="">
				<span class = "userName">
				<?php echo $render['question']['name'] ?><label class = "userSex">萌新</label>
				</span>
				<span class = "time"><?php echo $render['question']['time'];?></span>
			</div>
			<div class="content-main">
				<h1><?php echo $render['question']['title'];?></h1>
				<p><?php echo $render['question']['content'];?></p>
			</div>
			<?php
                if(!empty($render['question']['pic_name'])){
			        ?>
                    <div class="content-pic">
                        <?php
                        foreach ($render['question']['pic_name'] as $pic){
                        ?>
                        <img src="<?php echo base_url('index.php/api/showImg/'.$pic);?>" alt="">
                        <?php
                        }
                        ?>
                    </div>
                    <?php
                }
            ?>
		</div>
		<?php
        foreach ($render['comment'] as $comment){
            ?>
            <div class="comment" commentId="<?php echo $comment['Id'];?>">
                <a href="<?php echo base_url('index.php/start/user/'.$comment['author_id']);?>">
                    <img class = "userPic" src="<?php echo $comment['headImg'];?>" alt="">
                </a>
                <div class="commentText">
				<span class = "userName">
				<?php echo $comment['name'];?><label class = "userSex"><?php
                        if($comment['gender'] == '男'){
				            echo '学长';
                        }else{
                            echo '学姐';
                        }
                        ?></label>
				</span>
                    <div class="comment-main">
                        <p><?php echo $comment['content'];?></p>
                    </div>
                    <?php
                    if(!empty($comment['pic_name'])){
                        ?>
                        <div class="comment-pic">
                            <?php
                            foreach ($comment['pic_name'] as $pic){
                                ?>
                                <img src="<?php echo base_url('index.php/api/showImg/'.$pic); ?>" alt="">
                                <?php
                            }
                            ?>
                        </div>
                        <?php
                    }
                    ?>
                    <div class="comment-bottom">
                        <span class = "time"><?php echo $comment['time'];?></span>
                        <span class="like"><img class = "likePic <?php if(!$comment['is_like']){echo 'click';} ?>" src="<?php $name = 'like'; if($comment['is_like']){$name='dislike';} echo base_url('static/img/'.$name.'.png');?>" alt=""><?php echo $comment['like_count']; ?></span>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
	</div>
	<div class="addPics">
		<div class="add">
			<input type="file" id = "addPic">
			<label>+</label>
		</div>
	</div>
	<div class="bottom" style = "position: relative;"></div>
	<div class="bottom">
		<img src="" alt="">
		<input type="text">
		<button>发表</button>
	</div>
</body>
<script src="http://a.alipayobjects.com/??amui/zepto/1.1.3/zepto.js,static/fastclick/1.0.6/fastclick.min.js"></script>
<script>FastClick.attach(document.body);</script>
<script>
	window.onload = function () {
	// body...
	document.querySelector('.bottom').addEventListener('click',function(e){
		if (e.target.localName == "img") {
			console.log(1);
			if (document.querySelector('.addPics').style.display == "") {
				document.querySelector('.addPics').style.display = "block";
			} else if (document.querySelector('.addPics').style.display == "block") {
				document.querySelector('.addPics').style.display = "";
			}
		}
	})
	var questionId,commentId;
	for (var i = 0; i <= document.querySelectorAll('.comment').length - 1; i++) {
		(function (i) {
			var like = document.querySelectorAll('.like')[i].innerText;
			document.querySelectorAll('.comment')[i].addEventListener('click',function(e){
			if (e.target.className == "likePic") {
					document.querySelectorAll('.like')[i].innerHTML = '<img class = "likePic click" src="static/img/like.png" alt="">' + (parseInt(document.querySelectorAll('.like')[i].innerText) + 1);
				} else if (e.target.className == "likePic click"){
					document.querySelectorAll('.like')[i].innerHTML = '<img class = "likePic" src="static/img/dislike.png" alt="">' + (parseInt(document.querySelectorAll('.like')[i].innerText) - 1);
				}
				
				commentId = document.querySelectorAll('.comment')[i].getAttribute("commentId");
				$.ajax({
					type: 'GET',
					url: '<?php echo base_url('index.php/api/like/'); ?>' + commentId,
					dataType: 'json',
					timeout: 300,
					success: function(data){
						
					},
					error: function(xhr, type){
						alert('Ajax error!')
					}
				})
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
		});
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
				delets = document.querySelectorAll('.delet');
				deletPic();
			}
			reader.readAsDataURL(file);
			if (pic.length >= 2) {
		    	add.style.display = "none";
		    }
		}

		function deletPic() {
			display = $('.pic');
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
			var comment = document.querySelector('input').value;
			questionId= document.querySelector('.content').getAttribute("questionId");
			$.ajax({
			  type: 'POST',
			  url: '<?php echo base_url('index.php/api/reply'); ?>',
			  // data to be added to query string:
			  data: { pid:questionId; content : comment,pic : pic},
			  // type of data we are expecting in return:
			  dataType: 'json',
			  timeout: 300,
			  success: function(data){
			    var picM, node，sex;
				if (data.gender == "女") {
					sex = "学姐";
				} else if (data.grender == "男") {
					sex = "学长"
				} 
				if(data.pic_name.length == 0) {
					node = '<div class="comment" commentId ="'+ data.Id +
					'"><a href="<?php echo base_url('index.php/start/user'); ?>' + data.author_id + 
					'"><img class = "userPic" src="' + data.headImg + 
					'" alt=""></a><div class="commentText"><span class = "userName">' + data.name + 
					'<label class = "userSex">' + sex + 
					'</label></span><div class="comment-main"><p>'+ data.content +
					'</p></div><div class="comment-bottom"><span class = "time">' + data.time + 
					'</span><span class="like"><img class = "likePic" src="static/img/dislike.png" alt="">' + data.like_count + 
					'</span></div></div></div>';
				} else if(data.pic_name.length != 0) {
					for(var i = 0; i < data[index].pic_name.length ; i++ ) {
						picM = picM +  '<img src="index.php/api/showImg/' + data[index].pic_name[i] + '" alt="">';
						node = '<div class="comment" commentId ="'+ data.Id +
						'"><a href="<?php echo base_url('index.php/start/user'); ?>' + data.author_id + 
						'"><img class = "userPic" src="' + data.headImg + 
						'" alt=""></a><div class="commentText"><span class = "userName">' + data.name + 
						'<label class = "userSex">' + sex + 
						'</label></span><div class="comment-main"><p>'+ data.content +
						'</p></div><div class="comment-pic">'+  picM +
						'</div><div class="comment-bottom"><span class = "time">' + data.time + 
						'</span><span class="like"><img class = "likePic" src="static/img/dislike.png" alt="">' + data.like_count + 
						'</span></div></div></div>';
					}
				} 
			
				if (data.gender == "男") {
					document.querySelectorAll('userSex').style.background = "#2fbeff";	
				}else if (data.gender == "女") {
					document.querySelectorAll('userSex').style.background = "#f86cc0";	
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