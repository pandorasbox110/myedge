<!DOCTYPE html>
<html>
    @section('styles')
    <link rel="stylesheet" type="text/css" href="/css/sidenav.css"> 
    <link rel="stylesheet" type="text/css" href="/css/chat.css">
    <link rel="stylesheet" type="text/css" href="/css/font-awesome.min.css">
    @endsection

    @include('layouts.head', ['title' => 'ANNOUNCEMENT'])
    <body class="body-bg">
        @section('content')
            <div class="review-consult">
                <div class="container-reviews">
                    @include('messages.navbar')
                    <div class="tab-content" style="background-color: #f6f3ee !important; padding: 30px; width:70%">
                        <h4>Announcements</h4>
                        <div class="row space-title">
                            <div class="col-6">
                                <form class="input-group" action="/forums" autocomplete="off">
                                    <div class="input-group-prepend">
                                        <button class="search-btn geo-primary" data-toggle="tooltip" title="Search">
                                            <i class="fa fa-search"></i>
                                        </button>
                                         <input type="text" class="form-control mr-12"  name="keyword" placeholder="Search Topic" value="{{$keyword}}" col=13>
                                    </div>
                                </form>
                                <br><br>
                            </div>
                            <div class="col-6">
                                <a href="/forums/create" class="right geo-primary mb-1 button-add" data-toggle="tooltip" title="Add Post">
                                   New<i class="fa fa-plus"></i>
                                </a>
                            </div>
                        </div>
                        <div style="overflow: auto;" class="border">
                            @foreach($results as $result)
                                <div style="background-color:white;padding:20px;">
                                    <div style="display: inline-flex;">
                                        <span class="my-account-2 my-lg-0 pointer" data-toggle="popover" id="my-account">
                                            <img src="/images/default.png" class="profile-img-forum">
                                        </span>
                                        <div style="margin-top:10px;display: inline-flex;margin-left:5px;">
                                            <span style="margin-right:5px;">
                                                <h5>{{$result->user->name ?? ''}}</h5>
                                            </span>
                                            <span style="margin-left:5px;margin-right:5px;margin-top:-2px;">
                                                <i class="fas fa-caret-right fa-2x"></i>
                                            </span>
                                            <span>
                                                <h5>{{$result->section->name ?? 'public'}}</h5>
                                            </span>
                                        </div>
                                        <span style="margin-top:25px;margin-left:-345px;">
                                            {{date("D, d M Y", strtotime($result->date_created))}}
                                        </span>
                                    </div>
                                    <hr>
                                    <div>
                                            <?php   
                                                echo $result->post ?? ''; 
                                            ?>
                                    </div>
                                    <hr>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <i class="far fa-thumbs-up"></i>
                                                LIKE
                                            </div>
                                            <div class="col-md-4">
                                                <i class="fas fa-heart"></i>
                                                HEART
                                            </div>
                                            <div class="col-md-4">
                                                <i class="far fa-comment-alt"></i>
                                                COMMENT
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="col-md-12">
                                        <div class="row">
                                            ADD YOUR COMMENTS HERE
                                        </div>
                                    </div>
                                </div>
                                <br>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endsection
        @include('layouts.navbar', ['title' => 'MESSAGE'])
        @include('layouts.alert')
        <script type="text/javascript" src="/js/alert.js"></script>
        <script type="text/javascript" src="/js/messages/chats/chat.js"></script>
        <script type="text/javascript" src="/js/messages/navbar.js"></script>
    </body>
</html>