{{--{{ dd($basic_data_value->attrs()->withPivot('value')->get()->toArray()) }}--}}
{{--{{ dd($basic_data_value->attrs()->where('basicdata_attribute_id', 5)->withPivot('value')->first()->pivot->value) }}--}}
{{--{{ dd($basic_data_value->toArray()) }}--}}

<form id="ad_setting_form">
    <input id="edit_form_ad_id" type="hidden" name="item_id" value="{{ $basic_data_value ? $basic_data_value->id : '' }}">
    <div style="padding: 10px;">
        <div class="row" style="margin-top: 5px;">
            <div class="col-sm-6"><label>انتخاب زبانه پژوهش:</label><select id="research_tab" name="research_tab"></select></div>
        </div>
        <div class="row" style="margin-top: 5px;">
            <div class="col-sm-6">
                <label>عنوان:</label>
                <input type="text" id="title" name="title" class="form-control" value="{{ $basic_data_value ? $basic_data_value->title : '' }}"/></div>
            <div class="col-sm-6">
                <label>آدرس لینک:</label>

                @if(count($basic_data_value) != 0)
                    @if(count($basic_data_value->attrs) != 0)
                        <input type="text" id="url_address" name="url_address" class="form-control" style="direction: ltr;"
                               value="{{ $basic_data_value ? $basic_data_value->attrs()->where('basicdata_attribute_id', 12)->withPivot('value')->first()->pivot->value : '' }}"/>
                    @else
                        <input type="text" id="url_address" name="url_address" class="form-control" style="direction: ltr;" value=""/>
                    @endif
                @else
                    <input type="text" id="url_address" name="url_address" class="form-control" style="direction: ltr;" value=""/>
                @endif
            </div>
        </div>

        <div class="row" style="margin-top: 5px;">
            <div class="col-sm-8 add_image">
                <label>تصویر اسلایدر:</label>
                <div id="new_header_image" class="form-group">
                    <div>
                        <span class="help-block">{{trans('app.valid_mime_type')}}: gif, png, jpg. |
                            <span>{{trans('app.valid_max_file_size')}}: 2mb</span>
                        </span>
                        <code style="font-size: 12px;">بهترین ابعاد تصویر: 191*158 پیکسل</code>
                    </div>
                    <div class="col-sm-8">
                        {!! $HFMAddSliderImage['Buttons']['research_image'] !!}
                        {!! $HFMAddSliderImage['ShowResultArea']['research_image'] !!}
                    </div>
                </div>
            </div>

            <div id="old_right_logo" class="col-sm-4">
                <div style="height: 120px; width: 180px; text-align: center;">
                    @if(count($basic_data_value) != 0)
                        @if(count($basic_data_value->attrs) != 0)
                            <img style="height: 120px; width: 180px;"
                                 src="{{route('FileManager.DownloadFile',['ID', $basic_data_value? enCode($basic_data_value->attrs()->where('basicdata_attribute_id', 13)->withPivot('value')->first()->pivot->value) : -1 ]) }}" alt="">
                            @if(isset($basic_data_value))
                                <a href="#" title="ویرایش تصویر">
                                    <i style="font-size: 20px; position: absolute;top: 0px;left: 40px;" class="fa fa-edit edit_image"></i>
                                </a>
                            @endif
                        @endif
                    @endif
                </div>
            </div>
        </div>
        <div class="row" style="margin-top: 5px;">
            <div class="col-sm-12"><label>توضیحات:</label> <textarea id="comment" name="comment" class="form-control">{{ $basic_data_value ? $basic_data_value->comment : '' }}</textarea></div>
        </div>
        <div class="row" style="margin-top: 5px;">
            <label>وضعیت:</label>
            <input type="radio" id="inactive_0" name="inactive" value="0"/>
            <label>فعال</label>
            <input type="radio" id="inactive_1" name="inactive" value="1"/>
            <label>غیرفعال</label>
        </div>
    </div>
</form>
<input type="hidden" id="parentid" name="parentid" value="  parentid  "/>
{!! $HFMAddSliderImage['UploadForm'] !!}
{!! $HFMAddSliderImage['JavaScripts'] !!}
<script>

    $(document).ready(function () {
        @if($basic_data_value)
        if ({{ $basic_data_value->inactive }}) {
            $('#inactive_1').click();
        }
        else {
            $('#inactive_0').click();
        }
        @else
        $('#inactive_0').click();
        @endif

          $.ajax({
            type: 'post',
            dataType: "json",
            url: "{{route('hamafza.add_item_research_select_2')}}",
            success: function (data) {
                var data = data;
                //console.log(data);
                $("#research_tab").select2({
                    dir: "rtl",
                    width: "100%",
                    language: "fa",
                    data: data
                });
            },
        });
        @if(count($basic_data_value) != 0)
             @if(count($basic_data_value->attrs) != 0)
                $('.add_image').hide();
                $(document).on('click', '.edit_image', function () {
                    $('.add_image').show();
                    $('.edit_image').hide();
                });
            @endif
        @endif
    });


</script>