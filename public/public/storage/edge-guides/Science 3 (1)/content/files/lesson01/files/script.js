document.getElementById("body").onload = function(){
document.getElementById("body").style.opacity="1"; }

var showTOC = function(){
    document.getElementById("toc").classList.add("open");
    document.getElementById("toc_btn").setAttribute("style","display: none");
};

var closeTOC = function(){
    document.getElementById("toc").classList.remove("open");
    document.getElementById("toc_btn").setAttribute("style","display: block");
};

var showObjectives = function(){
    document.getElementById("body_bg_popup").classList.add("show");
    document.getElementById("objectives").classList.add("show");
};

var closeObjectives = function(){
    document.getElementById("body_bg_popup").classList.remove("show");
    document.getElementById("objectives").classList.remove("show");
};

var showInstructions = function(){
    document.getElementById("body_bg_popup").classList.add("show");
    document.getElementById("instructions").classList.add("show");
};

var closeInstructions = function(){    
    document.getElementById("body_bg_popup").classList.remove("show");
    document.getElementById("instructions").classList.remove("show");
};

var showConfirmation = function(){
    document.getElementById("body_bg_popup").classList.add("show");
    document.getElementById("confirmation").classList.add("show");
};

var closeConfirmation = function(){
    document.getElementById("body_bg_popup").classList.remove("show");
    document.getElementById("confirmation").classList.remove("show");
};

var openFeedback = function(){
    document.getElementById("body_bg_popup").classList.add("show");
    document.getElementById("feedback").classList.add("show");
};

var closeFeedback = function(){
    document.getElementById("body_bg_popup").classList.remove("show");
    document.getElementById("feedback").classList.remove("show");
};

var openProgress = function(){
    document.getElementById("body_bg_popup").classList.add("show");
    document.getElementById("progress").classList.add("show");
};

var closeProgress = function(){
    document.getElementById("body_bg_popup").classList.remove("show");
    document.getElementById("progress").classList.remove("show");
};

var newPage = function(x){
    window.open(x, '_self', false);
};

//Icons
var chk = '<img src="../../img/check.png" class="ans_icon"/>';
var crs = '<img src="../../img/cross.png" class="ans_icon"/>';

//Feedback
var fb01 = '<img src="../../img/feedback_01.png"/>';
var fb02 = '<img src="../../img/feedback_02.png"/>';
var fb03 = '<img src="../../img/feedback_03.png"/>';
var fb04 = '<img src="../../img/feedback_04.png"/>';
var fb05 = '<img src="../../img/feedback_05.png"/>';

//Key listener
window.addEventListener("keydown", keyListener, false);
function keyListener(e) {
	switch(e.keyCode) {
		case 37:
            // left key pressed
            prev();
			break;
		case 39:
			// right key pressed
            next();
            break;
	}	
}