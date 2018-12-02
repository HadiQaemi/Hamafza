@extends('master')
@section('content')

<script>
    uids = {{$uids}};
            provdata = {{$Ostan}}
    ;</script>
<script type="text/javascript" src="{{App::make('url')->to('/')}}/theme/Scripts/snetwork.js"></script>

@if ($uids == $uid)
<script type="text/javascript" src="{{App::make('url')->to('/')}}/theme/Scripts/user_edit.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="{{App::make('url')->to('/')}}/theme/jsclender/skins/aqua/theme.css" title="Aqua" />
<script type="text/javascript" src="{{App::make('url')->to('/')}}/theme/jsclender/jalali.js"></script>


<!-- import the calendar script -->
<script type="text/javascript" src="{{App::make('url')->to('/')}}/theme/jsclender/calendar.js"></script>
<!-- import the calendar script -->
<script type="text/javascript" src="{{App::make('url')->to('/')}}/theme/jsclender/calendar-setup.js"></script>
<!-- import the language module -->
<script type="text/javascript" src="{{App::make('url')->to('/')}}/theme/jsclender/lang/calendar-fa.js"></script>
@endif
@include('sections.contextmenu')
<div class="panel-body text-decoration" style="direction:rtl">
    <div class='text-content'>
        @if( $Alert!='')
        <div class="gkCode10" style="  margin: 10px;">
            {{$Alert}}
        </div>
        @endif
        <div class="gkCode10" style="  margin: 10px;">
            @if ($uids == $uid)

            <span  style=" height: 10px;margin-left: -15px;padding: 0;" class="icon-pencil-1 iconEdit  EditUDetails FloatLeft"></span>

            @endif
            <?php
            $pics = 'pics/user/Users.png';
            if (trim($preview['Pic']) != '' && file_exists('pics/user/'  . $preview['Pic']))
                $pics = 'pics/user/' . $preview['Pic'];
            ?>

            <div style="max-width:170px; display:inline-block; vertical-align:top" ><img src="{{ $pics}} " style="width:100px; height: 100px; margin:0 10px;float:right;border-radius: 50%; border: 1px solid #CCCCCC;background: #FFF;padding: 2px; "  /></div>
            <div style="max-width:760px; display:inline-block; vertical-align:top">
                <h1>{{ $preview['Name'] }}  {{ $preview['Family']}} </h1>
                                                @if( $preview['Summary']!='')

                {{ $preview['Summary'] }}<br>
                                                @endif

                                @if( $preview['Comment']!='')

                {{ $preview['Comment'] }}<br>
                                @endif
 @if( $preview['Shahr']!='')
                 شهر:{{ $preview['Shahr'] }}  <br>

                @endif
                @if( $preview['Website']!='')
                آدرس وب سایت: <a target="_blank" href="http://{{ $preview['Website'] }}">{{ $preview['Website'] }} </a><br>
                @endif
                @if( $preview['Email']!='')
                رایانامه:<a href="mailto:{{ $preview['Email'] }}">{{ $preview['Email'] }} </a><br>
                @endif
                @if( $preview['Tel_number']!='')
                تلفن:{{ $preview['Tel_number'] }}-{{ $preview['Tel_code'] }}  <br>
                @endif
                  @if( $preview['Mobile']!='')
                تلفن همراه: {{ $preview['Mobile'] }}
                @endif
            </div>
        </div>
        @if ($uids == $uid)

        <div id="EditUDetail" class="editDiv gkCode10">
            <table class="table-striped">
                <tbody>

                    <tr>
                        <td><span style="color:red">*</span>نام</td>
                        <td>
                            <input type="text"  id="user_name" class="form-control required" value="{{ $preview['Name'] }} " >
                        </td>

                    </tr>
                    <tr>
                        <td><span style="color:red">*</span>نام خانوادگی</td>
                        <td>
                            <input type="text"  id="user_family" class="form-control required" value="{{ $preview['Family']}}" name="user_family"></td>
                    </tr>
                    <tr>

                        <td>معرفی اجمالی</td>
                        <td><input type="text" id="user_summary" class="text form-control" value="{{ $preview['Summary'] }}" placeholder="چند واژه برای معرفی شما (مانند عناوینی که در کارت ملاقات ذکر می شود)" name="user_summary"></td>
                    </tr>

                    <tr>

                        <td>دیدگاه ها و ایده های اصلی</td>
                        <td colspan="1">
                            <textarea class="form-control"  rows="5" name="comment" id="comment" placeholder="دیدگاه ها و ایده های اصلی">{{ $preview['Comment'] }}</textarea></td>
                    </tr>

                    <tr>
                        <td>جنسیت</td>
                        <td>
                            <label style="display:inline"><input  class="gender" type="radio" @if($preview['Gender']=='مرد') checked="" @endif value="0" name="user_gender">مرد</label>
                            <label style="display:inline"><input  class="gender"type="radio" @if($preview['Gender']=='زن') checked="" @endif value="1" name="user_gender">زن</label>
                            <label style="display:inline"><input  class="gender" type="radio" @if($preview['Gender']=='نامشخص') checked="" @endif value="2" name="user_gender">نامشخص</label>

                        </td>
                    </tr>
                    <tr>
                        <td>تاریخ تولد</td>
                        <td>
                            <input id="EditUdet" class="form-control" type="text" value=""/>
                            <script type="text/javascript">
            Calendar.setup({
            inputField: "EditUdet", // id of the input field
                    button: "EditUdet", // trigger for the calendar (button ID)
                    ifFormat: "%Y/%m/%d", // format of the input field
                    dateType: 'jalali',
                    weekNumbers: false
            });</script>
                        </td>
                    </tr>
                    <tr>         
                        <td>محل تولد</td>
                        <td>
                            استان
                            <select id="ProvinceUdet" class='Province form-control'>
                            </select>
                            شهر
                            <select id="CityUdet" class='City form-control'>
                                <option value="0">انتخاب کنید</option>
                            </select> 
                        </td>
                    </tr>
                    <tr>
                        <td>تلفن همراه</td>
                        <td><input type="text"  id="user_mobile" class="form-control" value="{{ $preview['Mobile'] }}" name="user_mobile"></td>
                    </tr>
                    <tr>
                        <td>تلفن ثابت</td>
                        <td style="text-align: right;">
                            <input  style="width: 120px" type="text" value="{{ $preview['Tel_code'] }}" id="tel_code" size="4" maxlength="4">
                            <input style="width: 250px" type="text" value="{{ $preview['Tel_number'] }}" id="tel_number" size="34" maxlength="10">
                        </td>
                    </tr>
                    <tr>
                        <td> فاکس</td>
                        <td style="text-align: right;">
                            <input style="width: 100px" type="text" value="{{ $preview['Fax_code'] }}" id="fax_code" size="4" maxlength="4">
                            <input  style="width: 200px" type="text" value="{{ $preview['Fax_number'] }}" id="fax_number" size="34" maxlength="10"></td>

                    </tr>
                    <tr>
                        <td>وب سایت</td>
                        <td>
                            <input type="text"  id="user_website" class="form-control" value="{{ $preview['Website'] }}" name="user_website">
                        </td>
                    </tr>
                    <tr>
                        <td><span style="color:red">*</span>رایانامه</td>
                        <td><input type="text"  id="user_mail" class="form-control" value="{{ $preview['Email'] }}" name="user_mail"></td>
                    </tr>


                    <tr>
                        <td>
                        </td>

                        <td>
                            <span class="FloatLeft">
                                <input type="button" value="تایید" editid="0" class="btn btn-primary EditUDetail">
                                <input type="button" value="لغو" class="btn  btn-default  closeBut">
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        @endif
        <div class="total">
            <h1 class="heading" id="{{$user_special[0]}}">
                <span class="icon icon-open"></span>
                <a id="specials">
                    {{$user_special[0]}}
                </a>
                @if ($uids == $uid)
                <div class="icon IconHeight" style="cursor: pointer;display: inline-block;padding-right: 20px;vertical-align: bottom;" ><span class="icon-hazv icon-plus EditUP" targetid="0" val="EditUP_0"></span></div>
                @endif
            </h1>
            <div class="inner">
                
                <table style="width:100%">
                    @if ($uids == $uid)
                    <tr>
                        <td colspan="2">
                            <div id="EditUP_0" class="editDiv">
                                <table class="table-striped">
                                    <tr>
                                        <td>عنوان</td>
                                        <td>
                                            <input  type="text" value="" class="required form-control"  id="EditUP_title_0" >
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>توضیح</td>
                                        <td><textarea class="form-control"  id="EditUP_comment_0" name="comment" id="EditUP_comment_0"></textarea></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>
                                            <span class="FloatLeft">
                                                <input type="button" class="btn btn-primary EditUPOK" editid="0" value="تایید">
                                                <input type="button" class="btn  btn-default  closeBut" value="لغو">
                                            </span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>
                    @endif
                    
                            @if(is_array($user_special) && count($user_special[1])>0)

                    <?php $i = 1; ?>
                    @foreach($user_special[1] as $item)
                    <tr>
                        <td>
                            <label style="display:inline-block;padding:0;width:100%;">{{$i}}- {{ $item['name']  }}
                                @if ($uids == $uid)

                                <div class="icon IconHeight" ><span class="icon-hazv  iconEdit iconEditUP" val="{{ $item['id'] }}"></span>
                                    <span  class="icon-pencil-1 iconEdit  EditUP" val="EditUP_{{$item['id'] }}" targetid="{{$item['id'] }}"></span></div>
                                @endif
                                @if ($uid !='' && $uid !=$uids  && $item['endorsed'] == '0')
                                <span id="do_{{$item['id']}}" class="Endorse btnActive  "  title="صحه‌گذاری" data-placement="top" data-toggle="tooltip"  Type='EndorseDo' spid="{{$item['id']}}"><a rel="nofollow" href="#"  action="Endorse" id="Endorse_{{$item['id']}}" tid="{{$item['id']}}" val="0" class="stooltip title-button1 status" page="user" original-title="صحه گذاری" style="float: initial;"><img src="{{App::make('url')->to('/')}}/theme/Content/images/End1.png" style="display: inherit !important;"/></a></span>
                                <span style="display: none;" id="Undo_{{$item['id']}}"  class="Endorse btnActive "  title="حذف صحه‌گذاری" data-placement="top" data-toggle="tooltip"  Type='EndorseUnDo' spid="{{$item['id']}}" ><a rel="nofollow" href="#"  action="Endorse" id="Endorse_{{$item['id']}}" tid="{{$item['id']}}" val="1" class="stooltip title-button1 status" page="user" original-title="حذف صحه گذاری " style="float: initial;"><img src="{{App::make('url')->to('/')}}/theme/Content/images/End.png" style="display: inherit !important;"/></a></span>
                                @elseif ($uid!='0' && $uid !=$uids && $item['endorsed'] == '1')
                                <span id="Undo_{{$item['id']}}" class="Endorse btnActive "  title="حذف صحه‌گذاری" data-placement="top" data-toggle="tooltip"  Type='EndorseUnDo' spid="{{$item['id']}}" ><a rel="nofollow" href="#"  action="Endorse" id="Endorse_{{$item['id']}}" tid="{{$item['id']}}" val="1" class="stooltip title-button1 status" page="user" original-title="حذف صحه گذاری " style="float: initial;"><img src="{{App::make('url')->to('/')}}/theme/Content/images/End.png" style="display: inherit !important;"/></a></span>
                                <span style="display: none;" id="do_{{$item['id']}}" class="Endorse btnActive  "  title="صحه‌گذاری" data-placement="top" data-toggle="tooltip"  Type='EndorseDo' spid="{{$item['id']}}"><a rel="nofollow" href="#"  action="Endorse" id="Endorse_{{$item['id']}}" tid="{{$item['id']}}" val="0" class="stooltip title-button1 status" page="user" original-title="صحه گذاری" style="float: initial;"><img src="{{App::make('url')->to('/')}}/theme/Content/images/End1.png" style="display: inherit !important;"/></a></span>
                                @endif   
                            </label>

                        </td>
                        <td>

                            @if(is_array($item['endorse']))
                            <?php $ex=1;?>
                            <div id="viewEnd_{{$item['id']}}">
                                <ul id="viewULEnd_{{$item['id']}}" style="display: flex;float: left;">
                                    @foreach($item['endorse'] as $itemX)
                                    <?php
                                    $pic = 'pics/user/Users.png';
                                    if (trim($itemX['Pic']) != '' && file_exists('pics/user/' . $itemX['Pic']))
                                        $pic = 'pics/user/'  . $itemX['Pic'];
                                    ?>
                                    <li id="USER_{{$item['id']}}_{{$itemX['id']}}" style="list-style: none;"><a class="stooltip title-button1 status " page="user" data-toggle="tooltip" data-placement="top" original-title=""  href="{{App::make('url')->to('/')}}/{{$itemX['Uname']}}" target="_blank"><img style="height: 30px;width: 30px;border-radius: 50%;" title="{{$itemX['Name']}} {{$itemX['Family']}}"  src="{{App::make('url')->to('/')}}/{{$pic}}"></a></li>
                                    
                                    <?php $ex++;
                                    
                                    if($ex>10)
                                        break;
                                    ?>
                                    @endforeach
                                </ul>  
                            </div>
                            @endif
                        </td>
                    <tr>
                        <td colspan="2">
                            {{$item['comment']}}
                        </td>
                    </tr>
                    @if ($uids == $uid)
                    <tr>
                        <td colspan="2">
                            <div id="EditUP_{{ $item['id'] }}" class="editDiv">
                                <table class="table-striped">
                                    <tr>
                                        <td>عنوان</td>
                                        <td>
                                            <input  type="text" value="{{ $item['name']  }}" class="required form-control"  id="EditUP_title_{{ $item['id']  }}" >
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>توضیح</td>
                                        <td><textarea class="form-control"  id="EditUP_comment_{{ $item['id']  }}" name="comment" id="EditUP_comment_{{ $item['id']  }}">{{ $item['comment']  }}</textarea></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>
                                            <span class="FloatLeft">
                                                <input type="button" class="btn btn-primary EditUPOK" editid="{{ $item['id']  }}" value="تایید">
                                                <input type="button" class="btn  btn-default  closeBut" value="لغو">
                                            </span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>
                    @endif
                    <?php $i++; ?>

                    @endforeach
                            @endif   

                </table>
            </div>
        </div>


        <!--user_work-->
        <div class="total">

            <h1 class="heading" id="{{$user_work[0]}}">
                <span class="icon icon-open"></span>
                <a id="specials" style="@if($uids != $uid && (!is_array($user_work) || count($user_work[1])==0)) display:none; @endif">
                    {{$user_work[0]}}
                </a>
                @if ($uids == $uid)
                <div class="icon IconHeight" style="cursor: pointer;display: inline-block;padding-right: 20px;vertical-align: bottom;" ><span class="icon-hazv icon-plus EditUW" targetid="0" val="EditUW_0"></span></div>
                @endif
            </h1>
            <div class="inner"><table style="width:100%">
                    @if ($uids == $uid)
                    <tr>
                        <td colspan="2">
                            <div id="EditUW_0" class="editDiv">
                                <table class="table-striped">
                                    <tr>
                                        <td>
                                            سمت <span style="color:red">*</span>
                                        </td>
                                        <td>
                                            <input value="" id="EditUW_title_0" class="form-control required" name="post" >
                                        </td>
                                        <td>
                                            کانال
                                            <span style="color:red">*</span>
                                        </td>
                                        <td>
                                            <input type="text" value="" class=" form-control required ui-autocomplete-input"
                                                   id="EditUW_company_0" >
                                        </td> 
                                    </tr>
                                    <tr>
                                        <td>
                                            واحد سازمانی
                                        </td>
                                        <td>
                                            <input value="" class="form-control required" name="EditUW_org_vahed_0" size="30">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            استان
                                        </td>
                                        <td>
                                            <select id="ProvinceUW_0" class='Province form-control'>
                                            </select>
                                        </td>
                                        <td>
                                            شهر
                                        </td>
                                        <td>
                                            <select id="CityUW_0" class='City form-control'>
                                                <option value="0">انتخاب کنید</option>
                                            </select> 
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>شروع</td>
                                        <td>
                                            <input id="EditUW_sdate_0" class="form-control" type="text" />
                                            <script type="text/javascript">
                                                        Calendar.setup({
                                                        inputField: "EditUW_sdate_0", // id of the input field
                                                                button: "EditUW_sdate_0", // trigger for the calendar (button ID)
                                                                ifFormat: "%Y/%m/%d", // format of the input field
                                                                dateType: 'jalali',
                                                                weekNumbers: false
                                                        });</script>
                                        </td>
                                        <td>پایان</td>
                                        <td>
                                            <input id="EditUW_edate_0" class="form-control" type="text" />
                                            <script type="text/javascript">
                                                        Calendar.setup({
                                                        inputField: "EditUW_edate_0", // id of the input field
                                                                button: "EditUW_edate_0", // trigger for the calendar (button ID)
                                                                ifFormat: "%Y/%m/%d", // format of the input field
                                                                dateType: 'jalali',
                                                                weekNumbers: false
                                                        });</script>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">توضیح
                                            <br>
                                            <textarea  class="form-control" cols="155" rows="3" name="comment" id="EditUW_comment_0" placeholder="ویژگیهای سازمان، ویژگیهای شغل و نقش شما در سازمان، کارهای برجسته ای که انجام داده اید و ..."></textarea>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="4">
                                            <span class="FloatLeft">
                                                <input type="button" class="btn btn-primary EditUWOK" editid="0" value="تایید">
                                                <input type="button" class="btn  btn-default  closeBut" value="لغو">
                                            </span>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>

                            </div>
                        </td>
                    </tr>
                    @endif
                    @if(is_array($user_work) && count($user_work[1])>0)
                    <?php $i = 1; ?>
                    @foreach($user_work[1] as $item)
                    <tr>
                        <td>
                            <label style="display:inline-block;padding:0;width:100%;">{{$i}}- {{ $item['post']  }}</label>{{$item['company']}} {{ $item['vahed'] }} ؛ {{$item['s_year'] }} - {{$item['e_year']}}  {{$item['province']}} {{$item['city']}}

                            @if ($uids == $uid)

                            <div class="icon IconHeight" ><span class="icon-hazv  iconEdit iconDelW" val="{{ $item['id'] }}"></span>
                                <span  class="icon-pencil-1 iconEdit  EditUW" val="EditUW_{{$item['id'] }}" targetid="{{$item['id'] }}"></span></div>
                            @endif

                            <br> {{$item['comment']}}

                        </td>

                    
                    
                    <tr>
                        <td>
                            {{$item['comment']}}
                        </td>
                    </tr>

                    @if ($uids == $uid)
                    <tr>
                        <td colspan="2">
                            <div id="EditUW_{{ $item['id'] }}" class="editDiv">
                                <table class="table-striped">
                                    <tr>
                                        <td>
                                            سمت <span style="color:red">*</span>
                                        </td>
                                        <td>
                                            <input value="{{$item['post']}}" id="EditUW_title_{{ $item['id'] }}" class="form-control required" name="post" >
                                        </td>
                                        <td>
                                            کانال
                                            <span style="color:red">*</span>
                                        </td>
                                        <td>
                                            <input type="text" value="{{$item['company']}}" class=" form-control required ui-autocomplete-input"
                                                   id="EditUW_company_{{ $item['id'] }}" >
                                        </td> 
                                    </tr>
                                    <tr>
                                        <td>
                                            واحد سازمانی
                                        </td>
                                        <td>
                                            <input value="{{ $item['vahed'] }}" class="form-control required" id="EditUW_org_vahed_{{ $item['id'] }}" size="30">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            استان
                                        </td>
                                        <td>
                                            <select id="ProvinceUW_{{ $item['id'] }}" class='Province form-control'>

                                            </select>
                                        </td>
                                        <td>
                                            شهر
                                        </td>
                                        <td>
                                            <select id="CityUW_{{ $item['id'] }}" class='City form-control'>
                                                <option value="0">انتخاب کنید</option>
                                            </select> 
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>شروع</td>
                                        <td>
                                            <input id="EditUW_sdate_{{ $item['id'] }}" class="form-control" type="text" value="{{$item['s_year'] }}" />
                                            <script type="text/javascript">
                                                        Calendar.setup({
                                                        inputField: "EditUW_sdate_{{ $item['id'] }}", // id of the input field
                                                                button: "EditUW_sdate_{{ $item['id'] }}", // trigger for the calendar (button ID)
                                                                ifFormat: "%Y/%m/%d", // format of the input field
                                                                dateType: 'jalali',
                                                                weekNumbers: false
                                                        });</script>
                                        </td>
                                        <td>پایان</td>
                                        <td>
                                            <input id="EditUW_edate_{{ $item['id'] }}" class="form-control" type="text" value="{{$item['e_year'] }}"/>
                                            <script type="text/javascript">
                                                        Calendar.setup({
                                                        inputField: "EditUW_edate_{{ $item['id'] }}", // id of the input field
                                                                button: "EditUW_edate_{{ $item['id'] }}", // trigger for the calendar (button ID)
                                                                ifFormat: "%Y/%m/%d", // format of the input field
                                                                dateType: 'jalali',
                                                                weekNumbers: false
                                                        });</script>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">توضیح
                                            <br>
                                            <textarea  class="form-control" cols="155" rows="3" name="comment" id="EditUW_comment_{{ $item['id'] }}" placeholder="ویژگیهای سازمان، ویژگیهای شغل و نقش شما در سازمان، کارهای برجسته ای که انجام داده اید و ..."> {{$item['comment']}}</textarea>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="4">
                                            <span class="FloatLeft">
                                                <input type="button" class="btn btn-primary EditUWOK" editid="{{ $item['id'] }}" value="تایید">
                                                <input type="button" class="btn  btn-default  closeBut" value="لغو">
                                            </span>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>

                            </div>
                        </td>
                    </tr>
                    @endif
                    <?php $i++; ?>

                    @endforeach
                                        @endif

                </table>
            </div>
        </div>



        <!--user_work-->

        <!--user_education-->
      
       <div class="total">
    <h1 class="heading" id="{{$user_education[0]}}">
        <span class="icon icon-open"></span>
        <a id="specials" style="@if($uids != $uid && (!is_array($user_education) || count($user_education[1])==0)) display:none; @endif">
            تحصیلات 
        </a>

        @if ($uids == $uid)
        <div class="icon IconHeight" style="cursor: pointer;display: inline-block;padding-right: 20px;vertical-align: bottom;" ><span class="icon-hazv icon-plus EditUE" targetid="0" val="EditUE_0"></span></div>
        @endif
    </h1>
    <div class="inner">

        <table style="width:100%">
            @if ($uids == $uid)
            <tr>
                <td colspan="2">
                    <div id="EditUE_0" class="editDiv">
                        <table class="table-striped">
                            <tr height="30">
                                <td>رشته تحصیلی <span style="color:red">*</span>
                                </td>
                                <td>
                                    <input value="" class='form-control' name="location_UE_0" size="30">
                                </td>
                                <td>
                                    گرایش
                                </td>
                                <td>
                                    <input value="" class='form-control' name="trend_UE_0" size="30">
                                </td>
                            </tr>
                            <tr height="30">
                                <td>
                                    مقطع تحصیلی <span style="color:red">*</span>
                                </td>
                                <td>
                                    <select id="level_UE_0" class='form-control'  name="level">
                                        <option value="1">دیپلم</option>
                                        <option value="2">فوق دیپلم</option><option value="3">کارشناسی</option><option value="4">کارشناسی ارشد</option><option value="5">دکترا</option><option value="6">دکترای حرفه ای</option><option value="7">فوق دکتری</option>
                                    </select>
                                </td>
                                <td>
                                    دانشگاه یا موسسه 
                                    <span style="color:red">*</span>
                                </td>
                                <td>
                                    <input type="text" id="University_UE_0" value="" class='form-control'/>
                                </td>
                            </tr>
                            <tr height="30">
                                <td>
                                    استان
                                </td>
                                <td>
                                    <select id="ProvinceUE_0" class='Province form-control'>

                                    </select>
                                </td>
                                <td>
                                    شهر
                                </td>
                                <td>
                                    <select id="CityUE_0" class='City form-control'>
                                        <option value="0">انتخاب کنید</option>
                                    </select> 
                                </td>
                            </tr>
                            <tr height="30">
                                <td>شروع</td>
                                <td>
                                    <input id="EditUE_sdate_0" class="form-control" type="text" value=""/>
                                    <script type="text/javascript">
                                        Calendar.setup({
                                            inputField: "EditUE_sdate_0", // id of the input field
                                            button: "EditUE_sdate_0", // trigger for the calendar (button ID)
                                            ifFormat: "%Y/%m/%d", // format of the input field
                                            dateType: 'jalali',
                                            weekNumbers: false
                                        });</script>
                                </td>
                                <td>پایان</td>
                                <td>
                                    <input id="EditUE_edate_0" class="form-control" type="text" value=""/>
                                    <script type="text/javascript">
                                        Calendar.setup({
                                            inputField: "EditUE_edate_0", // id of the input field
                                            button: "EditUE_edate_0", // trigger for the calendar (button ID)
                                            ifFormat: "%Y/%m/%d", // format of the input field
                                            dateType: 'jalali',
                                            weekNumbers: false
                                        });</script>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4">
                                    توضیح<br>
                                    <textarea  class="form-control" id="comment_UE_0" placeholder="عنوان پایان نامه ،&zwnj; رساله و پروژه های پژوهشی، فعالیتهای برجسته و ..."></textarea>
                                </td>
                            </tr>
                            <tr height="30">
                                <td colspan="4">
                                    <span class="FloatLeft">
                                        <input type="button" value="تایید" editid="0" class="btn btn-primary EditUEOK">
                                        <input type="button" value="لغو" class="btn  btn-default  closeBut">
                                    </span>
                                </td>
                            </tr>

                        </table>
                </td>
            </tr>
            @endif         
            @if(is_array($user_education) && count($user_education[1])>0)

            <?php $i = 1; ?>
            @foreach($user_education[1] as $item)
            <?php
            $grade = '';
            switch ($item['level']) {
                case '1':
                    $grade = "دیپلم";
                    break;
                case '2':
                    $grade = "فوق دیپلم";
                    break;
                case '3':
                    $grade = "کارشناسی";
                    break;
                case '4':
                    $grade = "کارشناسی ارشد";
                    break;
                case '5':
                    $grade = "دکتری";
                    break;
                case '6':
                    $grade = "فوق دکتری";
                    break;
            }
            ?>

            <tr>
                <td>
                    <label style="display:inline;padding:0;width:100%;">{{$i}}- {{ $item['location']  }}</label>
                    @if ($uids == $uid)
                    <div class="icon IconHeight" ><span class="icon-hazv  iconEdit iconDelE" val="{{ $item['id'] }}"></span>
                        <span  class="icon-pencil-1 iconEdit  EditUE" val="EditUE_{{$item['id'] }}" targetid="{{$item['id'] }}"></span>
                    </div>
                    @endif
                    <br>
                    {{$item['trend']}}   {{$grade}}  ؛ {{$item['university']}}   ؛ {{$item['s_year']}}  -  {{$item['e_year']}}  
                </td>



            <tr>
                <td>
                    {{$item['comment']}}
                </td>
            </tr>

            @if ($uids == $uid)
            <tr>
                <td colspan="2">
                    <div id="EditUE_{{$item['id']}}" class="editDiv">
                        <table class="table-striped">
                            <tr height="30">
                                <td>رشته تحصیلی <span style="color:red">*</span>
                                </td>
                                <td>
                                    <input value="{{$item['location']}}" class='form-control' id="location_UE_{{$item['id']}}" size="30">
                                </td>
                                <td>
                                    گرایش
                                </td>
                                <td>
                                    <input value="{{$item['trend']}}" class='form-control' id="trend_UE_{{$item['id']}}" size="30">
                                </td>
                            </tr>
                            <tr height="30">
                                <td>
                                    مقطع تحصیلی <span style="color:red">*</span>
                                </td>
                                <td>
                                    <select id="level_UE_{{$item['id']}}" class='form-control'>
                                        <option value="1" @if($item['level']==1) selected @endif>دیپلم</option>
                                        <option value="2" @if($item['level']==2) selected @endif>فوق دیپلم</option>
                                        <option value="3" @if($item['level']==3) selected @endif>کارشناسی</option>
                                        <option value="4" @if($item['level']==4) selected @endif>کارشناسی ارشد</option>
                                        <option value="5" @if($item['level']==5) selected @endif>دکترا</option>
                                        <option value="6" @if($item['level']==6) selected @endif>دکترای حرفه ای</option>
                                        <option value="7" @if($item['level']==7) selected @endif>فوق دکتری</option>
                                    </select>
                                </td>
                                <td>
                                    دانشگاه یا موسسه 
                                    <span style="color:red">*</span>
                                </td>
                                <td>
                                    <input type="text"  id="University_UE_{{$item['id']}}" value="{{$item['university']}}" class='form-control'/>
                                </td>
                            </tr>
                            <tr height="30">
                                <td>
                                    استان
                                </td>
                                <td>
                                    <select id="ProvinceUE_{{$item['id']}}" class='Province form-control'>

                                    </select>
                                </td>
                                <td>
                                    شهر
                                </td>
                                <td>
                                    <select id="CityUE_{{$item['id'] }}" class='City form-control'>
                                        <option value="0">انتخاب کنید</option>
                                    </select> 
                                </td>
                            </tr>
                            <tr height="30">
                                <td>شروع</td>
                                <td>
                                    <input id="EditUE_sdate_{{$item['id'] }}" class="form-control" type="text" value="{{$item['s_year'] }}"/>
                                    <script type="text/javascript">
                                        Calendar.setup({
                                            inputField: "EditUE_sdate_{{$item['id'] }}", // id of the input field
                                            button: "EditUE_sdate_{{$item['id'] }}", // trigger for the calendar (button ID)
                                            ifFormat: "%Y/%m/%d", // format of the input field
                                            dateType: 'jalali',
                                            weekNumbers: false
                                        });</script>
                                </td>
                                <td>پایان</td>
                                <td>
                                    <input id="EditUE_edate_{{$item['id'] }}" class="form-control" type="text" value="{{$item['e_year'] }}"/>
                                    <script type="text/javascript">
                                        Calendar.setup({
                                            inputField: "EditUE_edate_{{$item['id'] }}", // id of the input field
                                            button: "EditUE_edate_{{$item['id'] }}", // trigger for the calendar (button ID)
                                            ifFormat: "%Y/%m/%d", // format of the input field
                                            dateType: 'jalali',
                                            weekNumbers: false
                                        });</script>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4">
                                    توضیح<br>
                                    <textarea  class="form-control" id="comment_UE_{{$item['id'] }}" placeholder="عنوان پایان نامه ،&zwnj; رساله و پروژه های پژوهشی، فعالیتهای برجسته و ...">{{$item['comment']}}</textarea>
                                </td>
                            </tr>
                            <tr height="30">
                                <td colspan="4">
                                    <span class="FloatLeft">
                                        <input type="button" value="تایید" editid="{{$item['id']}}" class="btn btn-primary EditUEOK">
                                        <input type="button" value="لغو" class="btn  btn-default  closeBut">
                                    </span>
                                </td>
                            </tr>

                        </table>
                </td>
            </tr>
            @endif   

            <?php $i++; ?>

            @endforeach
            @endif 

        </table>
    </div>
