@extends('pages.Desktop.DesktopFunctions')
@section('content')

<div class="panel-body text-decoration">
    <table>
        <tr>
            <td style="text-align: right;"> : </td> 
            <td style="text-align: right;">
                شماره صفحه
                <input type="text" style=" max-width: 110px; display: inline;" value="" dir="rtl"  id="helppage" name="main_helppage" class="form-control">
                <span style="cursor: pointer;" id="ShowHelps">نمایش متون راهنمای این صفحه</span>
                <div style="display: inline-block;">
                    <select style=" display: inline;" id="ContentHelps" name="main_ContentHelps" class="form-control">
                    </select>

                </div>
                <span id="HelpRelBut" class="btn btn-info" >نمایش</span>

            </td>
        </tr>
    </table>
</div>

@stop