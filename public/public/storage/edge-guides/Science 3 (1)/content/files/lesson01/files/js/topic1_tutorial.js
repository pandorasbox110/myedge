/* VARIABLES */
var $topic1Slides = document.querySelectorAll(".topic1slide");
var $topic2Slides = document.querySelectorAll(".topic2slide");
var $topic3Slides = document.querySelectorAll(".topic3slide");
var $topic4Slides = document.querySelectorAll(".topic4slide");
var $topic5Slides = document.querySelectorAll(".topic5slide");
var $topic6Slides = document.querySelectorAll(".topic6slide");
var $topic1Items = document.querySelectorAll(".topic1item");
var $topic2Items = document.querySelectorAll(".topic2item");
var $topic3Items = document.querySelectorAll(".topic3item");
var $topic4Items = document.querySelectorAll(".topic4item");
var $topic5Items = document.querySelectorAll(".topic5item");
var $topic6Items = document.querySelectorAll(".topic6item");
var topic;
var topicSlide = 0;
var topicItem = 0;

/* FUNCTIONS */
var changeSlide = function(){
    switch(document.getElementById("main_submenu").options.selectedIndex){
		case 0: newPage('topic1_tutoriala.html'); break;
		case 1: newPage('topic1_tutorialb.html'); break;
		case 2: newPage('topic1_tutorialc.html'); break;
		case 3: newPage('topic1_tutoriald.html'); break;
		case 4: newPage('topic1_tutoriale.html'); break;
		case 5: newPage('topic1_tutorialf.html'); break;
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
            [].forEach.call($topic1Slides, function(x){ x.classList.remove("show"); });
			[].forEach.call($topic1Items, function(x){ x.classList.remove("show"); });
			$topic1Slides[currentTopicSlide].classList.add("show");
			topicSlide = currentTopicSlide;
            switch(topicSlide){
                case 0:
                    if(topicItem!=3){
                        topicItem=0; $topic1Items[0].classList.add("show");
                    }
                    else{
                        $topic1Items[0].classList.add("show");
                        $topic1Items[1].classList.add("show");
                        $topic1Items[2].classList.add("show");
                        $topic1Items[3].classList.add("show");
                        document.getElementById("prev").classList.remove("disabled");
                    }
                break;
                case 1:
                    if(topicItem!=5){
                        topicItem=4; $topic1Items[4].classList.add("show");
                        document.getElementById("prev").classList.remove("disabled");
                    }
                    else{
                        $topic1Items[4].classList.add("show");
                        $topic1Items[5].classList.add("show");
                        document.getElementById("prev").classList.remove("disabled");
                    }
                break;
                case 2:
                    if(topicItem!=9){
                        topicItem=6; $topic1Items[6].classList.add("show");
                        document.getElementById("prev").classList.remove("disabled");
                    }
                    else{
                        $topic1Items[6].classList.add("show");
                        $topic1Items[7].classList.add("show");
                        $topic1Items[8].classList.add("show");
                        $topic1Items[9].classList.add("show");
                        document.getElementById("prev").classList.remove("disabled");
                    }
                break;
                case 3:
                    if(topicItem!=13){
                        topicItem=10; $topic1Items[10].classList.add("show");
                        document.getElementById("prev").classList.remove("disabled");
                    }
                    else{
                        $topic1Items[10].classList.add("show");
                        $topic1Items[11].classList.add("show");
                        $topic1Items[12].classList.add("show");
                        $topic1Items[13].classList.add("show");
                        document.getElementById("prev").classList.remove("disabled");
                    }
                break;
                case 4:
                    if(topicItem!=17){
                        topicItem=14; $topic1Items[14].classList.add("show");
                        document.getElementById("prev").classList.remove("disabled");
                    }
                    else{
                        $topic1Items[14].classList.add("show");
                        $topic1Items[15].classList.add("show");
                        $topic1Items[16].classList.add("show");
                        $topic1Items[17].classList.add("show");
                        document.getElementById("prev").classList.remove("disabled");
                    }
                break;
                case 5:
                    topicItem=18; $topic1Items[18].classList.add("show");
                    document.getElementById("prev").classList.remove("disabled");
                break;
            }
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
                    topicItem=3; $topic2Items[3].classList.add("show");
                    document.getElementById("prev").classList.remove("disabled");
				break;
			}
		break;

        case 2:
			[].forEach.call($topic3Items, function(x){ x.classList.remove("show"); });
			$topic3Items[0].classList.add("show");
        break;
		
		case 3:
			[].forEach.call($topic4Slides, function(x){ x.classList.remove("show"); });
			[].forEach.call($topic4Items, function(x){ x.classList.remove("show"); });
			$topic4Slides[currentTopicSlide].classList.add("show");
			topicSlide = currentTopicSlide;
			switch(topicSlide){
				case 0: 
					if(topicItem!=3){
						topicItem=0; $topic4Items[0].classList.add("show");
					}
					else{
						$topic4Items[0].classList.add("show");
						$topic4Items[1].classList.add("show");
						$topic4Items[2].classList.add("show");
						$topic4Items[3].classList.add("show");
						document.getElementById("prev").classList.remove("disabled");
					}
					break;
                case 1: 
					if(topicItem!=7){
						topicItem=4; $topic4Items[4].classList.add("show");
					}
					else{
						$topic4Items[4].classList.add("show");
						$topic4Items[5].classList.add("show");
						$topic4Items[6].classList.add("show");
						$topic4Items[7].classList.add("show");
					}
                    document.getElementById("prev").classList.remove("disabled");
					break;
                case 2: 
					if(topicItem!=11){
						topicItem=8; $topic4Items[8].classList.add("show");
					}
					else{
						$topic4Items[8].classList.add("show");
						$topic4Items[9].classList.add("show");
						$topic4Items[10].classList.add("show");
						$topic4Items[11].classList.add("show");
					}
                    document.getElementById("prev").classList.remove("disabled");
					break;
                case 3: 
					if(topicItem!=14){
						topicItem=12; $topic4Items[12].classList.add("show");
					}
					else{
						$topic4Items[12].classList.add("show");
						$topic4Items[13].classList.add("show");
						$topic4Items[14].classList.add("show");
					}
                    document.getElementById("prev").classList.remove("disabled");
					break;
                case 4: 
					if(topicItem!=18){
						topicItem=15; $topic4Items[15].classList.add("show");
					}
					else{
						$topic4Items[15].classList.add("show");
						$topic4Items[16].classList.add("show");
						$topic4Items[17].classList.add("show");
						$topic4Items[18].classList.add("show");
					}
                    document.getElementById("prev").classList.remove("disabled");
					break;
				case 5:
					topicItem=19; $topic4Items[19].classList.add("show");
					document.getElementById("prev").classList.remove("disabled");
					break;
                case 6:
					topicItem=20; $topic4Items[20].classList.add("show");
					document.getElementById("prev").classList.remove("disabled");
					break;
			}
		break;
		
		case 4:
			[].forEach.call($topic5Slides, function(x){ x.classList.remove("show"); });
			[].forEach.call($topic5Items, function(x){ x.classList.remove("show"); });
			$topic5Slides[currentTopicSlide].classList.add("show");
			topicSlide = currentTopicSlide;
			switch(topicSlide){
				case 0: 
                    if(topicItem!=2){
                        topicItem=0; $topic5Items[0].classList.add("show");
                    }
                    else{
                        $topic5Items[0].classList.add("show");
                        $topic5Items[1].classList.add("show");
                        $topic5Items[2].classList.add("show");
                        document.getElementById("prev").classList.remove("disabled");
                    }
					break;
                case 1:
                    topicItem=3; $topic5Items[3].classList.add("show");
                    document.getElementById("prev").classList.remove("disabled");
				break;
			}
		break;
		
		case 5:		
			[].forEach.call($topic6Slides, function(x){ x.classList.remove("show"); });
			[].forEach.call($topic6Items, function(x){ x.classList.remove("show"); });
			$topic6Slides[currentTopicSlide].classList.add("show");
			topicSlide = currentTopicSlide;
			switch(topicSlide){
				case 0: 
					if(topicItem!=3){
						topicItem=0; $topic6Items[0].classList.add("show");
					}
					else{
						$topic6Items[0].classList.add("show");
						$topic6Items[1].classList.add("show");
						$topic6Items[2].classList.add("show");
						$topic6Items[3].classList.add("show");
						document.getElementById("prev").classList.remove("disabled");
					}
					break;
                case 1:
                    if(topicItem!=5){
                        topicItem=4; $topic6Items[4].classList.add("show");
                    }
                    else{
						$topic6Items[4].classList.add("show");
						$topic6Items[5].classList.add("show");
                    }
                    document.getElementById("prev").classList.remove("disabled");
                    break;
				case 2:
					topicItem=6; $topic6Items[6].classList.add("show"); 
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
            if(topicItem==17) showTopicSlide(4);
            else if(topicItem==13) showTopicSlide(3);
            else if(topicItem==9) showTopicSlide(2);
            else if(topicItem==5) showTopicSlide(1);
            else if(topicItem==3) showTopicSlide(0);
            
		break;
		
		case 1:
            if(topicItem>0){
                $topic2Items[topicItem].classList.remove("show");
                topicItem--;
            }
            if(topicItem==2) showTopicSlide(0);
            
        break;
		
		case 2:
			if(topicItem>0){
				$topic3Items[topicItem].classList.remove("show");
				topicItem--;
			}
		break;
		
		case 3:
			if(topicItem>0){
				$topic4Items[topicItem].classList.remove("show");
				topicItem--;
			}
			if(topicItem==3) showTopicSlide(0);
			else if(topicItem==7) showTopicSlide(1);
			else if(topicItem==11) showTopicSlide(2);
			else if(topicItem==14) showTopicSlide(3);
			else if(topicItem==18) showTopicSlide(4);
			else if(topicItem==19) showTopicSlide(5);
            
		break;
		
		case 4:
			if(topicItem>0){
				$topic5Items[topicItem].classList.remove("show");
				topicItem--;
			}
			if(topicItem==2) showTopicSlide(0);  
		break;
		
		case 5:
			if(topicItem>0){
				$topic6Items[topicItem].classList.remove("show");
				topicItem--;
			}
			if(topicItem==5) showTopicSlide(1);
			else if(topicItem==3) showTopicSlide(0);
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
            
            if(topicItem==4) showTopicSlide(1);
            else if(topicItem==6) showTopicSlide(2);
            else if(topicItem==10) showTopicSlide(3);
            else if(topicItem==14) showTopicSlide(4);
            else if(topicItem==18) showTopicSlide(5);
            else $topic1Items[topicItem].classList.add("show");
            
            if(topicItem==$topic1Items.length-1) document.getElementById("next").classList.add("disabled");
		break;
		
		case 1:
			if(topicItem<$topic2Items.length-1) topicItem++;
			else topicItem = $topic2Items.length-1;
            
            if(topicItem==3) showTopicSlide(1);
            else $topic2Items[topicItem].classList.add("show");

            if(topicItem==$topic2Items.length-1) document.getElementById("next").classList.add("disabled");
        break;
		
		case 2:
			if(topicItem<$topic3Items.length-1) topicItem++;
			else topicItem = $topic3Items.length-1;
			$topic3Items[topicItem].classList.add("show");
			if(topicItem==$topic3Items.length-1) document.getElementById("next").classList.add("disabled");
		break;
		
		case 3:
			if(topicItem<$topic4Items.length-1) topicItem++;
			else topicItem = $topic4Items.length-1;
			if(topicItem==4) showTopicSlide(1);
			else if(topicItem==8) showTopicSlide(2);
			else if(topicItem==12) showTopicSlide(3);
			else if(topicItem==15) showTopicSlide(4);
			else if(topicItem==19) showTopicSlide(5);
			else if(topicItem==20) showTopicSlide(6);
			else $topic4Items[topicItem].classList.add("show");
			if(topicItem==$topic4Items.length-1) document.getElementById("next").classList.add("disabled");
		break;
		
		case 4:
			if(topicItem<$topic5Items.length-1) topicItem++;
			else topicItem = $topic5Items.length-1;
            
			if(topicItem==3) showTopicSlide(1);
            else $topic5Items[topicItem].classList.add("show");
                
            if(topicItem==$topic5Items.length-1) document.getElementById("next").classList.add("disabled");
        break;
		
		case 5:
            if(topicItem<$topic6Items.length) topicItem++;
                        
            if(topicItem==4) showTopicSlide(1);
			else if(topicItem==6) showTopicSlide(2);
            else if(topicItem==$topic6Items.length)
                document.getElementById("next").classList.add("disabled");
            else $topic6Items[topicItem].classList.add("show");
            
		break;
   
    }
    
};