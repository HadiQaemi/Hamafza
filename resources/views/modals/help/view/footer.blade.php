<div class="col-xs-12">
    <div class="col-xs-4 pull-left" style="margin-top: 5px;">
        <input type="submit" class="btn btn-primary FloatLeft" value="ارسال " id="submitHelp" name="submit">
        <div style="margin: 5px 0 0 25px;">
            <span>آیا این راهنما مفید بود؟</span>
            <input style="margin-right: 10px; margin-left: 5px;" type="radio" class="Clicks" name="okhelp" value="1" checked="">بلی
            <input style="margin-right: 10px; margin-left: 5px;" type="radio" class="Clicks" name="okhelp" value="0">خیر
            <textarea id="helpcomment" name="helpcomment" class="form-control" style="margin: 10px;display: none;" placeholder="پیشنهاد شما برای بهترشدن این راهنما چیست؟"></textarea>
        </div>
    </div>
    <div class="col-xs-8 pull-right">
        <table>
            <tr>
                <td>
                    <a style="margin-left: 2px;color:#898989;" href="{{App::make('url')->to('/')}}/21">گام‌های آغاز</a>
                </td>
                <td>
                    <div class="Footicon icon-2-3" style="color: #9498A0;margin-top: -1px;"></div>
                    <a style="margin-left:2px;color:#898989;" href="{{App::make('url')->to('/')}}/17">راهنمای کامل نرم افزار</a>
                </td>
                <td>
                    <div class="Footicon icon-2-3" style="color: #9498A0;margin-top: -1px;"></div>
                    <a style="margin-left: 2px;color:#898989;" href="{{App::make('url')->to('/')}}/20">درگاه راهنما</a>
                </td>
                <td>
                    <div class="Footicon icon-2-3" style="color: #9498A0;margin-top: -1px;"></div>
                    <a style="margin-left:2px;color:#898989;" href="{{App::make('url')->to('/')}}/51">
                        <span>پرسش های متداول</span>
                    </a>
                </td>
            </tr>
        </table>
    </div>
</div>
