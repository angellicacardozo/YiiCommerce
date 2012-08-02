$(document).ready(function(){
			$("#show_cats > ul").hide();
			$("#show_cats").hover(showMenu,hideMenu);
}); // close document.ready

function showMenu() { $("#show_cats > ul").show();}
function hideMenu() { $("#show_cats > ul").hide();}