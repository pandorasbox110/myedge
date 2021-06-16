<!DOCTYPE html>
<html>
    @section('styles')
    <link rel="stylesheet" type="text/css" href="/css/sidenav.css">
    @endsection
    @include('layouts.head', ['title' => 'My Profile'])
<body class="body-bg">
    @section('content')
      <form class="border geo-border-primary rounded p-3" > 
       
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-2">
                    <img src="/images/default.png" onerror="this.src='/images/default.png'" width="100%" height="290px;" class="geo-border-primary border mt-2">
                </div>
                <div class="col-md-4">
                    <h3>{{$profile->userType->name ?? '' }}{{$profile->name ?? ''}}</h3>
                    <table class="form-control table" width="100%">
                        <tr>
                            <td>Email : {{$profile->email ?? ''}}</td>
                        </tr>
                        <tr>
                            <td>Gender : {{$profile->gender ?? ''}}</td>
                        </tr>
                        <tr>
                            <td>Birth Date : {{$profile->birthday ?? ''}}</td>
                        </tr>
                        <tr>
                            <td>Address : {{$profile->address->complete ?? ''}}</td>
                        </tr>
                        <tr>
                            <td>Country : Philippines</td>
                        </tr>
                        <tr>
                            <td>Institution : {{$profile->institute->name ?? ''}}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
      </form>
    @endsection
    @include('layouts.navbar', ['title' => 'MY PROFILE'])
    @include('layouts.alert')
 
</body>
</html>