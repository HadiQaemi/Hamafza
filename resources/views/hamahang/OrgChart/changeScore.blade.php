<div class="row col-xs-12 margin-top-50">
    <form class="" name="change_score_form" id="change_score_form" method="post" enctype="multipart/form-data">
        <div class="col-xs-12 noRightPadding noLeftPadding">
            <input type="hidden" name="item" value="{{$score}}"/>
            <input type="hidden" name="job" value="{{enCode($job_id)}}"/>
            @foreach($options as $k=>$option)
                <div class="col-xs-12 margin-top-20 noRightPadding noLeftPadding">
                    <div class="col-xs-12 noRightPadding noLeftPadding">
                        <input type="radio" value="{{($k+1)}}" id="{{$k}}" name="score" {{$value == ($k+1) ? 'checked' : ''}}/>
                        <label for="{{$k}}" class="pointer">{{$option['title']}}</label>
                        <div class="col-xs-12 padding-right-20">
                            {{$option['desc']}}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </form>
</div>

