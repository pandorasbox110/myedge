
    $(document).ready(function(){
    
    
        var start = 1;
        var totalslide = 8;
        
       //hides all the slides 
        while (start <= totalslide) {
            $( "#"+start ).hide();
            start++;
        }
        
        var pageno = 1;
        var start = 1;
        
        if(pageno == start){
            $(".previous").addClass("disabled");
        }
        
        $("#"+pageno).show();
        $(".next").click(function(){
            if(pageno < totalslide){
                pageno++;
                $("#"+(pageno-1)).hide();
                $("#"+pageno).fadeIn();
                if((pageno > 0 && pageno < 6) || (pageno > 6 && pageno < 9)){
                    document.getElementById('showme').src = "content/" + pageno + ".html";
                }
                if(pageno == totalslide){
                    $(".next").addClass("disabled");
                }
                else {
                    $(".next").removeClass("disabled");
                    $(".previous").removeClass("disabled");
                }
            }
        });
        
        $(".previous").click(function(){
            if(pageno > start){
                $( "#"+(pageno-1)).fadeIn();
                $( "#"+pageno).hide();
                pageno--;
                if((pageno > 0 && pageno < 6) || (pageno > 6 && pageno < 9)){
                    document.getElementById('showme').src = "content/" + pageno + ".html";
                }
                if(pageno == start){
                    $(".previous").addClass("disabled");
                }
                else {
                    $(".previous").removeClass("disabled");
                    $(".next").removeClass("disabled");
                }
            }
        });
        
        $(".close-me").click(function(){
            $("#intro").fadeOut(300);
        });
        
        $(".close-me2").click(function(){
            $("#intro").fadeOut(300);
        });
        
    });