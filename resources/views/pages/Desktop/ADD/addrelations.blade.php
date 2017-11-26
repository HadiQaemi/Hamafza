@extends('pages.Desktop.DesktopFunctions')
@section('content')
<div class="panel-body text-decoration">
    <div class='text-content'>
        <form id="form_login" action="{{ route('hamafza.relation_save') }}" method="post">
            {{ csrf_field() }}
            <div class="col-md-12">
                <table class="table">
                    <tr>
                        <td class="table-active">
                            نام
                        </td>
                        <td>
                            <input type="hidden" value="0" name="editid">
                            <input type="text"  required="" class="form-control col-xs-8" name="name">
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: right;border:none;" class="table-active">
                            نام حالت مستقیم
                        </td>
                        <td style="text-align: right;border:none;">
                            <input type="text"  class="form-control col-xs-8" name="directname">
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: right;border:none;">
                            نام حالت معکوس
                        </td>
                        <td style="text-align: right;border:none;">
                            <input type="text"  id="comment" rows="2" class="form-control" name="Inversename">
                        </td>
                    </tr>

                    <tr>
                        <td>عنوان دریچه ناوبری</td>
                        <td>
                            <input type="text" id="comment" rows="2" class="form-control" name="dariche">
                        </td>
                    </tr>
                    <tr>
                        <td>عنوان دریچه ناوبری حالت معکوس</td>
                        <td>
                            <input type="text"  id="comment" rows="2" class="form-control" name="dariche_inver">
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: right;border:none;" class="table-active">
                            حالت نمایش
                        </td>
                        <td style="text-align: right;border:none;">
                            <select class="form-control col-xs-4" name="charchoob">
                                <option value="0" >مستقیم</option>
                                <option value="1">معکوس</option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td>
                        </td>
                        <td>
                            <button type="submit" class="btn btn-primary FloatLeft" name="addasubject">تایید</button>

                        </td>
                    </tr>
                </table>
                <br>
                <br>

            </div>
        </form>
    </div>
</div>

@stop