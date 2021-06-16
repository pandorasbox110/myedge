<!DOCTYPE html>
<html>
    @section('styles')
    <link rel="stylesheet" type="text/css" href="/css/sidenav.css"> 
    <link rel="stylesheet" type="text/css" href="/css/chat.css">
    <link rel="stylesheet" type="text/css" href="/css/font-awesome.min.css">
    @endsection

    @include('layouts.head', ['title' => 'Chat'])
    <body class="body-bg">
        @section('content')
            <div class="review-consult">
                <div class="container-reviews">
                    @include('messages.navbar')
                    <div class="tab-content" style="background-color: #f6f3ee !important; padding: 30px;">
                        <div style="overflow: auto;" class="border">
                             <table class="table border table-td-top" style="background-color:white !important;height: 90vh !important">
                                <tr style="height: 1%">
                                    <td style="width: 30%">
                                        <button type="button" class="btn btn-sm btn-success float-right" id="compose_btn">
                                            <i class="fa fa-edit"></i> Compose
                                        </button>
                                        Conversations
                                    </td>
                                    <td class="border-left">
                                        <center><span id="title">Select Conversation</span></center>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="p-0" rowspan="2" style="height: 100%">
                                        <div style="height: inherit; overflow-y: scroll;" id="messages">
                                            @foreach($conversations as $conversation)
                                            <div class="p-2 border-bottom div-hover view-conversation {{$conversation->seen == 0 ? 'unread' : ''}}" id="conversation-{{$conversation->id}}" value="{{$conversation->id}}">
                                                <span class="date small float-right">{{date('M d, Y h:i A', strtotime($conversation->updated_at))}}</span>
                                                <span>{{$conversation->title}}</span>
                                                <br>
                                                <span class="message small">{{$conversation->last_message}}</span>
                                            </div>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="border-left p-0" style="height: 100%">
                                        <div class="p-3" style="display: none" id="compose">
                                            <input type="text" class="form-control" id="search_user" placeholder="Search user">
                                        </div>
                                        <div class="p-4" style="height: inherit; overflow-y: scroll;" id="chats"></div>
                                    </td>
                                </tr>
                                <tr style="height: 1%">
                                    <td class="border-left">
                                        <form id="message_form">
                                            <textarea class="form-control" placeholder="Write a message" required minlength="1" id="message_text"></textarea>
                                            <button class="btn btn-primary float-right mt-2"><i class="fa fa-paper-plane"></i> Send</button>
                                        </form>
                                    </td>
                                </tr>
                            </table>
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