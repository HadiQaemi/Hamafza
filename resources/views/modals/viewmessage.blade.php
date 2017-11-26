<table id="measureshow" class="table " style="width: 100%;">
    <tr>
        <td style="border:none;width:80px;">فرستنده:</td>
        <td><a href='{{App::make('url')->to('/')}}/{{$message->Uname}}' target="_blank">{{$message->sendname}} {{$message->sendfamily}}</a>
        </td>
    </tr>
    <tr>
        <td style="border:none;">گیرنده:</td>
        <td style="border:none;">
            @if(is_array($message->Reciver ))
                @foreach($message->Reciver as $r)
                    <span><a target="_blank" href="{{App::make('url')->to('/')}}/{{$r->Uname}}">{{$r->Name}} {{$r->Family}}
                </a>
                        @if(count($message->Reciver)>1)
                            ،
                        @endif
            </span>
                @endforeach
            @endif
        </td>
    </tr>
    <tr>
        <td style="border:none;">زمان ارسال:</td>
        <td style="border:none;">{{$message->reg_date}}</td>
    </tr>
    <tr>
        <td colspan="2" style="padding-right: 25px"><b>{{$message->title}}</b></td>
    </tr>
    <tr>
        <td colspan="2" style="border:none;padding-right: 25px">{!!$message->comment!!}</td>
    </tr>
    @if(is_array($message->Files ) && count($message->Files)>0)
        <tr>
            <td> پیوست:

            </td>
            <td>
                @foreach($files as $file)
                    <li><a target="_blank" title="دریافت فایل" href="{{route('FileManager.DownloadFile',['type'=>'ID','id'=>enCode(($file->id))])}}">{{$file->originalName . '.' . $file->extension . '     -     ' . $file->human_size}}</a>
                    </li>
                @endforeach
                {{--@foreach($message->Files as $F)--}}
                    {{--<li><a target="_blank" href="{{App::make('url')->to('/')}}/files/ticket/{{$F->name}}">{{$F->title}} </a></li>--}}
                {{--@endforeach--}}
            </td>
        </tr>
    @endif
    <tr>
        <td>
        </td>
        <td>
        </td>
    </tr>
</table>