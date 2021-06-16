<!DOCTYPE html>
<html>
    @section('styles')
    <link rel="stylesheet" type="text/css" href="/css/sidenav.css">
    @endsection

    @include('layouts.head', ['title' => 'USERS '])
    <body class="body-bg">
        @section('content')
            <div class="review-consult">
                <h2 class="pb-2">Activation Keys for  {{$book->ebook_title}}</h2>
                <form action="/activation" method="POST" class="pb-2">
                    @csrf
                    <input type="hidden" name="book_id" value="{{$book->id}}">
                    <input class="form-control" type="number" name="count" value="1">
                    <input type="submit" value="Generate">
                </form>
                <form action="" class="py-3" method="get">
                    <label for="">Claimed</label>
                    <input type="radio" name="filter" value="claimed" id="">
                    <label for="">Unclaimed</label>
                    <input type="radio" name="filter" value="unclaimed" id="">

                    <input type="submit" class="submit_button" value="Filter">
                 </form>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Activation Key</th>
                            <th>Claimed By</th>
                            <th>Date Generated</th>
                            <th>Date Claimed</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>



                        @foreach (\App\Activation::
                        when(request()->input('filter')=='claimed',function($q){
                            return $q->where('status',1);
                        })->
                        when(request()->input('filter')=='unclaimed',function($q){
                            return $q->where('status',0);
                        })->
                        where('book_id',$book->id)->orderBy('created_at','asc')->get() as $item)

                            <tr>
                                <td>{{$item->activation_key}}</td>
                                <td>
                                   {{$item->status?$item->teacher->email:'unclaimed'}}
                                </td>
                                <td>{{$item->created_at}}</td>
                                <td>{{$item->claimed_at}}</td>
                                <td>
                                    <button class="del_button" data-id="{{$item->id}}"> Delete</button>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        @endsection
    @include('layouts.navbar', ['title' => 'ACTIVATIONS'])
    @include('layouts.alert')
    <script>
      $('.del_button').each(function () {
            var $this = $(this);
            $this.on("click", function () {
                let key = $(this).data('id');
                let conf = confirm('Are you sure you want to delete this key?')

                if(conf){
                    $.ajax({
                method: "delete",
                url: `/activation/${key}`,
                context: document.body
                }).done(function() {
                    window.location.reload()
                });
                }
            });
        });
    </script>
    <script type="text/javascript" src="/js/alert.js"></script>
    <script type="text/javascript" src="/js/users/navbar.js"></script>
    <script type="text/javascript" src="/js/users/admins/index.js"></script>
    </body>
</html>
