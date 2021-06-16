$(document).ready(function() {

	$('#institute-div').hide();
	$('#grade-div').hide();
	$('#submit-bnt').prop('disabled', true);
});

$('#user-type-id').on('change', function() {
  if(this.value === '5'){//student

  	$('#institute-div').show();
  	$('#grade-div').show();

  }else if (this.value === '4'){//teacher
  	$('#institute-div').show();

  }else{
  	$('#institute-div').hide();
  	$('#grade-div').hide();
  }
  //append institite
  	appendInstiture();

});


function appendInstiture(){
	$.ajax({
	        type: "get",
	        url: "/self/users/get-institute",
	        data: null,
	        dataType: 'JSON',
	        success: function (res) {
	        	console.log(res);
	            companies=res;
				let Companies = jQuery.grep(companies, function(element, i) {
	                return element.id;
	            });
	            console.log(Companies);
	            if (Companies != null) {
	                initUnrestrictedAutocomplete('#institute-name', '#institute-id', Companies);
	            }

	        },
	    error: function(error) {
	       showHttpErrorAlert(error);
	    }
	});
}


$(".remember").change(function() {
    if(this.checked) {
        $('#submit-bnt').prop('disabled', false);
    }else{
    	$('#submit-bnt').prop('disabled', true);
    }
});

function openterm(){
    $("#terms-modal").modal("show");
}
