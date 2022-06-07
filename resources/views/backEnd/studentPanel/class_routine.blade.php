@extends('backEnd.master')
@section('title')
@lang('academics.class_routine')
@endsection
@section('mainContent')
<section class="sms-breadcrumb mb-40 white-box">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>Class Routine </h1>
            <div class="bc-pages">
                <a href="{{route('dashboard')}}">@lang('common.dashboard')</a>
                <a href="#">@lang('academics.class_routine')</a>
            </div>
        </div>
    </div>
</section>

@if(isset($class_times))
<section class="mt-20">
    <div class="container-fluid p-0">
        <div class="row mt-40">
            <div class="col-lg-6 col-md-6">
                <div class="main-title">
                    <h3 class="mb-30">@lang('academics.class_routine')</h3>
                </div>
            </div>
            <div class="col-lg-6 pull-right">
                <a href="{{route('classRoutinePrint', [@$class_id, @$section_id])}}" class="primary-btn small fix-gr-bg pull-right" target="_blank"><i class="ti-printer"> </i> Print</a>
                
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <table id="default_table" class="display school-table " cellspacing="0" width="100%">
                        <tr>
                            @php
                                $height= 0;
                                $tr = [];
                            @endphp
                            @foreach($sm_weekends as $sm_weekend)
                              
                                @if( $sm_weekend->studentClassRoutine->count() > $height)
                                    @php
                                        $height =  $sm_weekend->studentClassRoutine->count();
                                    @endphp
                                @endif
                
                                <th>{{@$sm_weekend->name}}</th>
                            @endforeach
                
                        </tr>
                
                        @php
                            $used = [];
                            $tr=[];
                
                        @endphp
                        @foreach($sm_weekends as $sm_weekend)
                        @php
                        
                            $i = 0;
                        @endphp
                            @foreach($sm_weekend->studentClassRoutine as $routine)
                                @php
                                if(!in_array($routine->id, $used)){
                                    $tr[$i][$sm_weekend->name][$loop->index]['subject']= $routine->subject ? $routine->subject->subject_name :'';
                                    $tr[$i][$sm_weekend->name][$loop->index]['subject_code']= $routine->subject ? $routine->subject->subject_code :'';
                                    $tr[$i][$sm_weekend->name][$loop->index]['class_room']= $routine->classRoom ? $routine->classRoom->room_no : '';
                                    $tr[$i][$sm_weekend->name][$loop->index]['teacher']= $routine->teacherDetail ? $routine->teacherDetail->full_name :'';
                                    $tr[$i][$sm_weekend->name][$loop->index]['start_time']=  $routine->start_time;
                                    $tr[$i][$sm_weekend->name][$loop->index]['end_time']= $routine->end_time;
                                    $tr[$i][$sm_weekend->name][$loop->index]['is_break']= $routine->is_break;
                                    $used[] = $routine->id;
                                } 
                                     
                                @endphp
                            @endforeach
                
                            @php
                                
                                $i++;
                            @endphp
                
                        @endforeach
                
                       @for($i = 0; $i < $height; $i++)
                       <tr>
                        @foreach($tr as $days)
                         @foreach($sm_weekends as $sm_weekend)
                            <td>
                                @php
                                     $classes=gv($days,$sm_weekend->name);
                                 @endphp
                                 @if($classes && gv($classes,$i))              
                                   @if($classes[$i]['is_break'])
                                  <strong > @lang('academics.break') </strong>
                                     
                                   <span class=""> ({{date('h:i A', strtotime(@$classes[$i]['start_time']))  }}  - {{date('h:i A', strtotime(@$classes[$i]['end_time']))  }})  <br> </span> 
                                    @else
                                    <span class=""> <strong>@lang('common.time') :</strong> {{date('h:i A', strtotime(@$classes[$i]['start_time']))  }}  - {{date('h:i A', strtotime(@$classes[$i]['end_time']))  }}  <br> </span> 
                                        <span class=""> <strong>   {{ $classes[$i]['subject'] }} </strong> ({{ $classes[$i]['subject_code'] }}) <br>  </span>            
                                        @if ($classes[$i]['class_room'])
                                            <span class=""> <strong>@lang('academics.room') :</strong>     {{ $classes[$i]['class_room'] }}  <br>     </span>
                                        @endif    
                                        @if ($classes[$i]['teacher'])
                                          <span class=""> {{ $classes[$i]['teacher'] }}  <br> </span>
                                        @endif           
                    
                                        
                                     @endif
                
                                @endif
                                
                            </td>
                            @endforeach
                
                  
                                    
                        @endforeach
                       </tr>
                
                       @endfor
                    </table>
            </div>
        </div>
    </div>
</section>

@endif



@endsection
