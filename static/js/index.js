window.onload =function () {
	var left = document.querySelector('.top-left');
	var right = document.querySelector('.top-right');
	var by;
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
		}
		$.ajax({
			  type: 'GET',
			  url: 'http://locahost/XZBBM/index.php/api/getQuestion/' + by + '',
			  dataType: 'json',
			  timeout: 300,
			  success: function(data){
			    
			  },
			  error: function(xhr, type){
			    alert('Ajax error!')
			  }
		})
	})

	$('body').on('touchmove',function (e) {
		$.ajax({
			  type: 'GET',
			  url: 'http://locahost/XZBBM/index.php/api/getQuestion' + by,
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
			    	} else if (by == "最热问题") {
			    		$(".hot").append(node);
			    	}
			    }) 
			  },
			  error: function(xhr, type){
			    alert('Ajax error!')
			  }
		})
	})

	document.querySelector('input').addEventListener('keyup',function (event) {
		if (event.keyCode == 13) {
			var keyWord = document.querySelector('input').value;
			$.ajax({
				  type: 'POST',
				  url: '',
				  // data to be added to query string:
				  data: { keyword: keyWord },
				  // type of data we are expecting in return:
				  dataType: 'json',
				  timeout: 300,
				  success: function(data){
				    
				  },
				  error: function(xhr, type){
				    alert('Ajax error!')
				  }
			})
		}
	})
}