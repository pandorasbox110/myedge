<!DOCTYPE html>
<html>
    @section('styles')
    <link rel="stylesheet" type="text/css" href="/css/sidenav.css">
    @endsection

    @include('layouts.head', ['title' => 'USERS '])
    <body class="body-bg">
        @section('content')
            <div class="review-consult">
                @if($errors->any())
                <h4>{{$errors->first()}}</h4>
                @endif
                <h1>Book Activation Keys</h1>

                <form action="/activation/claim" method="POST">
                    @csrf

                    @if(session('message'))
                        <div class="alert">Book Claimed</div>
                    @endif
                    <input type="text" name="activation_key" >
                    <input type="submit" class="submit_button" value="Activate Code">
                </form>

            </div>
        @endsection
    @include('layouts.navbar', ['title' => 'ACTIVATIONS'])
    @include('layouts.alert')
    <script type="text/javascript" src="/js/alert.js"></script>
    <script type="text/javascript" src="/js/users/navbar.js"></script>
    <script type="text/javascript" src="/js/users/admins/index.js"></script>
    </body>
</html>
