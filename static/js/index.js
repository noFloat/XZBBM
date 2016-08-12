window.onload =function () {
	var left = document.querySelector('.top-left');
	var right = document.querySelector('.top-right');
	document.querySelector(".top").addEventListener('click',function (event) {
		if(event.target.innerText == "最新问题") {
			left.className = "top-left click";
			right.className = "top-right";
			document.querySelector('.new').style.display = "block";
			document.querySelector('.hot').style.display = "none";
		} else if(event.target.innerText == "最热问题") {
			left.className = "top-left";
			right.className = "top-right click";
			document.querySelector('.hot').style.display = "block";
			document.querySelector('.new').style.display = "none";
		}
		$.ajax({
			  type: 'GET',
			  url: '' + e.target.innerText,
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
		var by = document.querySelector('.click').innerText;
		$.ajax({
			  type: 'GET',
			  url: '' ,
			  dataType: 'json',
			  timeout: 300,
			  success: function(data){
			    
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