/* VARIABLES */
var $topic1Slides = document.querySelectorAll(".topic1slide");
var $topic2Slides = document.querySelectorAll(".topic2slide");
var $topic3Slides = document.querySelectorAll(".topic3slide");
var $topic1Items = document.querySelectorAll(".topic1item");
var $topic2Items = document.querySelectorAll(".topic2item");
var $topic3Items = document.querySelectorAll(".topic3item");
var topic;
var topicSlide = 0;
var topicItem = 0;

/* FUNCTIONS */
var changeSlide = function(){
    switch(document.getElementById("main_submenu").options.selectedIndex){
		case 0: newPage('topic1_tutorial3a.html'); break;
		case 1: newPage('topic1_tutorial3b.html'); break;
		case 2: newPage('topic1_tutorial3c.html'); break;
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
                    if(topicItem!=4){
					   topicItem=3; $topic2Items[3].classList.add("show");
                    }
                    else{
                        $topic2Items[3].classList.add("show");
                        $topic2Items[4].classList.add("show");
                    }
                    document.getElementById("prev").classList.remove("disabled");
				break;
                case 2:
					if(topicItem!=6){
					   topicItem=5; $topic2Items[5].classList.add("show");
                    }
                    else{
                        $topic2Items[5].classList.add("show");
                        $topic2Items[6].classList.add("show");
                    }
                    document.getElementById("prev").classList.remove("disabled");
				break;
                case 3:
					if(topicItem!=8){
					   topicItem=7; $topic2Items[7].classList.add("show");
                    }
                    else{
                        $topic2Items[7].classList.add("show");
                        $topic2Items[8].classList.add("show");
                    }
                    document.getElementById("prev").classList.remove("disabled");
				break;
                case 4:
					topicItem=9; $topic2Items[9].classList.add("show"); 
					document.getElementById("prev").classList.remove("disabled");
				break;
			}
        break;
            
        case 2:
            [].forEach.call($topic3Slides, function(x){ x.classList.remove("show"); });
			[].forEach.call($topic3Items, function(x){ x.classList.remove("show"); });
			$topic3Slides[currentTopicSlide].classList.add("show");
			topicSlide = currentTopicSlide;
			switch(topicSlide){
				case 0: 
                    if(topicItem!=1){
                        topicItem=0; $topic3Items[0].classList.add("show");
                    }
                    else{
                        $topic3Items[0].classList.add("show");
                        $topic3Items[1].classList.add("show");
                        document.getElementById("prev").classList.remove("disabled");
                    }
                break;
				case 1:
                    if(topicItem!=3){
                        topicItem=2; $topic3Items[2].classList.add("show");
                    }
                    else{
                        $topic3Items[2].classList.add("show");
                        $topic3Items[3].classList.add("show");
                    }
                    document.getElementById("prev").classList.remove("disabled");
				break;
                case 2:
                    if(topicItem!=5){
                        topicItem=4; $topic3Items[4].classList.add("show");
                    }
                    else{
                        $topic3Items[4].classList.add("show");
                        $topic3Items[5].classList.add("show");
                    }
                    document.getElementById("prev").classList.remove("disabled");
				break;
                case 3:
                    if(topicItem!=7){
                        topicItem=6; $topic3Items[6].classList.add("show");
                    }
                    else{
                        $topic3Items[6].classList.add("show");
                        $topic3Items[7].classList.add("show");
                    }
                    document.getElementById("prev").classList.remove("disabled");
				break;
                case 4:
                    if(topicItem!=9){
                        topicItem=8; $topic3Items[8].classList.add("show");
                    }
                    else{
                        $topic3Items[8].classList.add("show");
                        $topic3Items[9].classList.add("show");
                    }
                    document.getElementById("prev").classList.remove("disabled");
				break;
                case 5:
                    if(topicItem!=12){
                        topicItem=10; $topic3Items[10].classList.add("show");
                    }
                    else{
                        $topic3Items[10].classList.add("show");
                        $topic3Items[11].classList.add("show");
                        $topic3Items[12].classList.add("show");
                    }
                    document.getElementById("prev").classList.remove("disabled");
				break;
                case 6:
                    if(topicItem!=16){
                        topicItem=13; $topic3Items[13].classList.add("show");
                    }
                    else{
                        $topic3Items[13].classList.add("show");
                        $topic3Items[14].classList.add("show");
                        $topic3Items[15].classList.add("show");
                        $topic3Items[16].classList.add("show");
                    }
                    document.getElementById("prev").classList.remove("disabled");
				break;
                case 7:
                    if(topicItem!=20){
                        topicItem=17; $topic3Items[17].classList.add("show");
                    }
                    else{
                        $topic3Items[17].classList.add("show");
                        $topic3Items[18].classList.add("show");
                        $topic3Items[19].classList.add("show");
                        $topic3Items[20].classList.add("show");
                    }
                    document.getElementById("prev").classList.remove("disabled");
				break;
                case 8:
                    if(topicItem!=25){
                        topicItem=21; $topic3Items[21].classList.add("show");
                    }
                    else{
                        $topic3Items[21].classList.add("show");
                        $topic3Items[22].classList.add("show");
                        $topic3Items[23].classList.add("show");
                        $topic3Items[24].classList.add("show");
                        $topic3Items[25].classList.add("show");
                    }
                    document.getElementById("prev").classList.remove("disabled");
				break;
                case 9:
                    if(topicItem!=28){
                        topicItem=26; $topic3Items[26].classList.add("show");
                    }
                    else{
                        $topic3Items[26].classList.add("show");
                        $topic3Items[27].classList.add("show");
                        $topic3Items[28].classList.add("show");
                    }
                    document.getElementById("prev").classList.remove("disabled");
				break;
                case 10:
                    if(topicItem!=32){
                        topicItem=29; $topic3Items[29].classList.add("show");
                    }
                    else{
                        $topic3Items[29].classList.add("show");
                        $topic3Items[30].classList.add("show");
                        $topic3Items[31].classList.add("show");
                        $topic3Items[32].classList.add("show");
                    }
                    document.getElementById("prev").classList.remove("disabled");
				break;
                case 11:
                    if(topicItem!=38){
                        topicItem=33; $topic3Items[33].classList.add("show");
                    }
                    else{
                        $topic3Items[33].classList.add("show");
                        $topic3Items[34].classList.add("show");
                        $topic3Items[35].classList.add("show");
                        $topic3Items[36].classList.add("show");
                        $topic3Items[37].classList.add("show");
                        $topic3Items[38].classList.add("show");
                    }
                    document.getElementById("prev").classList.remove("disabled");
				break;
                case 12:
					topicItem=39; $topic3Items[39].classList.add("show"); 
					document.getElementById("prev").classList.remove("disabled");
				break;
            }
            break;
            
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
            if(topicItem==8) showTopicSlide(3);
            else if(topicItem==6) showTopicSlide(2);
            else if(topicItem==4) showTopicSlide(1);
            else if(topicItem==2) showTopicSlide(0);
            
        break;
		
		case 2:
			if(topicItem>0){
				$topic3Items[topicItem].classList.remove("show");
				topicItem--;
			}
            if(topicItem==1) showTopicSlide(0);
            else if(topicItem==3) showTopicSlide(1);
            else if(topicItem==5) showTopicSlide(2);
            else if(topicItem==7) showTopicSlide(3);
            else if(topicItem==9) showTopicSlide(4);
            else if(topicItem==12) showTopicSlide(5);
            else if(topicItem==16) showTopicSlide(6);
            else if(topicItem==20) showTopicSlide(7);
            else if(topicItem==25) showTopicSlide(8);
            else if(topicItem==28) showTopicSlide(9);
            else if(topicItem==32) showTopicSlide(10);
            else if(topicItem==38) showTopicSlide(11);
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
            $topic1Items[topicItem].classList.add("show");
            if(topicItem==$topic1Items.length-1) document.getElementById("next").classList.add("disabled");
		break;
		
		case 1:
			if(topicItem<$topic2Items.length-1) topicItem++;
			else topicItem = $topic2Items.length-1;
            if(topicItem==3) showTopicSlide(1);
            else if(topicItem==5) showTopicSlide(2);
            else if(topicItem==7) showTopicSlide(3);
            else if(topicItem==9) showTopicSlide(4);
            else $topic2Items[topicItem].classList.add("show");

            if(topicItem==$topic2Items.length-1) document.getElementById("next").classList.add("disabled");
        break;
		
		case 2:
			if(topicItem<$topic3Items.length) topicItem++;
			
            if(topicItem==2) showTopicSlide(1);
            else if(topicItem==4) showTopicSlide(2);
            else if(topicItem==6) showTopicSlide(3);
            else if(topicItem==8) showTopicSlide(4);
            else if(topicItem==10) showTopicSlide(5);
            else if(topicItem==13) showTopicSlide(6);
            else if(topicItem==17) showTopicSlide(7);
            else if(topicItem==21) showTopicSlide(8);
            else if(topicItem==26) showTopicSlide(9);
            else if(topicItem==29) showTopicSlide(10);
            else if(topicItem==33) showTopicSlide(11);
            else if(topicItem==39) showTopicSlide(12);
            else if(topicItem==$topic3Items.length)
                document.getElementById("next").classList.add("disabled");
            else $topic3Items[topicItem].classList.add("show");
			
		break;
		
    }
    
};