</div>

        {{$content}}

    </div>

    @stop

    @include('sections.keywords')



    @section('Files')
    @if (is_array($Files) && count($Files)>0)
    <div class="spacer">
        <div class="panel panel-light fix-box1">
            <div class="fix-inr1">
                <div style="padding: 0;" class="panel-heading panel-heading-darkblue"></div>
                <div class="panel-body text-decoration">
                    <b>{{ Lang::get('label.Files') }}</b>
                    @foreach($Files as $item)
                    <li><a href="{{ $item['id'] }}">{{ $item['ext']}} -><span>{{ $item['title']}}</span>:{{ $item['size']}}ک.ب</a></li>
                    @endforeach
                </div>

            </div>

        </div>
    </div>

    @endif
    @stop

    @section('tabs')
    @if (is_array($tabs))
    @foreach($tabs as $item)
    @if (trim($item['link']) === trim($pid))
    <li class="active"><a href="{{App::make('url')->to('/')}}/{{ $item['href'] }}">{{ $item['title'] }}</a></li>
    @else
    <li><a href="{{App::make('url')->to('/')}}/{{ $item['href'] }}">{{ $item['title']}}</a></li>
    @endif
    @endforeach
    @endif
    @stop
    @section('Tree')
    @include('sections.rightcol')
    @stop
