@extends('modals.modalmaster')
@section('content')
<form action="{{ route('hamafza.measure_send_report') }}" method="post" enctype="multipart/form-data" name="measure_sendReport" id="measure_sendReport">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />

    <table id="measureshow" class="table" >
        <tr>
            <td style="border:none;">
                عنوان  
            </td>
            <td colspan="4" style="border:none;">
                <label> {{$row->title}}</label>
            </td>
        </tr>
        @if(  $row->pid!='0') 
        <tr>
            <td>
                درباره صفحه  
            </td>
            <td colspan="4">
                <a target="_blank" href="{{App::make('url')->to('/')}}/{{$row->pid}}">{{$row->pagetitle}}</a>
            </td>
        </tr>
        @endif
        @if(  $row->quote!='')     
        <tr>
            <td>
                متن انتخاب شده  
            </td>
            <td style="color:red;" colspan="4">
                {{$row->quote}}
            </td>
        </tr>
        @endif

        <tr>
            <td style="border:none;">
                توضیح 
            </td>
            <td colspan="4" style="border:none;">
                {{$row->Descr}}
            </td>
        </tr>
        <tr>
            <td style="width:120px">
                واگذارکننده
            </td>
            <td colspan="4">
                <a target="_blank" href="{{App::make('url')->to('/')}}/{{$row->Uname}}">{{$row->Name}} {{$row->Family}}</a>

            </td>
        </tr>
        <tr>
            <td style="width:120px;border:none;">
                مسئول   
            </td>
            <td colspan="4" style="border:none;">
                @if(is_array($row->to))
                @foreach($row->to as $item)
        <li> {{ HTML::link($item->Uname, $item->Name. ' '.$item->Family , array('target' => '_blank'))}}
        </li>
        @endforeach
        @endif
        </td>
        </tr>
        @if (is_array($row->bc)  && count($row->bc)>0)

        <tr>
            <td style="width:120px;border:none;">
                رونوشت   
            </td>
            <td colspan="4" style="border:none;">
                @if(is_array($row->bc))
                @foreach($row->bc as $item)
        <li> {{ HTML::link($item->Uname, $item->Name. ' '.$item->Family , array('target' => '_blank'))}}
        </li>
        @endforeach
        @endif
        </td>
        </tr>
        @endif

        @if (is_array($row->files)  && count($row->files)>0)

        <tr>
            <td>
                فایل پیوست  
            </td>
            <td colspan="4">
                @foreach($row->files as $item)
        <li> {{ HTML::link('/files/measure/'.$item->name, $item->name , array('target' => '_blank'))}}
        </li>
        @endforeach
        </td>
        </tr>
        @endif


        <tr>
            <td>
                فوریت  
            </td>

            <td colspan="3" >
                {{$row->urgency}} - {{$row->priority}}
            </td>

        </tr>

        <tr>

        </tr>
        <tr>
            <td style="border:none;">
                تاریخ ارجاع  
            </td>
            <td style="border:none;">
                {{$row->reg_date}}
            </td>
            <td style="border:none;">
                مهلت انجام  
            </td>
            <td style="border:none;">{{$row->res_date}}
            </td>
        </tr>


        @if($row->allowreport == 'true') 
        <tr>
            <td>
                گزارش  
            </td>
            <td colspan="4">
                <textarea name="gozaresh" type="text" id="Descr" class="form-control" style="width:400px;"> {{$row->descr}}</textarea>
            </td>
        </tr>

        <tr>

<!--            <td >
      پیشرفت :
                      <input type="number"  class="form-control types" style="width:80px;"  value="{{$row->complete}}" pattern="[1-9]{1,3}" min="0" max="100"  name="pishraft">

  </td>-->

            <td style="border:none;">


            </td>
            <td colspan="4" style="border:none;">
                <input type="radio" name="finish" value="0" @if($row->checked=='0') checked @endif >{{trans('tasks.status_started')}}
                       <input type="radio" name="finish" value="1" @if($row->checked=='1') checked @endif>{{trans('tasks.status_started')}}
                       <input type="radio" name="finish" value="2"  @if($row->checked=='2') checked @endif>{{trans('tasks.status_done')}}
                       <input type="radio" name="finish" value="3" @if($row->checked=='3') checked @endif  @if($row->admin != Session::get('uid'))  disabled="" @endif>{{trans('tasks.status_finished')}}
            </td>
        </tr>




        <tr>
            <td colspan="4">
                <input type="hidden" name="aid" value="{{ $row->mid }}">
                <input type="hidden" name="arid" value="{{ $row->id }}">

                <input type="submit" class="btn btn-primary FloatLeft" name="measure_sendReport" value="تایید">
        <imput type="hidden" name="adminsid" value="{{ $row->admin }}">
            </td>

            </tr>

            @endif
            @if ($row->admin == '1')

            <tr>
                <td>
                    گزارش :
                </td>
                <td colspan="4">
                    <span>
                        {{ $row->descr }}
                    </span>
                </td>
            </tr>

            <tr>
                <td >
                    پیشرفت   اعلامی:
                </td>
                <td >
                    <span>
                        {{ $row->complete }}

                    </span>
                </td>
                <td>
                    تایید
                </td>
                <td colspan="4">
                    <input type="radio" name="finish_Accept" value="1">بلی
                    <input type="radio" name="finish_Accept" value="0" checked="">خیر
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <input type="hidden" name="aid" value="{{ $row->mid }}">
                    <input type="hidden" name="arid" value="{{ $row->id }}">
                    <input type="submit" name="measure_sendReport_Accept" class="btn btn-primary FloatLeft" value="تایید">
                </td>
            </tr>
            @endif
    </table>
</form>
@stop