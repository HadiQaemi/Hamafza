<form id="ad_social_form">
    <input id="edit_form_ad_id" type="hidden" name="item_id" value="@if($basicdata_value){{ $basicdata_value->id}}@endif">
    <div class="container-fluid">
        <div class="row" style="margin-top: 5px;">
            <div class="col-sm-6">
                <label>دسته:</label>
                <select class="form-control" name="group_id">
                    @foreach($basicdata_value_tabs as $tab)
                        <option value="{{$tab->id}}">{{$tab->title}}</option>
                    @endforeach
                </select>
            </div>
            </select>
            <div class="col-sm-6">
                <label>عنوان:</label>
                <input value="@if($basicdata_value){{$basicdata_value->title}} @endif" type="text" id="title"
                       name="title" class="form-control"/>
            </div>
            <div class="col-sm-6" style="margin-top: 10px;">
                <label>آدرس لینک:</label>
                <input value="@if(!$add_true){{$link}}@endif" type="text" id="url_address" name="url_address"
                       class="form-control" style="direction: ltr;"/>
            </div>
        </div>

            <div class="col-sm-8">
                <div  id="div_base_imagemanager" style="@if(!$add_true) display:none; @endif">
                    <label>تصویر اسلایدر:</label>

                </div>
            </div>
            <div id="old_right_logo" class="col-sm-4">
                <div style="height: 120px; width: 180px; text-align: center;">
                    @if(!$add_true)
                        <div id="div_bas_image">
                            <div>
                                <img width="170" height="110" id="picture_item"
                                     src="{{route('FileManager.DownloadFile',['type'=>'ID','id'=>$image_encode_id])}}"/>
                            </div>
                            <div class="margin-top-10">
                                <button type="button" class="btn btn-warning btn-xs" id="btn_edit_pic_social">ویرایش
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>


            <div class="col-sm-12" style="margin-top: 20px;">
                <label>توضیحات:</label>
                <textarea id="comment" name="comment" class="form-control">
                    @if($basicdata_value){{ $basicdata_value->comment }} @endif
                </textarea>
            </div>

        <div class="col-sm-12" style="margin-top: 5px;">
            <label>وضعیت:</label>
            <input type="radio" id="inactive_social_0" checked name="inactive" value="0"/>
            <label>فعال</label>
            <input type="radio" id="inactive_social_1" name="inactive" value="1"/>
            <label>غیرفعال</label>
        </div>
    </div>
    <input type="hidden" id="parentid" name="parent"
           value="@if($basicdata_value){{$basicdata_value->parent_id}}@else{{$basicdata_id}}@endif"/>
</form>
@if($add_true)
    {!! $HFMAddItemImage['UploadForm'] !!}
    {!! $HFMAddItemImage['JavaScripts'] !!}
@else
    {!! $HFMEditItemImage['UploadForm'] !!}
    {!! $HFMEditItemImage['JavaScripts'] !!}
@endif
<script>
    $(document).ready(function () {
        $("#btn_edit_pic_social").click(function () {
            $("#div_bas_image").hide();
            $("#div_base_imagemanager").show();

        });
    });
</script>