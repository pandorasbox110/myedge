
$(document).ready(function() {

  listView();
});

function listView(){
  $('#list-view').show();
  $('#grid-view').hide();
}

function gridView(){
  $('#grid-view').show();
  $('#list-view').hide();
}

function deleteData(id){
    if (confirm("Are you sure you want to delete!")) {
  		//get canada province
  		$.ajax({
  		    type: "post",
  		    url: "/ebooks/delete",
  		    data: {
  		    	id:id
  		    },
  		    dataType: 'JSON',
  		    success: function (res) {
  		        console.log(res);
  	            if (res["status"] == "saved") {
                showSuccessAlert('Success', 'Ebook successfully delete');
                location.reload();
        }
  		    },
  	    error: function(error) {
  	        showHttpErrorAlert(error);
  	    }
  		});
    } 
}

function openPdfEbook(tgid){
    $('#title-id').text('View Ebook');
    document.getElementById("tb-frame").src = tgid;
    $("#view-modal").modal("show");
    
}