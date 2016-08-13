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
                        <span class="like"><img class = "likePic <?php if(!$comment['is_like']){echo 'click';} ?>" src="<?php $name = 'like'; if($comment['is_like']){$name='dislike';} echo base_url('static/img/'.$name.'.png');?>" alt="">10</span>
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
<script src = "<?php echo base_url('static/js/detail.js'); ?>"></script>
</html>