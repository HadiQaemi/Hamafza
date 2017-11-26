<form action="{{ route('hamafza.edit_process') }}" method="post" name="form" id="form">
    @if(is_array($proc) && count($proc)>0)
    @foreach($proc as $item)
    <?php $title=$item->process_name;
    $id=$item->pid;
    ?>
    @endforeach
    @endif
    <table id="Rowd" width="100%" class="table">
        <tbody>
            <tr>
                <td style="width:90px">عنوان فرآیند  </td> 
                <td>
                    <input name="process_id" type="hidden"  value="{{$id}}"/>
                    <input name="process_name" type="text" class="form-control inputbox " id="process_name" dir="rtl" value="{{$title}}" style="width:100%;; margin:0px" />
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
    <?php $i = 1; ?>
    @if (is_array($proc))
    @foreach($proc as $item)
    <div style="border-top: 1px solid #cccccc;">
        <table  width="100%" class="ProcTable" >
            <tr>
                
                <td>
                    <table id="sortable2" class="ProcTable table table-default table-bordered table-striped table-hover">
                        <tbody>
                            <tr>
                                <th width="100%">فعالیت<span class="counter"> {{$i}}</span>
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
                                <input type="text" style="width:255px;display: inline;" class="form-control inputbox  required" value="{{$item->phase_name}}" dir="rtl" name="phase_name[{{$i}}]">
                            </td>
                            <td>
                                پیشرفت

                            </td>
                            <td>

                                <input type="text" style="width:25px; text-align:left;display: inline;" value="{{$item->score}}" class="form-control inputbox " name="phase_score[{{$i}}]">



                                نمایش عمومی
                                @if($item->view=='1')
                                <input type="checkbox" checked="true" name="view[{{$i}}]">
                                @else
                                <input type="checkbox"  name="view[{{$i}}]">
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td  style="widows: 10%;">
                                مسئول اقدام

                            </td>
                            <td  style="widows: 40%;">
                                <select style="display: inline;width: 70%" dir="rtl" class="phase_manager1 form-control" name="phase_manager1[{{$i}}]">
                                    <option value="0" @if($item->manager1=='0') selected @endif> فرد ثابت - {{$item->Name}} {{$item->Family}} </option>
                                    <option value="1" @if($item->manager1=='1') selected @endif>عامل یک</option>
                                    <option value="2" @if($item->manager1=='2') selected @endif>عامل دو</option>
                                    <option value="3" @if($item->manager1=='3') selected @endif>عامل سه</option>
                                    <option value="4" @if($item->manager1=='4') selected @endif>عامل چهار</option>
                                </select>
                                <div style="height: 10px; display: inline-block;">
                                    <a class="jsPanels" title="انتخاب کاربران" href="{{App::make('url')->to('/')}}/modals/seluser?type=multi&opener=phase_manager_{{$i}}">
                                        <span  class="icon icon-se-fard fonts"></span>
                                    </a>
                                    <input type="hidden" id="phase_manager_{{$i}}" uids="{{$item->id}}" name="phase_manager[{{$i}}]" value="0" >
                                </div>
                            </td>
                            <td  style="widows: 10%;">
                                فرم اقدام
                            </td>
                            <td  style="widows: 40%;">
                                <select style="display: inline;width: 80%" dir="rtl" class="text2 form-control" name="formid[{{$i}}]">
                                    <option value="0" >انتخاب کنید</option>
                                    @if(is_array($forms))
                                    @foreach($forms as $items)
                                    @if($item->form==$items->id)
                                    <option value = "{{$items->id}}" selected>{{$items->title}}</option>
                                    @else
                                    <option value = "{{$items->id}}" >{{$items->title}}</option>
                                    @endif
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

                                <select style="display: inline;width: 75%" dir="rtl" class="text2 form-control" name="pformid[{{$i}}]">
                                    <option value="0" >انتخاب کنید</option>
                                    @if(is_array($Porsesh))
                                    @foreach($Porsesh as $items)
                                    @if($item->pform==$items->id)
                                    <option value = "{{$items->id}}" selected>{{$items->title}}</option>
                                    @else
                                    <option value = "{{$items->id}}" >{{$items->title}}</option>
                                    @endif
                                    @endforeach
                                    @endif
                                </select>
                                <input type="hidden" name="users[{{$i}}]" value="0" class="users[{{$i}}]">
                                <div style="height: 10px; display: none;;" >
                                    <a class="jsPanels" title="انتخاب کاربران" href="{{App::make('url')->to('/')}}/modals/seluser?type=single&opener=persons_{{$i}}">
                                        <span  class="icon icon-se-fard fonts"></span>
                                    </a>
                                    <input type="hidden" id="persons_{{$i}}" uids="" name="persons[{{$i}}]" value="0" >
                                </div>

                            </td>
                            <td style="widows: 10%;">
                                اطلاعیه
                            </td>
                            <td>
                                <select style="display: inline;width: 80%" dir="rtl" class="text2 form-control" name="alert[{{$i}}]">
                                    <option value="0" >انتخاب کنید</option>
                                    @if(is_array($alerts))
                                    @foreach($alerts as $items)
                                    @if($item->alert==$items->id)
                                    <option selected value = "{{$items->id}}" >{{$items->name}}</option>
                                    @else
                                    <option value = "{{$items->id}}" >{{$items->name}}</option>
                                    @endif
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
    <?php $i++; ?>
    @endforeach
    @endif
    <div id="Row1">
        <table  width="100%" class="ProcTable" >
            <tr>
                <td>
                    <table id="sortable2" class="ProcTable table table-default table-bordered table-striped table-hover">
                        <tbody>
                            <tr>
                                <th width="100%">فعالیت<span class="counter"> {{$i}}</span>
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
                                <input type="text" style="width:255px;display: inline;" class="form-control inputbox  required" value="" dir="rtl" name="phase_name[{{$i}}]">
                            </td>
                            <td>
                                پیشرفت

                            </td>
                            <td>

                                <input type="text" style="width:25px; text-align:left;display: inline;" value="" class="form-control inputbox " name="phase_score[{{$i}}]">



                                نمایش عمومی
                                <input type="checkbox" checked="" name="view[{{$i}}]">
                            </td>
                        </tr>
                        <tr>
                            <td  style="widows: 10%;">
                                مسئول اقدام

                            </td>
                            <td  style="widows: 40%;">
                                <select style="display: inline;width: 70%" dir="rtl" class="phase_manager1 form-control" name="phase_manager1[{{$i}}]">
                                    <option value="0">فرد ثابت</option>
                                    <option value="1">عامل یک</option>
                                    <option value="2">عامل دو</option>
                                    <option value="3">عامل سه</option>
                                    <option value="4">عامل چهار</option>
                                </select>
                                <div style="height: 10px; display: inline-block;">
                                    <a class="jsPanels" title="انتخاب کاربران" href="{{App::make('url')->to('/')}}/modals/seluser?type=multi&opener=phase_manager_{{$i}}">
                                        <span  class="icon icon-se-fard fonts"></span>
                                    </a>
                                    <input type="hidden" id="phase_manager_{{$i}}" uids="" name="phase_manager[{{$i}}]" value="0" >
                                </div>
                            </td>
                            <td  style="widows: 10%;">
                                فرم اقدام
                            </td>
                            <td  style="widows: 40%;">
                                <select style="display: inline;width: 80%" dir="rtl" class="text2 form-control" name="formid[{{$i}}]">
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

                                <select style="display: inline;width: 75%" dir="rtl" class="text2 form-control" name="pformid[{{$i}}]">
                                    <option value="0" >انتخاب کنید</option>
                                    @if(is_array($Porsesh))
                                    @foreach($Porsesh as $item)
                                    <option value = "{{$item->id}}">{{$item->title}}</option>
                                    @endforeach
                                    @endif
                                </select>
                                <input type="hidden" name="users[{{$i}}]" value="0" class="users[{{$i}}]">
                                <div style="height: 10px; display: none;;" >
                                    <a class="jsPanels" title="انتخاب کاربران" href="{{App::make('url')->to('/')}}/modals/seluser?type=single&opener=persons_{{$i}}">
                                        <span  class="icon icon-se-fard fonts"></span>
                                    </a>
                                    <input type="hidden" id="persons_{{$i}}" uids="" name="persons[{{$i}}]" value="0" >
                                </div>

                            </td>
                            <td style="widows: 10%;">
                                اطلاعیه
                            </td>
                            <td>

                                <select style="display: inline;width: 80%" dir="rtl" class="text2 form-control" name="alert[{{$i}}]">
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
        </t>
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
            // con = con.replace('[{{$i}}]', '-> + counter + ');
            con = con.replace(/[[{{$i}}]]/g, '' + counter + ');
            con = con.replace(/_{{$i}}/g, '_' + counter);
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