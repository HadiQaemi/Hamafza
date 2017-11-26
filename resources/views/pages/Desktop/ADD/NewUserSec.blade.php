@extends('pages.Desktop.DesktopFunctions')
@section('content')
<?php
$SecGroup=  json_encode($SecGroup);
$SecGroup=  json_decode($SecGroup);
if ($SecGroup){
        $name = $SecGroup->name;
    $defualt = $SecGroup->defualt;
    $descr = $SecGroup->descr;
    $id = $SecGroup->id;
    
} else {
    $name = '';
    $defualt = '';
    $descr = '';
    $id = '0';
}

function GetSec() {
    
}
?>
<div class="panel-body text-decoration">
    <div class='text-content'>
       <form action="{{ route('hamafza.user_sec_save') }}" method="post" name="form" id="form">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <table class="table" width="100%" border="0" cellpadding="0" cellspacing="5" id="contactform" dir="ltr">

            <tr>
                <td width="80%" align="right" style="border:none;">
                    <input type="hidden" name="editid" value="{{$id}}">
                    <input name="secgroup_name" type="text" value="{{$name}}" class="form-control" id="secgroup_name" dir="rtl" size="50"/></td>
                <td width="20%" style="border:none;">*: نام سطح دسترسی</td>
            </tr>
            <tr>
                <td width="80%" style="border:none;"><textarea  name="descr" class="form-control" id="descr" dir="rtl" style="width: 100%;" >{{$descr}}</textarea></td>
                <td style="border:none;">
                    توضیح
                </td>
            </tr> 
            <tr>
                <td style="line-height:20px; direction:rtl;text-align: right;border:none;">
                    <label><input name="defualt" type="checkbox" value="1" @if($defualt=='1') checked  @endif/>بلی</label><br />              
                </td>
                <td  style="border:none;">
                    : پیش فرض برای کاربران جدید
                </td>
            </tr>  
            <tr>
                <td dir="rtl" colspan="2" ><input name="news_date" type="hidden" id="news_date" value="<?php echo gmdate("Y-m-d H:i:s", time() + 12600) ?>" /><input type="hidden" name="work" id="work" value="<?php echo (isset($secgroup_add['work']) ? $secgroup_add['work'] : '') ?>" /></td>
            </tr>

        </table>
        <label>ابزارها</label>
        <table class="table table-striped" width="100%" border="0" cellpadding="3" cellspacing="1" dir="rtl">
            <tbody>
                <tr>
                    <th  align="center">ردیف</th>
                    <th  align="center">نوع</th>

                    <th  align="center">مجوز</th>
                    <th align="center"></th>
                </tr>

                @if(is_array($Access) && count($Access)>0)
                <?php $i = 1; ?> 
                @foreach($Access['abzar'] as $item)
                <tr id="user_security_{{$item->id}}">
                    <td align="center">{{$i}}</td>
                    <td nowrap="nowrap"> {{$item->gname}}
                    </td>
                    <td nowrap="nowrap"> {{$item->Fname}}
                        <input type="hidden" name="Access[{{$i}}]" value="{{$item->id}}"/>
                    </td><td align="center">
                        @foreach($ACL as $items)
                        <input type="radio" id="AcsLVL_{{$item->id}}" name="ACL[{{$i}}]" value="{{$items->id}}" 

                               @if(is_array($GroupAccess) && count($GroupAccess)>0)
                               @foreach($GroupAccess as $GA)

                               @if($GA->accid==$item->id && $GA->levelid==$items->id)
                               checked 
                               <?php $c = true; ?>
                               @endif
                               @endforeach
                               @else
                               checked
                               @endif
                               style="margin-right:20px;"  >{{$items->name}}
                               @endforeach

                    </td></tr>
                <?php $i++; ?>
                @endforeach
                @endif

            </tbody></table>

        <label> میزکار</label>
        <table class="table table-striped" width="100%" border="0" cellpadding="3" cellspacing="1" dir="rtl">
            <tbody>
                <tr>
                    <th  align="center">ردیف</th>
                    <th  align="center"></th>
                    <th  align="center">مجوز</th>
                    <th align="center"></th>
                </tr>
                @if(is_array($Access) && count($Access)>0)
                @foreach($Access['peik'] as $item)
                <tr id="user_security_{{$item->id}}">
                    <td align="center">{{$i}}</td>
                    <th  align="center"></th>

                    <td nowrap="nowrap"> {{$item->Fname}}
                        <input type="hidden" name="Access[{{$i}}]" value="{{$item->id}}"/>
                    </td>
                    <td align="center">
                        @foreach($ACL as $items)
                        <input type="radio" id="AcsLVL_{{$item->id}}" name="ACL[{{$i}}]" value="{{$items->id}}" 

                               @if(is_array($GroupAccess) && count($GroupAccess)>0)
                               @foreach($GroupAccess as $GA)

                               @if($GA->accid==$item->id && $GA->levelid==$items->id)
                               checked 
                               <?php $c = true; ?>
                               @endif
                               @endforeach
                               @else
                               checked
                               @endif
                               style="margin-right:20px;"  >{{$items->name}}
                               @endforeach

                    </td>
                </tr>
                <?php $i++; ?>
                @endforeach
                @endif

            </tbody></table>

        <label>صفحات</label>
        <table class="table table-striped" width="100%" border="0" cellpadding="3" cellspacing="1" dir="rtl">
            <tbody>
                <tr>
                    <th  align="center">ردیف</th>
                    <th  align="center"></th>
                    <th  align="center">مجوز</th>
                    <th align="center"></th>
                </tr>
                @if(is_array($Access) && count($Access)>0)
                @foreach($Access['pages'] as $item)
                <tr id="user_security_{{$item->id}}">
                    <td align="center">{{$i}}</td>
                    <th  align="center"></th>
                    <td nowrap="nowrap"> {{$item->Fname}}
                        <input type="hidden" name="Access[{{$i}}]" value="{{$item->id}}"/>
                    </td>
                    <td align="center">
                        @foreach($ACL as $items)
                        <input type="radio" id="AcsLVL_{{$item->id}}" name="ACL[{{$i}}]" value="{{$items->id}}" 
                               @if(is_array($GroupAccess) && count($GroupAccess)>0)
                               @foreach($GroupAccess as $GA)

                               @if($GA->accid==$item->id && $GA->levelid==$items->id)
                               checked 
                               <?php $c = true; ?>
                               @endif
                               @endforeach
                               @else
                               checked
                               @endif
                               style="margin-right:20px;"  >{{$items->name}}
                               @endforeach
                    </td>
                </tr>
                <?php $i++; ?>
                @endforeach
                @endif

            </tbody></table>
        <button name="addasubject" class="btn btn-primary FloatLeft" type="submit">تایید</button>
       </form>

    </div>
</div>

@stop