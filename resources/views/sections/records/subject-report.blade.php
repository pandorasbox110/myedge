<!DOCTYPE html>
<html>
    @section('styles')
    <link rel="stylesheet" type="text/css" href="/css/sidenav.css">
    @endsection
    @include('layouts.head', ['title' => 'REPORT'])
    <body class="body-bg">
        @section('content')
            <h5>CLASS- {{$section->grade->name}} {{$section->name}}</h5>
            <br>
            <div class="col-md-12">
                <table class="table border rounded " border="2">
                    <tr>
                        <th style="background-color:#142d57;color:white;">Student Name</th>
                        @foreach($scales as $scale)
                            <th colspan="{{count($scale->subjectAssessment)}}" style="background-color:#142d57;color:white;">{{$scale->name ?? ''}}</th>
                        @endforeach
                        <th style="background-color:#142d57;color:white;">Average</th>
                    </tr>
                    <tr>
                        <td></td>
                        @foreach($scales as $scale)
                            @if(count($scale->subjectAssessment) > 0)
                                @foreach($scale->subjectAssessment as $subAss)
                                    <td>{{$subAss->name ?? ''}}</td>
                                @endforeach
                            @else
                                <td></td>
                            @endif
                        @endforeach
                        <td></td>
                    </tr>
                    @foreach($results as  $result) 
                        <?php $gwa=0; ?>
                        <?php $gtotal=0; ?>
                        <tr>
                            <td>{{$result[0]->user->name ?? ''}}</td>
                            @foreach($result[1] as  $value)
                                    @if(count($value) > 0)
                                        @foreach($value as  $val)
                                            @if($val)
                                                <td>{{$val->total_score ?? ''}}/{{$val->over_score ?? ''}}</td>
                                            @else
                                                <td style="color:red;">INC</td>
                                            @endif
                                        @endforeach
                                    @else
                                    <td></td>
                                    @endif
                            @endforeach
                            <td style="font-weight:bold;">{{$result[2] ?? '0'}} %</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        @endsection
        @include('layouts.navbar', ['title' => 'CLASS- ' . $section->grade->name.' '. $section->name])
        @include('layouts.alert')
    </body>
    <script type="text/javascript" src="/js/sections/navbar.js"></script>
    <script type="text/javascript" src="/js/sections/students/create.js"></script>
    <script type="text/javascript" src="/js/alert.js"></script>
</html>