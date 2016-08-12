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
	(function () {
		document.querySelector('input').addEventListener('keyup',function (event) {
			if (event.keyCode == 13) {
				var keyWord = document.querySelector('input').value;
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
					  data: { keyword: keyWord ,tips : clicked},
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
	})();
}