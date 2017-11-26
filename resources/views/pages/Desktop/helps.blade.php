@extends('pages.Desktop.DesktopFunctions')
@section('content')
<script type="text/javascript">
    function ADD() {
        var count = $("#counter").val();
        count++;
        $("#counter").val(count);
        var mylayer = $('#RelS').html();
        str = mylayer.replace("[1]", "[" + count + "]");
        str = str.replace("_1", "_" + count);
        str = str.replace('tid="1"', 'tid="' + count + '"');
        str = str.replace("ContentHelps_1", "ContentHelps_" + count);
                str = str.replace("ContentHelps[1]", "ContentHelps[" + count+ "]");
        $('#RelSs').append(str);
    }

    function ADD_val(pid, helptext, helpvalue) {
        var count = $("#counter").val();
        count++;
        $("#counter").val(count);
        var mylayer = $('#RelS').html();
        str = mylayer.replace("[1]", "[" + count + "]");
        str = str.replace("_1", "_" + count);
        str = str.replace('tid="1"', 'tid="' + count + '"');
        str = str.replace("ContentHelps_1", "ContentHelps_" + count);
        $("#helppage_" + count).val(pid);
        var o = new Option(helptext, helpvalue);
        $("#ContentHelps_" + count).append(o);
        $('#RelSs').append(str);
    }

    function ShowHelps(e) {
        var tid = $(e).attr('tid');
        keyword = $("#helppage_" + tid).val();
        $("#ContentHelps_" + tid).find('option').remove().end();
        var Helpnames = $("#SelectedHelp").val();
        keyword = $('#helppage').val();
        jQuery.ajax({
            type: "POST",
            url: "{{ route('hamafza.show_helps') . '?keyword=' }}" + keyword + "&Sel=" + Helpnames,
            {{--url: "{{App::make('url')->to('/')}}/showhelps?keyword=" + keyword + "&Sel=" + Helpnames,--}}
            data: {keyword: keyword, Helpnames: Helpnames},
            cache: false,
            success: function(html) {
                html = html.substring(0, html.length - 1);
                var Res_array = html.split(';');
                var i;
                for (i = 0; i < Res_array.length; i++) {
                    var Res_array2 = Res_array[i].split(':');
                    var o = new Option(Res_array2[1], Res_array2[0]);
                    if (Res_array[i] == Helpnames)
                        o.selected = true;
                    $("#ContentHelps_" + tid).append(o);

                }
            }
        });
    }
    $(document).ready(function() {


        $("#HelpRelBut").click(function() {
                   $("#counter").val('1');
                    $('#RelSs').html('');

            var helppage = $("#helppage").val();
            var Helpnames = $("#ContentHelps").val();
            keyword = $('#helppage').val();
            jQuery.ajax({
                type: "POST",
                url: "{{ route('hamafza.show_help_rel') . '?ContentHelps=' }}" + Helpnames + "&helppage=" + helppage,
                data: ({helppage: keyword, Helpnames: Helpnames}),
                dataType: 'html',
                cache: false,
                success: function(html) {
                    var arr = JSON.parse(html);
                    $('#RelSs').html('');
                    j = 1;
                    for (var i = 0; i < arr.length; i++) {
                        ADD();
                        var obj = arr[i];
                        $("#helppage_" + j).val(obj['tpid']);
                        var o = new Option(obj['Tname'], obj['T']);
                        $("#ContentHelps_" + j).append(o);
                        alert(obj['T']);
                        j++;

//                        $("#ContentHelps_" + tid).append(o);
//                        alert(obj['T'])
                    }
                }
            });

        });




        $("#ShowHelps").click(function() {
            $('#ContentHelps').find('option').remove().end();
            var Helpnames = $("#SelectedHelp").val();
            keyword = $('#helppage').val();
            jQuery.ajax({
                type: "POST",
                url: "{{ route('hamafza.show_helps') . '?keyword=' }}" + keyword + "&Sel=" + Helpnames,
                data: {keyword: keyword, Helpnames: Helpnames},
                cache: false,
                success: function(html) {
                    html = html.substring(0, html.length - 1);
                    var Res_array = html.split(';');
                    var i;
                    for (i = 0; i < Res_array.length; i++) {
                        var Res_array2 = Res_array[i].split(':');
                        var o = new Option(Res_array2[1], Res_array2[0]);
                        if (Res_array[i] == Helpnames)
                            o.selected = true;
                        $("#ContentHelps").append(o);

                    }
                }
            });

        });

        $(".ShowHelps").click(function() {

            var tid = $(this).attr('tid');
            keyword = $("#helppage_" + tid).val();
            $("#ContentHelps_" + tid).find('option').remove().end();
            var Helpnames = $("#SelectedHelp").val();
            keyword = $('#helppage').val();
            jQuery.ajax({
                type: "POST",
                url: "{{ route('hamafza.show_helps') . '?keyword=' }}" + keyword + "&Sel=" + Helpnames,
                data: {keyword: keyword, Helpnames: Helpnames},
                cache: false,
                success: function(html) {
                    html = html.substring(0, html.length - 1);
                    var Res_array = html.split(';');
                    var i;
                    for (i = 0; i < Res_array.length; i++) {
                        var Res_array2 = Res_array[i].split(':');
                        var o = new Option(Res_array2[1], Res_array2[0]);
                        if (Res_array[i] == Helpnames)
                            o.selected = true;
                        $("#ContentHelps_" + tid).append(o);

                    }
                }
            });

        });


    });</script>
<div class="panel-body text-decoration">
          {{ Form::open(array('route' => 'hamafza.help_save')) }}

    <table>
        <tr>
            <td style="text-align: right;">صفحه راهنما : </td> 
            <td style="text-align: right;">
                شماره صفحه
                <input type="text" style=" max-width: 110px; display: inline;" value="" dir="rtl"  id="helppage" name="main_helppage" class="form-control">
                <span style="cursor: pointer;" id="ShowHelps">نمایش متون راهنمای این صفحه</span>
                <div style="display: inline-block;">
                    <select style=" display: inline;" id="ContentHelps" name="main_ContentHelps" class="form-control">
                    </select>

                </div>
                <span id="HelpRelBut" class="btn btn-primary" >نمایش</span>

            </td>
        </tr>
    </table>

    <p>

    </p>
    <p></p>
    <input type="hidden" name="counter" id="counter" value="1">
    <div id="RelS">
        <table>
            <tr>
                <td style="text-align: right;">صفحه راهنما : </td> 
                <td style="text-align: right;">
                    شماره صفحه
                    <input type="text" style=" max-width: 110px; display: inline;" value="" dir="rtl" id="helppage_1"  name="helppage[1]" class="form-control ">
                    <span style="cursor: pointer;" tid="1" onclick="ShowHelps(this)" class="ShowHelps">نمایش متون راهنمای این صفحه</span>
                    <div style="display: inline-block;">
                        <select style=" display: inline;" id="ContentHelps_1" name="ContentHelps[1]" class="form-control">
                        </select>
                    </div>

                </td>
            </tr>
        </table>
    </div>
    <div id="RelSs">
    </div>

    
    <input type="submit" value="تایید" title="Searchpost" class="btn btn-primary FloatLeft" id="HelpRelBut" style="padding:6px;">
    
        </form>

</div>

@stop