    $(document).ready(function(){
        $(".fadein").click(function(){
            $(".option-overlay").fadeIn();
        });
        $(".fadeout").click(function(){
            $(".option-overlay").fadeOut();
        });
        
        $("#tutorial").fadeIn("slow");
        
        //$("#tutorial").click(function(){
        //    $("#tutorial").fadeOut("slow");
        //});
        
        
        $("#tutorial").click(function(){
            $("#tutorial").fadeOut("slow");
        });
        $("#tutorial div").click(function(e) {
            e.stopPropagation();
        });
        
        // Activate Carousel
        $("#myCarousel").carousel("pause");

        // Click on the button to start sliding 
        $("#myBtn").click(function(){
            $("#myCarousel").carousel("cycle");
        });

        // Click on the button to stop sliding 
        $("#myBtn2").click(function(){
            $("#myCarousel").carousel("pause");
        });

        // Enable Carousel Indicators
        $(".item1").click(function(){
            $("#myCarousel").carousel(0);
        });
        $(".item2").click(function(){
            $("#myCarousel").carousel(1);
        });
        $(".item3").click(function(){
            $("#myCarousel").carousel(2);
        });
        $(".item4").click(function(){
            $("#myCarousel").carousel(3);
        });
        $(".item5").click(function(){
            $("#myCarousel").carousel(4);
        });

        // Enable Carousel Controls
        $(".left").click(function(){
            $("#myCarousel").carousel("prev");
        });
        $(".right").click(function(){
            $("#myCarousel").carousel("next");
        });
        
         window.addEventListener("keydown", keyListener, false);
    function keyListener(e) {
        switch(e.keyCode) {
            case 27: //esc arrow
                $(".option-overlay").fadeOut();
                $("#tutorial").fadeOut("slow");
            break;
            case 39: //right arrow
                $("#myCarousel").carousel("next");
            break;
            case 37: //left up
                $("#myCarousel").carousel("prev");
            break;
        }	
    }

        
    });