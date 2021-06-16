$(document).ready(function() {
	
 removeClass();
  type=$('#type').val();
  if(type == 'chat'){

      $('#chat-li').addClass( "active" );

  }else if(type == 'email'){

      $('#email-li').addClass( "active" );

  }else if(type == 'forum'){
      $('#forum-li').addClass( "active" );

  }
 
});

function removeClass(){

  $('#chat-li').removeClass('active');
  $('#email-li').removeClass('active');
  $('#forum-li').removeClass('active');
}