<!DOCTYPE html>
<html>
    @section('styles')
    <link rel="stylesheet" type="text/css" href="/css/sidenav.css">
    @endsection
    @include('layouts.head', ['title' => 'CLASS'])
<body class="body-bg">
    @section('content')
        <div class="review-consult">
            <div class="container-reviews">
                @include('sections.navbar')
                <div class="tab-content" style="background-color: #f6f3ee !important; padding: 30px;">
                    <div id="admin-card" class="tab-pane fade show active">
                        <div class="col-md-12">
                            <h5>{{$result->user->name ?? ''}}</h5>
                            <br>
                            @foreach($subjects as $subject)
                                <table class="table" style="background-color:white;" border="4">
                                    <tr style="background-color:#9575cd; color:white;">
                                        <th>{{$subject->mySubject->createdSubject->name ?? ''}} - Assessment Name</th>
                                        @foreach($subject->sectionSubjectScale as $scale)
                                            <th>{{$scale->name ?? ''}}</th>
                                        @endforeach
                                        <th>Average</th>
                                    </tr>
                                    <tbody>
                                        @foreach($subject->sectionSubjectScale as $key=> $scale)
                                            @foreach($scale->subjectAssessment as $val)
                                                @if($val->teststat == 'Graded')
                                                    <tr>
                                                        <td>{{$val->name ?? ''}}</td>
                                                        @for($i=0 ; $i < (count($subject->sectionSubjectScale)) + 1; $i++)
                                                            @if($i == $key)
                                                                <td>{{$val->total ?? ''}} / {{$val->over ?? ''}}</td>
                                                            @else
                                                                <td>-</td>
                                                            @endif
                                                        @endfor
                                                    </tr>
                                                @endif
                                            @endforeach
                                        @endforeach
                                        <tr>
                                            <td>Total</td>
                                            @foreach($subject->sectionSubjectScale as $key=> $scale)
                                                @if(count($scale->subjectAssessment) > 0)
                                                    @if($scale->subjectAssessment->sum('over') > 0)
                                                        <td>{{$scale->subjectAssessment->sum('total')}} / {{$scale->subjectAssessment->sum('over')}}</td>
                                                    @else
                                                        <td>-</td>
                                                    @endif
                                                    
                                                @else
                                                <td>-</td>
                                                @endif
                                            @endforeach
                                            <td>-</td>
                                        </tr>
                                        <tr>
                                            <td>Average</td>
                                            <?php $gwa=0; ?>
                                            @foreach($subject->sectionSubjectScale as $key=> $scale)
                                                <td>
                                                    @if($scale->subjectAssessment->sum('over') > 0)
                                                    {{
                                                        round(($scale->subjectAssessment->sum('total') / $scale->subjectAssessment->sum('over')) * $scale->weight,2)
                                                    }}%
                                                    <?php $gwa=$gwa + round(($scale->subjectAssessment->sum('total') / $scale->subjectAssessment->sum('over')) * $scale->weight,2); ?>
                                                    @else
                                                        0%
                                                    @endif
                                                </td>
                                            @endforeach
                                            <td>
                                                {{$gwa}}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br><br><br>
                                
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
    
    @include('layouts.navbar', ['title' => 'CLASS- ' . $section->grade->name.' '. $section->name])
    @include('layouts.alert')
</body>
    <script type="text/javascript" src="/js/sections/navbar.js"></script>
    <script type="text/javascript" src="/js/alert.js"></script>
    <script type="text/javascript" src="/js/zipcode.js"></script>

</html>