<div class="d-flex no-print" id="wrapper">
    
    <!-- Sidebar -->
    <div class="border-right geo-border-primary" id="sidebar-wrapper">
      <!--
        <div style="background-color: #214a8c !important;">
             <center>
                <img src="/images/logo-new.gif" class="m-2 "><br>
              
             </center>
        </div>
        -->
        <div style="align-items: center !important;">
            <!--
            <a href="/home" class="sidenav-home list-group-item @if (Request::is('dashboards*')) sidenav-home-active @endif " >
                <span class="fas fa-home fa-1x sidenav-center"></span>
                <span>HOME</span>
            </a>
            -->
            <a href="/home" class="sidenav-home list-group-item @if (Request::is('dashboards*')) sidenav-home-active @endif " >
                <div class="SN_Btn" id='home_SNBtn'></div>
            </a>

            <!-- super admin -->
            @if(Auth::user()->userType->name == 'Super Admin')

            <!-- admin -->
            @elseif(Auth::user()->userType->name == 'Admin')
            
                <a href="/users/admins" class="sidenav-user list-group-item @if (Request::is('users*')) sidenav-user-active @endif">
                    <div class="SN_Btn" id='users_SNBtn'></div>
                </a>
                
                <a href="/ebooks" class="sidenav-ebook list-group-item @if (Request::is('ebooks*')) sidenav-ebook-active @endif">
                    <div class="SN_Btn" id='ebook_SNBtnADMIN'></div>
                </a>
                
                <!--
                <a href="/subjects" class="sidenav-subject list-group-item @if (Request::is('subjects*')) sidenav-subject-active @endif">
                    <div class="SN_Btn" id='subject_SNBtnADMIN'></div>
                </a>
                
              
                <a href="/sections" class="sidenav-class list-group-item @if (Request::is('sections*')) sidenav-class-active @endif" >
                    <div class="SN_Btn" id='classes_SNBtn_IA'></div>
                </a>
                -->
                
                
                <!--
                <a href="/employees" class="sidenav-assessment list-group-item @if (Request::is('employees*')) sidenav-assessment-active @endif">
                    <div class="SN_Btn" id='scorm_SNBtn'></div>
                </a>
                -->
                
                <a href="/textbooks/workbooks" class="sidenav-textbook list-group-item @if (Request::is('textbooks*')) sidenav-textbook-active  @endif">
                     <div class="SN_Btn" id='textbook_SNBtn'></div>
                </a>
                
                <a href="/createdsubjects" class="sidenav-subject list-group-item @if (Request::is('createdsubjects*')) sidenav-subject-active @endif">
                    <div class="SN_Btn" id='subject_SNBtn2'></div>
                </a>
                
                <a href="/subjects/get/mysubjects" class="sidenav-subject list-group-item @if (Request::is('subjects*')) sidenav-subject-active @endif">
                    <div class="SN_Btn" id='subject_SNBtn2'></div>
                </a>
                
                <a href="/employees" class="sidenav-assessment list-group-item @if (Request::is('employees*')) sidenav-assessment-active @endif">
                    <div class="SN_Btn" id='scorm_SNBtn2'></div>
                </a>
                
                <a href="/chats" class="sidenav-message list-group-item @if (Request::is('messages*')) sidenav-module-active  @endif">
                    <div class="SN_Btn" id='module_SNBtn_ADMIN'></div>
                </a>
                
                <a href="/chats" class="sidenav-message list-group-item @if (Request::is('messages*')) sidenav-message-active  @endif">
                    <div class="SN_Btn" id='message_SNBtn'></div>
                </a>
                
                 <a href="/employees" class="sidenav-payment list-group-item @if (Request::is('employees*')) sidenav-payment-active @endif">
                     <div class="SN_Btn" id='payment_SNBtn'></div>
                </a>
                
                 <a href="/activation" class="sidenav-activationcode list-group-item @if (Request::is('activation*')) sidenav-activationcode-active @endif">
                    <div class="SN_Btn" id='activation_SNBtn'></div>
                </a>
                
                
                
                <!--
                <a href="/users/admins" class="sidenav-user list-group-item @if (Request::is('users*')) sidenav-user-active @endif">
                    <div class="fas fa-users fa-1x sidenav-center"></div>
                    <span style="margin-left: -3px;">USERS</span>
                </a>
                

                <a href="/ebooks" class="sidenav-ebook list-group-item @if (Request::is('ebooks*')) sidenav-ebook-active @endif">
                    <div class="fas fa-book-reader fa-1x sidenav-center"></div>
                    <span style="margin-left: -8px;">EBOOKS</span>
                </a>
                
                <a href="/subjects" class="sidenav-subject list-group-item @if (Request::is('subjects*')) sidenav-subject-active @endif">
                    <div class="fas fa-book fa-1x sidenav-center"></div>
                    <span style="margin-left: -10px;">SUBJECTS</span>
                </a>
                

                <a href="/employees" class="sidenav-assessment list-group-item @if (Request::is('employees*')) sidenav-assessment-active @endif">
                    <div class="fas fa-sticky-note fa-1x sidenav-center"></div>
                    <span style="margin-left: -4px; font-size: 11px;">SCORM</span>
                </a>
                
                
                <a href="/textbooks/workbooks" class="sidenav-textbook list-group-item @if (Request::is('textbooks*')) sidenav-textbook-active  @endif">
                    <div class="fas fa-book-open fa-1x sidenav-center"></div>
                    <span class="text-center">TEXT<br>BOOKS</span>
                </a>
                
               

                <a href="/employees" class="sidenav-payment list-group-item @if (Request::is('employees*')) sidenav-payment-active @endif">
                    <div class="fas fa-money-bill-alt fa-1x sidenav-center"></div>
                    <span style="margin-left: -13px;">PAYMENTS</span>
                </a>
                

                <a href="/employees" class="sidenav-activationcode list-group-item @if (Request::is('employees*')) sidenav-activationcode-active @endif">
                    <div class="fas fa-user-lock fa-1x sidenav-center"></div>
                    <span style="margin-left: -15px;font-size: 11px;">ACTIVATION CODE</span>
                </a>
                
                <a href="/chats" class="sidenav-message list-group-item @if (Request::is('messages*')) sidenav-message-active @endif">
                    <div class="fas fa-envelope fa-1x sidenav-center"></div>
                    <span style="margin-left:-12px;">MESSAGE</span>
                </a>

                <a href="/employees" class="sidenav-forum list-group-item @if (Request::is('employees*')) sidenav-forum-active @endif">
                    <div class="far fa-comments fa-1x sidenav-center"></div>
                    <span style="margin-left: -10px;">FORUM</span>
                </a>
                
                <a href="/employees" class="sidenav-chat list-group-item @if (Request::is('employees*')) sidenav-chat-active @endif">
                    <div class="fas fa-comments fa-1x sidenav-center"></div>
                    <span style="margin-left: 1px;">CHAT</span>
                </a>
                
                <a href="/guides" class="sidenav-guide list-group-item @if (Request::is('guides*')) sidenav-guide-active @endif">
                    <div class="fa fa-users fa-1x sidenav-center"></div>
                    <span>EDGE GIDES</span>
                </a>
                
                -->
            @elseif(Auth::user()->userType->name == 'Institute Admin')
                <!--<a href="/users/teachers" class="sidenav-user list-group-item @if (Request::is('users*')) sidenav-user-active @endif">-->
                <!--    <div class="fas fa-users fa-1x sidenav-center"></div>-->
                <!--    <span style="margin-left: -3px;">USERS</span>-->
                <!--</a>-->
                
                <a href="/users/teachers" class="sidenav-user list-group-item @if (Request::is('users*')) sidenav-user-active @endif">
                    <div class="SN_Btn" id='users_SNBtn_IA'></div>
                </a>
                
               
                <a href="/sections" class="sidenav-class list-group-item @if (Request::is('sections*')) sidenav-class-active @endif" >
                    <div class="SN_Btn" id='classes_SNBtn_IA'></div>
                </a>
               
                
                
                <a href="/libraries" class="sidenav-library list-group-item @if (Request::is('libraries')) sidenav-library-active @endif">
                    <div class="SN_Btn" id='library_SNBtn_IA'></div>
                </a>
                <a href="/ebooks/get/myebooks" class="sidenav-ebook list-group-item @if (Request::is('ebooks*')) sidenav-ebook-active @endif">
                    <div class="SN_Btn" id='ebook_SNBtn_IA'></div>
                </a>
                
              
                <a href="/subjects/get/mysubjects" class="sidenav-subject list-group-item @if (Request::is('subjects*')) sidenav-subject-active @endif">
                    <div class="SN_Btn" id='subject_SNBtn_IA'></div>
                </a>
              
                
                <a href="/chats" class="sidenav-message list-group-item @if (Request::is('messages*')) sidenav-module-active  @endif">
                    <div class="SN_Btn" id='module_SNBtn_ADMIN'></div>
                </a>
                
                
                <a href="/chats" class="sidenav-message list-group-item @if (Request::is('messages*')) sidenav-message-active  @endif">
                    <div class="SN_Btn" id='message_SNBtn'></div>
                </a>
                <a href="/guides" class="sidenav-guide list-group-item @if (Request::is('guides*')) sidenav-guide-active @endif">
                    <div class="SN_Btn" id='product_SNBtn2'></div>
                </a>
            
                <a href="/activation" class="sidenav-activationcode list-group-item @if (Request::is('activation*')) sidenav-activationcode-active @endif">
                    <div class="SN_Btn" id='activation_SNBtn'></div>
                </a>
                
                <!--<a href="/sections" class="sidenav-class list-group-item @if (Request::is('sections*')) sidenav-class-active @endif" >-->
                <!--    <div class="fa fa-users fa-1x sidenav-center"></div>-->
                <!--    <span style="margin-left: -7px;">CLASSES</span>-->
                <!--</a>-->
                <!--<a href="/libraries" class="sidenav-library list-group-item @if (Request::is('libraries')) sidenav-library-active @endif">-->
                <!--    <div class="fa fa-archive fa-1x sidenav-center"></div><br>-->
                <!--    <span style="margin-left: -7px;">LIBRARY</span>-->
                <!--</a>-->
                <!--<a href="/chats" class="sidenav-message list-group-item @if (Request::is('messages*')) sidenav-message-active  @endif">-->
                <!--    <div class="fas fa-envelope fa-1x sidenav-center"></div>-->
                <!--    <span  style="margin-left: -7px;">MESSAGE</span>-->
                <!--</a>-->
                <!--<a href="/ebooks/get/myebooks" class="sidenav-ebook list-group-item @if (Request::is('ebooks*')) sidenav-ebook-active @endif">-->
                <!--    <div class="fa fa-book fa-1x sidenav-center"></div>-->
                <!--    <span  style="margin-left: -2px;">EBOOKS</span>-->
                <!--</a>-->
                <!--<a href="/subjects/get/mysubjects" class="sidenav-subject list-group-item @if (Request::is('subjects*')) sidenav-subject-active @endif">-->
                <!--    <div class="fa fa-book fa-1x sidenav-center"></div>-->
                <!--    <span>EDGE</span>-->
                <!--    <span style="margin-left: -12px;">SUBJECTS</span>-->
                <!--</a>-->
                <!--<a href="/guides" class="sidenav-guide list-group-item @if (Request::is('guides*')) sidenav-guide-active @endif">-->
                <!--    <div class="fa fa-book fa-1x sidenav-center"></div>-->
                <!--    <span  style="margin-left: -15px;">PRODUCTS</span>-->
                <!--</a>-->
            @elseif(Auth::user()->userType->name == 'Teacher')
             
                
              
                <a href="/sections" class="sidenav-class list-group-item @if (Request::is('sections*')) sidenav-class-active @endif" >
                    <div class="SN_Btn" id='classes_SNBtn'></div>
                </a>
                <a href="/libraries" class="sidenav-library list-group-item @if (Request::is('libraries')) sidenav-library-active @endif">
                    <div class="SN_Btn" id='library_SNBtn'></div>
                </a>
                <a href="/ebooks/get/myebooks" class="sidenav-ebook list-group-item @if (Request::is('ebooks*')) sidenav-ebook-active @endif">
                    <div class="SN_Btn" id='ebook_SNBtn'></div>
                </a>
                <a href="/subjects/get/mysubjects" class="sidenav-subject list-group-item @if (Request::is('subjects*')) sidenav-subject-active @endif">
                    <div class="SN_Btn" id='subject_SNBtn'></div>
                </a>
                <a href="" class="sidenav-subject list-group-item @if (Request::is('messages*')) sidenav-module-active @endif">
                     <div class="SN_Btn" id='module_SNBtn'></div>
                </a>
                
                
                
                <a href="/chats" class="sidenav-message list-group-item @if (Request::is('messages*')) sidenav-message-active  @endif">
                    <div class="SN_Btn" id='message_SNBtn2'></div>
                </a>
                <a href="/guides" class="sidenav-guide list-group-item @if (Request::is('guides*')) sidenav-guide-active @endif">
                    <div class="SN_Btn" id='product_SNBtn'></div>
                </a>
            
                <a href="/activation" class="sidenav-guide list-group-item @if (Request::is('activation*')) sidenav-activationcode-active @endif">
                    <div class="SN_Btn" id='activation_SNBtn'></div>
                </a>
                
            @elseif(Auth::user()->userType->name == 'Student')
                <!--<a href="/sections" class="sidenav-class list-group-item @if (Request::is('sections*')) sidenav-class-active @endif" >-->
                <!--    <div class="fa fa-users fa-1x sidenav-center"></div>-->
                <!--    <span style="margin-left: -7px;">CLASSES</span>-->
                <!--</a>-->
                <!--<a href="/" class="sidenav-library list-group-item @if (Request::is('')) sidenav-library-active @endif">-->
                <!--    <div class="fa fa-archive fa-1x sidenav-center"></div><br>-->
                <!--    <span style="margin-left: -7px;">LIBRARY</span>-->
                <!--</a>-->
                <!--<a href="/chats" class="sidenav-message list-group-item @if (Request::is('messages*')) sidenav-message-active  @endif">-->
                <!--    <div class="fas fa-envelope fa-1x sidenav-center"></div>-->
                <!--    <span  style="margin-left: -7px;">MESSAGE</span>-->
                <!--</a>-->
                <!--<a href="/ebooks/get/myebooks" class="sidenav-ebook list-group-item @if (Request::is('ebooks*')) sidenav-ebook-active @endif">-->
                <!--    <div class="fa fa-book fa-1x sidenav-center"></div>-->
                <!--    <span  style="margin-left: -2px;">Ebooks</span>-->
                <!--</a>-->
                <!--<a href="/" class="sidenav-guide list-group-item @if (Request::is('guides*')) sidenav-guide-active @endif">-->
                <!--    <div class="fa fa-book fa-1x sidenav-center"></div>-->
                <!--    <span  style="margin-left: -15px;">PRODUCTS</span>-->
                <!--</a>-->
                
                <a href="/sections" class="sidenav-class list-group-item @if (Request::is('sections*')) sidenav-class-active @endif" >
                    <div class="SN_Btn" id='classes_SNBtn'></div>
                </a>
                <a href="/libraries" class="sidenav-library list-group-item @if (Request::is('libraries')) sidenav-library-active @endif">
                    <div class="SN_Btn" id='library_SNBtn'></div>
                </a>
                <a href="/ebooks/get/myebooks" class="sidenav-ebook list-group-item @if (Request::is('ebooks*')) sidenav-ebook-active @endif">
                    <div class="SN_Btn" id='ebook_SNBtn'></div>
                </a>
                <a href="/subjects/get/mysubjects" class="sidenav-subject list-group-item @if (Request::is('subjects*')) sidenav-subject-active @endif">
                    <div class="SN_Btn" id='subject_SNBtn'></div>
                </a>
                <a href="/chats" class="sidenav-message list-group-item @if (Request::is('messages*')) sidenav-message-active  @endif">
                    <div class="SN_Btn" id='message_SNBtn'></div>
                </a>
                <a href="/guides" class="sidenav-guide list-group-item @if (Request::is('guides*')) sidenav-guide-active @endif">
                    <div class="SN_Btn" id='product_SNBtn2'></div>
                </a>
                <a href="/activation" class="sidenav-guide list-group-item @if (Request::is('activation*')) sidenav-activationcode-active @endif">
                    <div class="SN_Btn" id='activation_SNBtn'></div>
                </a>
            
            @endif
        </div>
    </div>
    <!-- /#sidebar-wrapper -->
   <!-- Page Content -->
    <div id="page-content-wrapper">
        <nav class="navbar navbar-expand-lg" style="background-color: #428bca;">
            <button class="navbar-brand navbar-toggler text-light" type="button" id="menu-toggle">
                <i class="fa fa-bars"></i>
            </button>
            <button class="navbar-toggler text-light" type="button" data-toggle="collapse" data-target="#navbar_main" aria-expanded="false">
                <i class="fa fa-bars"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbar_main" style="padding:10px;">
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                    <li class="nav-item active">
                        <img src="/images/logo/myedge_logo-03.png" id='myedgeLogo'>
                    </li>
                </ul>
                <span class="my-account-2 my-lg-0 pointer" data-toggle="popover" id="my-account">
                    <img src="/images/default.png" class="profile-img">
                    <span class='accntNameHolder'>
                        <span class='aHolder'>
                            <span class='accntName'>{{Auth::user()->name ?? 'Welcome user!'}}</span>
                            <span class='accntPosition'>{{Auth::user()->userType->name ?? ''}}</span>
                            <!--<span class='accntName'>Stacey Anne Dela Cruz</span>-->
                            <!--<span class='accntPosition'>Teacher</span>-->
                        </span>
                    </span>
                </span>
            </div>
        </nav>
        <div style="width: 100%;padding-left: 20px; padding-right: 20px;">
        <!-- <div class="container-fluid"> -->
            @yield('content')
        </div>
    </div>
    <!-- /#page-content-wrapper -->

</div>
<!-- /#wrapper -->

<script type="text/javascript">
    $("#menu-toggle").click(function(e) {
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");
        });

        $('#my-account').popover({
            placement : 'bottom',
            html : true,
            content : `
                <div id="my-account-drop">
                    <a href="/profile" class="row pointer">
                        <div class="pt-2 pb-2 col-3">
                            <i class="fas fa-user-cog"></i>
                        </div>
                        <div class="pt-2 pb-2 col-9 ">
                            My Account
                        </div>
                    </a>
                    
                    <a href="/logout" class="row pointer">
                        <div class="pt-2 pb-2 col-3">
                            <i class="fa fa-sign-out-alt"></i>
                        </div>
                        <div class="pt-2 pb-2 col-9 ">
                            Logout
                        </div>
                    </a>
                </div>
            `
        });

        $('body').on('click', function (e) {
            $('[data-toggle=popover]').each(function () {
                if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('#my-account-drop').has(e.target).length === 0) {
                    $(this).popover('hide');
                }
            });
        });
</script>



