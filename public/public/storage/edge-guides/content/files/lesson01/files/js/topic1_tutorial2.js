/* VARIABLES */
var $topic1Slides = document.querySelectorAll(".topic1slide");
var $topic2Slides = document.querySelectorAll(".topic2slide");
var $topic1Items = document.querySelectorAll(".topic1item");
var $topic2Items = document.querySelectorAll(".topic2item");
var topic;
var topicSlide = 0;
var topicItem = 0;

/* FUNCTIONS */
var changeSlide = function(){
    switch(document.getElementById("main_submenu").options.selectedIndex){
		case 0: newPage('topic1_tutorial2a.html'); break;
		case 1: newPage('topic1_tutorial2b.html'); break;
	}
};

var showSlide = function(n){
    document.getElementById(n).classList.add("active");    
    topic = n;
    topicItem = 0;
    showTopicSlide(0);
    document.getElementById("prev").classList.add("disabled");
    document.getElementById("main_submenu").options.selectedIndex=topic;
};

var showTopicSlide = function(currentTopicSlide){
    
	document.getElementById("prev").classList.add("disabled");
	document.getElementById("next").classList.remove("disabled");
	
    switch(topic){
    
        case 0:
			[].forEach.call($topic1Items, function(x){ x.classList.remove("show"); });
			$topic1Items[0].classList.add("show");
            document.getElementById("next").classList.remove("disabled");
		break;
            
        case 1:
            [].forEach.call($topic2Slides, function(x){ x.classList.remove("show"); });
			[].forEach.call($topic2Items, function(x){ x.classList.remove("show"); });
			$topic2Slides[currentTopicSlide].classList.add("show");
			topicSlide = currentTopicSlide;
			switch(topicSlide){
				case 0: 
                    if(topicItem!=2){
                        topicItem=0; $topic2Items[0].classList.add("show");
                    }
                    else{
                        $topic2Items[0].classList.add("show");
                        $topic2Items[1].classList.add("show");
                        $topic2Items[2].classList.add("show");
                        document.getElementById("prev").classList.remove("disabled");
                    }
					break;
				case 1:
                    if(topicItem!=5){
					   topicItem=3; $topic2Items[3].classList.add("show");
                    }
                    else{
                        $topic2Items[3].classList.add("show");
                        $topic2Items[4].classList.add("show");
                        $topic2Items[5].classList.add("show");
                    }
                    document.getElementById("prev").classList.remove("disabled");
				break;
                case 2:
					if(topicItem!=8){
					   topicItem=6; $topic2Items[6].classList.add("show");
                    }
                    else{
                        $topic2Items[6].classList.add("show");
                        $topic2Items[7].classList.add("show");
                        $topic2Items[8].classList.add("show");
                    }
                    document.getElementById("prev").classList.remove("disabled");
				break;
                case 3:
					if(topicItem!=11){
					   topicItem=9; $topic2Items[9].classList.add("show");
                    }
                    else{
                        $topic2Items[9].classList.add("show");
                        $topic2Items[10].classList.add("show");
                        $topic2Items[11].classList.add("show");
                    }
                    document.getElementById("prev").classList.remove("disabled");
				break;
                case 4:
					if(topicItem!=14){
					   topicItem=12; $topic2Items[12].classList.add("show");
                    }
                    else{
                        $topic2Items[12].classList.add("show");
                        $topic2Items[13].classList.add("show");
                        $topic2Items[14].classList.add("show");
                    }
                    document.getElementById("prev").classList.remove("disabled");
				break;
                case 5:
					if(topicItem!=17){
					   topicItem=15; $topic2Items[15].classList.add("show");
                    }
                    else{
                        $topic2Items[15].classList.add("show");
                        $topic2Items[16].classList.add("show");
                        $topic2Items[17].classList.add("show");
                    }
                    document.getElementById("prev").classList.remove("disabled");
				break;
                case 6:
					if(topicItem!=20){
					   topicItem=18; $topic2Items[18].classList.add("show");
                    }
                    else{
                        $topic2Items[18].classList.add("show");
                        $topic2Items[19].classList.add("show");
                        $topic2Items[20].classList.add("show");
                    }
                    document.getElementById("prev").classList.remove("disabled");
				break;
                case 7:
					if(topicItem!=23){
					   topicItem=21; $topic2Items[21].classList.add("show");
                    }
                    else{
                        $topic2Items[21].classList.add("show");
                        $topic2Items[22].classList.add("show");
                        $topic2Items[23].classList.add("show");
                    }
                    document.getElementById("prev").classList.remove("disabled");
				break;
                case 8:
					if(topicItem!=26){
					   topicItem=24; $topic2Items[24].classList.add("show");
                    }
                    else{
                        $topic2Items[24].classList.add("show");
                        $topic2Items[25].classList.add("show");
                        $topic2Items[26].classList.add("show");
                    }
                    document.getElementById("prev").classList.remove("disabled");
				break;
                case 9:
                    topicItem=27; $topic2Items[27].classList.add("show");
                    document.getElementById("prev").classList.remove("disabled");
				break;
			}   
	}
	
};

var prev = function(){
    
    switch(topic){
        
		case 0:
			if(topicItem>0){
                $topic1Items[topicItem].classList.remove("show");
                topicItem--;
            }
		break;
		
		case 1:
            if(topicItem>0){
                $topic2Items[topicItem].classList.remove("show");
                topicItem--;
            }
            if(topicItem==26) showTopicSlide(8);
            else if(topicItem==23) showTopicSlide(7);
            else if(topicItem==20) showTopicSlide(6);
            else if(topicItem==17) showTopicSlide(5);
            else if(topicItem==14) showTopicSlide(4);
            else if(topicItem==11) showTopicSlide(3);
            else if(topicItem==8) showTopicSlide(2);
            else if(topicItem==5) showTopicSlide(1);
            else if(topicItem==2) showTopicSlide(0);
            
        break;
		
    }
    
    if(topicItem==0) document.getElementById("prev").classList.add("disabled");
    document.getElementById("next").classList.remove("disabled");
    
};

var next = function(){
    
    document.getElementById("prev").classList.remove("disabled");
    
    switch(topic){
        
		case 0:
			if(topicItem<$topic1Items.length-1) topicItem++;
			else topicItem = $topic1Items.length-1;
			if(topicItem==$topic1Items.length-1) document.getElementById("next").classList.add("disabled");
			$topic1Items[topicItem].classList.add("show");
		break;
		
		case 1:
			if(topicItem<$topic2Items.length) topicItem++;
            
            if(topicItem==3) showTopicSlide(1);
            else if(topicItem==6) showTopicSlide(2);
            else if(topicItem==9) showTopicSlide(3);
            else if(topicItem==12) showTopicSlide(4);
            else if(topicItem==15) showTopicSlide(5);
            else if(topicItem==18) showTopicSlide(6);
            else if(topicItem==21) showTopicSlide(7);
            else if(topicItem==24) showTopicSlide(8);
            else if(topicItem==27) showTopicSlide(9);
            else if(topicItem==$topic2Items.length)
                document.getElementById("next").classList.add("disabled");
            else $topic2Items[topicItem].classList.add("show");
        
        break;

    }
    
};