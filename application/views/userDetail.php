<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">  
	<title>学长学姐帮帮忙</title>
	<link rel="stylesheet" href="<?php echo base_url('static/css/user.debug.css');?>">
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
	<div class="userMassage">
		<img class= "userPic" src="<?php echo $render['headImg'];?>" alt="">
		<div class="text">
			<span class = "userName"><?php echo $render['name'];?></span>
			<label class = "userSex"><?php if($render['is_junior']){echo '萌新';}else{if($render['gender'] == '男'){echo '学长';}else{echo '学姐';}} ?></label>
		</div>
	</div>
	<div class="mainMessage">
		<div class="sex">
			<img src="<?php echo base_url('static/img/sex.png');?>" alt="">性别
			<label><?php echo $render['gender'];?></label>
		</div>
		<div class="collage">
			<img src="<?php echo base_url('static/img/collage.png'); ?>" alt="">学院
			<label><?php echo $render['college']; ?></label>
		</div>
		<?php
        if($render['is_senior']){
		    ?>
            <div class="teacher">
                <img src="<?php echo base_url('static/img/teacher.png');?>" alt="">辅导员
                <label><?php echo $render['teacher'];?></label>
            </div>
            <div class="userDetail">
                <img src="<?php echo base_url('static/img/userDetail.png');?>" alt="">个人简介
                <p><?php echo $render['biography']; ?></p>
            </div>
            <?php
        }
        ?>
	</div>
	<div class="myAnswer">
        <?php
        if($render['is_junior']){
            ?>
            <a href="<?php echo base_url('index.php/start/userQuestion/'.$render['stu_id']) ?>" class = "myQuestion">
                <img src="<?php echo base_url('static/img/myQuestion.png');?>" alt="">提问
                <span><img src="<?php echo base_url('static/img/arrow-r.png');?>" alt=""></span>
                <label><?php echo $render['question_count'];?></label>
            </a>
            <?php
        }
        ?>
		<?php
        if($render['is_senior']){
		    ?>
            <a href="<?php echo base_url('index.php/start/userReply/'.$render['stu_id']);?>">
                <img src="<?php echo base_url('static/img/teacher.png');?>" alt="">我的回答
                <span><img src="<?php echo base_url('static/img/arrow-r.png')?>" alt=""></span>
                <label><?php echo $render['reply_count'];?></label>
            </a>
            <?php
        }
        ?>
	</div>
<?php include './application/views/footer.php'?>
</body>
<script src="http://a.alipayobjects.com/??amui/zepto/1.1.3/zepto.js,static/fastclick/1.0.6/fastclick.min.js"></script>
<script>FastClick.attach(document.body);</script>
</html>