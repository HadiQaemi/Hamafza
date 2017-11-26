@extends('modals.modalmaster')
@section('content')
<table  class="table">
    <tbody><tr>
            <td>عنوان</td>

            <td>
                {{$Not->subject2}}
            </td>
        </tr>
        <tr>
            <td>تاریخ ارسال</td>

            <td>
                {{$Not->sendate}}
            </td>
        </tr>
        <tr>
            <td>متن</td>

            <td>
                {{$Not->body}}
                
            </td>
        </tr>
        
         <tr>
           

             <td colspan="2">
               
                <p style="text-align: left;">
                    <a href="  {{$Not->link}}" target="_blank" >  {{$Not->link}}</a>             
                </p>
            </td>
        </tr>
    </tbody></table>

@if($Not->read=='0')
<script>
    var c = $('.DesktopNotificaton').html();
    if(c>0){
            c = c * 1 - 1;
    $('.DesktopNotificaton').html(c);
    }if(c==0){
    $('.DesktopNotificaton').hide();
    }

</script>
@endif
@stop