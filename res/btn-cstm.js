flag = 0
function showMenu(){
	if(flag == 0){
		$('.sm-menu').removeClass('hidden').addClass('show-cstm-sm');
		flag = 1
	}
	else{
		flag = 0
		$('.sm-menu').removeClass('show-cstm-sm').addClass('hidden');
	}
}
$(document).ready(function() {
	var width = $(document).width();
	if(width>768){
		$('.sm-menu').removeClass('show-cstm-sm').addClass('hidden');
	}
});
$(window).resize(function() {
	var width = $(document).width();
	if(width>768){
		$('.sm-menu').removeClass('show-cstm-sm').addClass('hidden');
	}
});