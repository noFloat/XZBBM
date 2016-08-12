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
		$.ajax({
			  type: 'POST',
			  url: '',
			  // data to be added to query string:
			  data: { title: title ,detail : detail,tips : clicked,pic : pic},
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