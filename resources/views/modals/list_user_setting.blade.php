@foreach($users as $user)
    @php($var=(in_array($user->id, $array_selected))? 'li_selected_listuser':'')
    <li  onclick="Select_users(this);" data_name="{{$user->Name}}" data_family="{{$user->Family}}" data_id="{{$user->id}}" Class="selected {!! $var !!}" name="" userid="">
        <div class="col-md-4" style="padding: 0px;"> {!! $user->MediumAvatar !!}</div>
        <div class="person-name col-md-8 pdt-20">{{$user->Name}} {{$user->Family}}</div>
        <div class="person-moredetail col-md-12 pdrl-15">@foreach($user->specials as $special) {{$special->title}} , @endforeach </div>
        <div class="space-12"></div>
    </li>
@endforeach
