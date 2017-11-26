<div style="height: 200px;">
<form action="{{ route('hamafza.new_circle') }}" method="post">
    
                     <input type="hidden" name="_token" value="{{ csrf_token() }}" />

    <span class="help-icon-span WindowHelpIcon">
        <a href="{{App::make('url')->to('/')}}/modals/helpview?id=17&tagname=abzarhalqe&hid=6" title="راهنمای اینجا" href="#" class="jsPanels icon-help HelpIcon" style="float: left;padding-left: 20px;" title="راهنمای اینجا" data-placement="top" data-toggle="tooltip">
        </a>
    </span>
    <br>
    <p></p>
    <br>
    <table class="table">
        <tr>
            <td>
                نام حلقه 
            </td>
            <td>
                <input name="circle_name" type="text" placeholder="نام حلقه" value="" class="form-control required" id="circle_name" dir="rtl" size="20">

            </td>
        </tr>
        <tr>
            <td></td>
            <td>
                <input type="submit" id="submit" name="circle_add" value="ایجاد" class="btn btn-primary FloatLeft">  
            </td>
        </tr>
    </table>
</form>
</div>

