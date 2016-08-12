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

	for (var i = 0; i <= document.querySelectorAll('.comment').length - 1; i++) {
		(function (i) {
			var like = document.querySelectorAll('.like')[i].innerText;
			document.querySelectorAll('.comment')[i].addEventListener('click',function(e){
			if (e.target.className == "likePic") {
					document.querySelectorAll('.like')[i].innerHTML = '<img class = "likePic click" src="static/img/like.png" alt="">' + (parseInt(document.querySelectorAll('.like')[i].innerText) + 1);
				} else if (e.target.className == "likePic click"){			
					document.querySelectorAll('.like')[i].innerHTML = '<img class = "likePic" src="static/img/dislike.png" alt="">' + (parseInt(document.querySelectorAll('.like')[i].innerText) - 1);
				}
				/*
					questionID,commentID是为了定位把赞存在哪里。这两个ID是数据库里面的ID，渲染页面的时候渲染出来
				*/
				questionID = document.querySelector('.content').getAttribute("questionID");
				commentID = document.querySelectorAll('.comment')[i].getAttribute("commentID");
				console.log(commentID);
				$.ajax({
					type: 'POST',
					url: '',
					// data to be added to query string:
					data: { questionID : questionID,commentID : commentID,like : like},
					// type of data we are expecting in return:
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
		$.ajax({
			  type: 'POST',
			  url: '',
			  // data to be added to query string:
			  data: { comment : comment,pic : pic},
			  // type of data we are expecting in return:
			  dataType: 'json',
			  timeout: 300,
			  success: function(data){
			    
			  },
			  error: function(xhr, type){
			    alert('Ajax error!')
			  }
			})
		})
	})();	
}