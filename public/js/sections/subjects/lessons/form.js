

$(document).ready(function() {
    checkActiveLi();
});

function createModalDismiss(){
     $("#create-modal").modal("hide");
     location.reload();
}
// $('#create-modal').on('hidden.bs.modal', function () {
//     location.reload();
// });

function checkActiveLi(){
    $('.subject-li').removeClass('active');
    id=$('#lesson').val();
    $(`#subject-li-${id}`).addClass( "active" );
}

function addLesson(lesson_id){
    $.ajax({
        type: "post",
        url: "/sections/subjects/get-lesson",
        data: {
            lesson_id:lesson_id,
        },
        dataType: 'JSON',
        success: function (res) {
            console.log(res);
            $('#lesson-id').val(lesson_id);
            $('#lesson').val(res.name);
        },
        error: function(error) {
            showHttpErrorAlert(error);
        }
    });
    $("#lesson-modal").modal("show");
}

function deleteLesson(id){
    section=$('#section').val();
    subject=$('#subject').val();
    if (confirm("Are you sure you want to delete!")) {
        //get canada province
        $.ajax({
            type: "post",
            url: "/sections/subjects/lessons/delete",
            data: {
                id:id
            },
            dataType: 'JSON',
            success: function (res) {
                if (res["status"] == "saved") {
                showSuccessAlert('Success', 'Lesson successfully delete');
                window.location = `/sections/subjects/lessons/view/${section}/${subject}/null`;
              }
            },
            error: function(error) {
                showHttpErrorAlert(error);
            } 
        });
    } 
}


function uploadLesson(id){
    
    $.ajax({
            type: "post",
            url: "/sections/subjects/lessons/status",
            data: {
                id:id,
                status:1,
            },
            dataType: 'JSON',
            success: function (res) {
                if (res["status"] == "saved") {
                showSuccessAlert('Success', 'Lesson successfully uploaded/published,Enrolled Student and Institutional Admin can now see this lesson');
                location.reload();
              }
            },
            error: function(error) {
                showHttpErrorAlert(error);
            } 
    });
}

function hideLesson(id){
    
    $.ajax({
            type: "post",
            url: "/sections/subjects/lessons/status",
            data: {
                id:id,
                status:0,
            },
            dataType: 'JSON',
            success: function (res) {
                if (res["status"] == "saved") {
                showSuccessAlert('Success', 'Lesson successfully unpublished,You and shared teacher can only see this lesson');
                location.reload();
              }
            },
            error: function(error) {
                showHttpErrorAlert(error);
            } 
    });
}

function uploadTopicStatus(id){
    
    $.ajax({
            type: "post",
            url: "/sections/subjects/lessons/topic/status",
            data: {
                id:id,
                status:1,
            },
            dataType: 'JSON',
            success: function (res) {
                if (res["status"] == "saved") {
                showSuccessAlert('Success', 'Topic successfully uploded/published,Enrolled Student and Institutional Admin can now see this topic');
                location.reload();
              }
            },
            error: function(error) {
                showHttpErrorAlert(error);
            } 
    });
}

function hideTopic(id){
    
    $.ajax({
            type: "post",
            url: "/sections/subjects/lessons/topic/status",
            data: {
                id:id,
                status:0,
            },
            dataType: 'JSON',
            success: function (res) {
                if (res["status"] == "saved") {
                showSuccessAlert('Success', 'Topic successfully unpublished,You and shared teacher can only see this topic');
                location.reload();
              }
            },
            error: function(error) {
                showHttpErrorAlert(error);
            } 
    });
}

function uploadTopic(topic_id){
    $.ajax({
        type: "post",
        url: "/sections/subjects/lessons/topic/view",
        data: {
            topic_id:topic_id,
        },
        dataType: 'JSON',
        success: function (res) {
            console.log(res);
            $('#topic-id').val(topic_id);
            $('#name').val(res.name);
        },
        error: function(error) {
            showHttpErrorAlert(error);
        }
    });
	$("#upload-modal").modal("show");
}

function createTopic(topic_id){

    $.ajax({
        type: "post",
        url: "/sections/subjects/lessons/topic/view",
        data: {
            topic_id:topic_id,
        },
        dataType: 'JSON',
        success: function (res) {
            console.log(res);
            $('#topic-id2').val(topic_id);
            $('#name2').val(res.name);
            $('#editor').html(res.content);
        },
        error: function(error) {
            showHttpErrorAlert(error);
        }
    });
	$("#create-modal").modal("show");
}

function viewTopic(topic_id){
	console.log(topic_id);
	//get topic
	$.ajax({
        type: "post",
        url: "/sections/subjects/lessons/topic/view",
        data: {
        	topic_id:topic_id,
        },
        dataType: 'JSON',
        success: function (res) {
            console.log(res);
            if(res.content_type == 'doc'){
                $('#span1').text(res.name);
                extension=res.content.substring(res.content.lastIndexOf("."));
                console.log(extension);
                if(extension == '.pdf' || extension == '.mp3' || extension == '.mp4'){
                    
                    document.getElementById("topic-frame").src = res.content;
                    $('#topic-image').hide();
                    
                }else if(extension == '.jpg' || extension == '.jpeg' || extension == '.png'){
                    
                    document.getElementById("topic-image").src = res.content;
                    $('#topic-frame').hide();
                    
                }else{
                    var base_path = $('#appurl').val();
                    tmp=`https://docs.google.com/gview?url=${base_path}${res.content}&embedded=true`
                    document.getElementById("topic-frame").src = tmp;
                    $('#topic-image').hide();
                }
                
                $("#view-modal").modal("show");
            }else{
                $('#span2').text(res.name);
                $('#container').html(res.content);
                $("#view2-modal").modal("show");
            }
            
        },
        error: function(error) {
            showHttpErrorAlert(error);
        }
    });
}

function deleteData(id){
    if (confirm("Are you sure you want to delete!")) {
        //get canada province
        $.ajax({
            type: "post",
            url: "/sections/subjects/lessons/topic/delete",
            data: {
                id:id
            },
            dataType: 'JSON',
            success: function (res) {
                if (res["status"] == "saved") {
                showSuccessAlert('Success', 'Topic successfully delete');
                location.reload();
              }
            },
            error: function(error) {
                showHttpErrorAlert(error);
            } 
        });
    } 
}


