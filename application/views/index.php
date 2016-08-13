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
	<?php include './application/views/footer.php'?>
<script src = "<?php echo base_url('static/js/index.js');?>"></script>
</html>