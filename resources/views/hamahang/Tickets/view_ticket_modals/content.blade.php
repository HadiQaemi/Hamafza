<table id="measureshow" class="table " style="width: 100%;">
    <tr>
        <td style="border:none;width:80px;">فرستنده:</td>
        @if($ticket->sender_user)
            <td>
                <a href='{{App::make('url')->to('/')}}/{{ $ticket->sender_user->Uname }}' target="_blank">{{ $ticket->sender_user->Name }} {{ $ticket->sender_user->Family }}</a>
            </td>
        @endif
    </tr>
    <tr>
        <td style="border:none;">گیرنده:</td>
        <td style="border:none;">
            @if($ticket->receiver_users)
                @foreach($ticket->receiver_users as $receiver_user)
                    <span><a target="_blank" href="{{App::make('url')->to('/')}}/{{$receiver_user->Uname}}">{{$receiver_user->Name}} {{$receiver_user->Family}}
                </a>
                        @if($ticket->receiver_users->count() > 1)
                            ،
                        @endif
                </span>
                @endforeach
            @endif
        </td>
    </tr>
    <tr>
        <td style="border:none;">زمان ارسال:</td>
        <td style="border:none;">{{$ticket->jalali_reg_date}}</td>
    </tr>
    <tr>
        <td colspan="2" style="padding-right: 25px"><b>{{$ticket->title}}</b></td>
    </tr>
    <tr>
        <td colspan="2" style="border:none;padding-right: 25px">{!!$ticket->ticket_answer->comment!!}</td>
    </tr>
    @if($ticket->files)
        <tr>
            <td> پیوست:

            </td>
            <td>
                @foreach($ticket->files as $file)
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