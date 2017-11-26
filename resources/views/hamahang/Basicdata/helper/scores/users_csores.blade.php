<table class="table table-condensed">
    <thead>
    <th>نمایه</th>
    <th>کاربر</th>
    <th style="text-align: center;">تعداد امتیاز</th>
    </thead>
    <tbody>
    @foreach($scores as $score)
        @php
            $user = \App\User::find($score->uid)
        @endphp
        <tr>
            <td style="vertical-align: middle; text-align: center;">
                <img src="{{$user->AvatarLink}}" style="width:50px; height: 50px; margin:0 10px;float:right;border-radius: 50%; border: 1px solid #CCCCCC;background: #FFF;padding: 2px; "/>
            </td>
            <td style="vertical-align: middle; text-align: center;">
                <a href="{{App::make('url')->to('/')}}/{{ $user->Uname }}" style="padding-left: 10px;">{{ $user->Name . ' ' . $user->Family .' (' . $user->Uname . ')' }}</a>
            </td>
            <td style="vertical-align: middle; text-align: center;">
                <span>{{ $user->spec_scores($item_id)->count() }}</span>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>