<form id="form_login" action="{{ route('hamafza.field_update') }}" method="post">
    <table class="table tableTBL">
        <tr>
            <th>#</th>
            <th>نام</th>
            <th>نوع</th>
            <th>مقادیر</th>
            <th>حذف</th>
        </tr>
        @if (is_array($Fileds))
            <?php $i = 1; ?>
            @foreach($Fileds as $item)
                <tr>
                    <td>{{$i}}</td>
                    <td><input type="text" value="{{$item->field_name}}" class="form-control" name="field_name[{{$i}}]">
                        <input type="hidden" value="{{$item->did}}" name="did[{{$i}}]">
                        <input type="hidden" value="1" name="update[{{$i}}]">
                    </td>
                    <td>
                        <select name="field_type[{{$i}}]" class="form-control">
                            @foreach ($Type as  $val)
                                <option value="{{$val->type}}"
                                        @if($item->field_type == $val->type)
                                        selected=""
                                        @endif
                                >{{$val->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="text" value="@if(is_array($item->values) && count($item->values)>1)@foreach ($item->values as  $vals){{$vals->field_value}}| @endforeach @endif" class="form-control" name="field_value[{{$i}}]">
                    </td>
                    <td><input type="checkbox" name="delete[{{$i}}]" class="form-control"></td>
                </tr>
                <?php $i++; ?>
            @endforeach
        @endif
        <?php
        $j = $i + 5;
        for (; $i <= $j; $i++) {
        ?>
        <tr>
            <td>{{$i}}</td>
            <td><input type="text" value="" class="form-control" name="field_name[{{$i}}]">
            </td>
            <td>
                <select name="field_type[{{$i}}]" class="form-control">
                    @foreach ($Type as  $val)
                        <option value="{{$val->type}}">{{$val->name }}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <input type="text" value="" class="form-control" name="field_value[{{$i}}]">
            </td>
            </td>
        </tr>
        <?php
        }
        ?>
        <tr>
            <td colspan="5">
                <button name="addasubject" class="btn btn-primary FloatLeft" type="submit">تایید</button>
            </td>
        </tr>
    </table>
</form>
