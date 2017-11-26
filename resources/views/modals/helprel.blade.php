
<div class="guran-sooreh-list">
    <div class="navbar navbar-default">
       
        <ul class="nav nav-tabs">
            <li class="active"><a aria-controls="sooreh-tab-1" href="#sooreh-tab-1" role="tab" data-toggle="tab">روابط</a></li>
            <li><a aria-controls="sooreh-tab-2" href="#sooreh-tab-2" role="tab" data-toggle="tab">متن</a></li>

        </ul>
    </div>
    <div class="tab-content">
        <div id="sooreh-tab-1" role="tabpanel" class="tab-pane active">
            <div style="margin-right: 25px;">
                <form action="{{ route('hamafza.help_save')}}" method="post" name="form" id="form">
            روابط موجود:
            <br>
            <input type="hidden" name="orig" value="{{$orig}}">
                        <input type="hidden" name="pid" value="{{$pid}}">

                        <div style="width: 80%;display: inline-block;margin-right: 25px;">
                            <input type="text" id="HelpRel" name="HelpRel"  />
                            <br>
                            <input type="submit" value="تایید" title="Searchpost" class="btn btn-primary FloatLeft" id="HelpRelBut" style="padding:6px;">

                        </div>



            </form>
            </div>
        </div>
        <div id="sooreh-tab-2" role="tabpanel" class="tab-pane">
            <div id="HelpContent" style="top: 10px;margin-left: 2px;margin-right: 10px;width:98%;line-height: 16pt;" class="panel-body text-decoration"> 
              {!!$body!!}
            </div>
        </div>

    </div>

</div>

<script type="text/javascript">
    $(document).ready(function() {
        $("#HelpRel").tokenInput("{{App::make('url')->to('/')}}/Helpsearch", {
            preventDuplicates: true,
            hintText: "عبارتی را وارد کنید",
            noResultsText: "نتیجه‌ای یافت نشد، با زدن دکمه اینتر کلیدواژه جدیدی ایجاد می‌شود",
            searchingText: "در حال جستجو",
            onAdd: function(item) {
                //add the new label into the database
                if (parseInt(item.id) == 0) {
                    name = $("tester").text();
                    if (name != null) {
                        $.ajax({
                            type: "POST",
                            url: "tagmergeaction.php",
                            dataType: 'html',
                            data: ({New: 'OK', Name: name}),
                            success: function(theResponse) {
                                if (theResponse != 'NOK')
                                    alert('بر چسب جدید با موفقیت تعریف شد');
                                $("#input-plugin-methods").tokenInput("remove", {name: name});
                                $("#input-plugin-methods").tokenInput("add", {id: theResponse, name: name});
                            }
                        });
                    }
                }
            },
            onResult: function(item) {
                if ($.isEmptyObject(item)) {

                    return [{id: '0', name: $("tester").text()}]
                } else {
                    return item
                }

            },
        });
        @if(is_array($Rel) && count($Rel)>0)
            @foreach($Rel as $item)
         id="{{$item->RID}}";
                 Tname="{{$item->Tname}}";

            $("#HelpRel").tokenInput("add", {id: id, name: Tname});

        @endforeach
            @endif
    });</script>
