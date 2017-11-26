<div style="padding: 10px;margin-bottom:  15px;">
    @if($showform=='ok')
    <form action="{{ route('hamafza.report_save') }}" method="post" enctype="multipart/form-data" name="form" >
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />

        @endif
        {!! $Grid !!}
        @if( $showform=='ok')
        <div>
            <input type="hidden" name="repid" value="{{$repid}}">
            <input type="submit" class="btn btn-primary FloatLeft" value="تایید" name="circle_add" id="submit">

        </div>
    </form>
    @endif
</div>
