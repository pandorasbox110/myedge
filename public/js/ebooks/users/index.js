
$(document).ready(function() {

	gridView();
});

function listView(){
	$('#list-view').show();
	$('#grid-view').hide();
}

function gridView(){
	$('#grid-view').show();
	$('#list-view').hide();
}

function openTg(tgid){
    
    $.ajax({
        type: "post",
        url: "/get/view/tg",
        data: {
            tgid:tgid
        },
        dataType: 'JSON',
        success: function (res) {
            console.log(res);
            console.log(res.file);
            $('#title-id').text('View Teachers Guide');
            document.getElementById("tb-frame").src = res.file;
            $("#view-modal").modal("show");
        },
        error: function(error) {
            showHttpErrorAlert(error);
        }
    });
    
}

function openCM(tgid){
    
    $.ajax({
        type: "post",
        url: "/get/view/tg",
        data: {
            tgid:tgid
        },
        dataType: 'JSON',
        success: function (res) {
            console.log(res);
            console.log(res.file);
            $('#title-id').text('View Curiculum Maps');
            document.getElementById("tb-frame").src = res.file;
            $("#view-modal").modal("show");
        },
        error: function(error) {
            showHttpErrorAlert(error);
        }
    });
    
}


function openPdfEbook(tgid){
    $('#title-id').text('View Ebook');
    document.getElementById("tb-frame").src = tgid;
    $("#view-modal").modal("show");
    
}


function openEbook(id){
    console.log(id);
    $.ajax({
        type: "post",
        url: "/get/view/ebook",
        data: {
            id:id
        },
        dataType: 'JSON',
        success: function (res) {
            console.log(res);
            $('#title-id').text(res.ebook_title);
            document.getElementById("ebook-reader-iframe").src = 'http://myedgetestsiteversion2.edupowerpublishing.com/bibi/?book=/bibi-bookshelf/' + res.file_name;
            $("#ebook-reader-modal").modal("show");
        },
        error: function(error) {
            showHttpErrorAlert(error);
        }
    });
    
}

