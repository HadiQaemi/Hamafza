<div class="row pull-left">
    <input type="radio" class="is_approved" id="is_approved_0" name="is_approved" value="0"{!! $is_edit && $keyword ? (0 == $keyword->is_approved ? ' checked="checked"' : null) : null !!}/>
    <label for="is_approved_0">موقت</label>
    <input type="radio" class="is_approved" id="is_approved_1" name="is_approved" value="1"{!! $is_edit && $keyword ? (1 == $keyword->is_approved ? ' checked="checked"' : null) : null !!}/>
    <label for="is_approved_1">مصوب</label>
</div>
<div class="row pull-left">
    @if (!$is_edit)
        <span>
            <button type="button" class="btn btn-primary" id="submit" onclick="keyword_addedit(this, true)">
                <span>تایید و ثبت کلید واژه جدید</span>
            </button>
        </span>
    @endif
    <span>
        <button type="button" class="btn btn-primary" id="submit" onclick="keyword_addedit(this)">
            <i class=""></i> <span>تایید</span>
        </button>
    </span>
</div>
