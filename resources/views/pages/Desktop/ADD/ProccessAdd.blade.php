<form action="{{ route('hamafza.reg_process') }}" method="post" name="form" id="form">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <table id="Rowd" width="100%" class="table">
        <tbody>
            <tr>
                <td style="width:90px">عنوان فرآیند </td> 
                <td>
                    <input name="process_name" type="text" class="form-control inputbox " id="process_name" dir="rtl" value="" style="width:100%;; margin:0px" />
                    <span style="color:#FF0000" dir="rtl"></span>
                </td>
            </tr>
            <tr>
                <td>
                    توضیح
                </td>
                <td>
                    <textarea name="process_comment" class="form-control" style="width:100%; margin:0px" rows="2" id="process_comment" dir="rtl"></textarea>
                </td>
            </tr>
        </tbody>
    </table>
    <div id="Row1">
        <table  width="100%" class="ProcTable" >
            <tr>
                <td style="vertical-align: middle;font-weight: bold;">

                    <table id="sortable2" class="ProcTable table table-default table-bordered table-striped table-hover">
                        <tbody>
                            <tr>

                                <th width="100%">فعالیت<span class="counter"> 1</span>
                        <div style="position: relative;;height: 10px;" class="FloatLeft " onclick="removeRow(this)">
                            <span style="height: 10px;" class="FloatLeft icon  icon icon-hazv" ></span>
                        </div>

                        </th>

            </tr>

            <tr>

                <td>
                    <table style="width: 100%" class="tblBorderLess">
                        <tr>
                            <td>
                                نام فعالیت
                            </td>
                            <td>
                                <input type="text" style="width:255px;display: inline;" class="form-control inputbox  required" value="" dir="rtl" name="phase_name[1]">
                            </td>
                            <td>
                                پیشرفت

                            </td>
                            <td>

                                <input type="text" style="width:25px; text-align:left;display: inline;" value="" class="form-control inputbox " name="phase_score[1]">

                                <input type="checkbox" checked="" name="view[1]">
                                                                نمایش عمومی

                            </td>
                        </tr>
                        <tr>
                            <td  style="widows: 10%;">
                                مسئول اقدام

                            </td>
                            <td  style="widows: 40%;">
                                <select style="display: inline;width: 70%" dir="rtl" class="phase_manager1 form-control" name="phase_manager1[1]">
                                    <option value="0">فرد ثابت</option>
                                    <option value="1">عامل یک</option>
                                    <option value="2">عامل دو</option>
                                    <option value="3">عامل سه</option>
                                    <option value="4">عامل چهار</option>
                                </select>
                                <div style="height: 10px; display: inline-block;">
                                    <a href="{{App::make('url')->to('/')}}/modals/seluser?type=multi&amp;opener=phase_manager_1" title="انتخاب کاربران" class="jsPanels">
                                        <span class="icon icon-se-fard fonts"></span>
                                    </a>
                                    <input type="hidden" value="0" name="phase_manager[1]" uids="" id="phase_manager_1">
                                </div>
                            </td>
                            <td  style="widows: 10%;">
                                فرم اقدام
                            </td>
                            <td  style="widows: 40%;">
                                <select style="display: inline;width: 80%" dir="rtl" class="text2 form-control" name="formid[1]">
                                    <option value="0" >انتخاب کنید</option>
                                    @if(is_array($forms))
                                    @foreach($forms as $item)
                                    <option value = "{{$item->id}}">{{$item->title}}</option>
                                    @endforeach

                                    @endif
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td  style="widows: 10%;">
                                فرم پرسشنامه
                            </td>
                            <td>
                                <select style="display: inline;width: 75%" dir="rtl" class="text2 form-control" name="pformid[1]">
                                    <option value="0" >انتخاب کنید</option>
                                    @if(is_array($Porsesh))
                                    @foreach($Porsesh as $item)
                                    <option value = "{{$item->id}}">{{$item->title}}</option>
                                    @endforeach
                                    @endif
                                </select>
                                <input type="hidden" name="users[1]" value="0" class="users[1]">
                                <div style="height: 10px; display: none;;" >
                                    <a class="jsPanels" title="انتخاب کاربران" href="{{App::make('url')->to('/')}}/modals/seluser?type=single&opener=persons_1">
                                        <span  class="icon icon-se-fard fonts"></span>
                                    </a>
                                    <input type="hidden" id="persons_1" uids="" name="persons[1]" value="0" >
                                </div>
                            </td>
                            <td style="widows: 10%;">
                                اطلاعیه
                            </td>
                            <td>
                                <select style="display: inline;width: 80%" dir="rtl" class="text2 form-control" name="alert[1]">
                                    <option value="0" >انتخاب کنید</option>
                                    @if(is_array($alerts))
                                    @foreach($alerts as $item)
                                    <option value = "{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr> 
            </tbody>
        </table>
        </td>
        </tr>
        </table>
    </div>
    <div id="Rows">
    </div>
    <div style="float: right;cursor: pointer;">
        <span id="Add" class="icon icon-plus-square ">   افزودن</span>
    </div>
    <button name="addasubject" class="btn btn-primary FloatLeft" type="submit">تایید</button>
    <script>
        var i = 1;
        $("#Add").click(function() {
            counter = $(".counter:last").html();
            counter = counter * 1 + 1;
            con = $("#Row1").html();
            // con = con.replace('[1]', '[' + counter + ']');
            con = con.replace(/[[1]]/g, '' + counter + ']');
            con = con.replace(/_1/g, '_' + counter);
            $("#Rows").append(con);
            $("#Rows").find(".counter:last").html(counter);
        });

   function removeRow(e) {
            counter = $(".counter:last").html();
            if (counter > 1)
                $(e).closest('.ProcTable').remove();

        }
        
      
    </script>
</form>