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
	$.ajax()
}