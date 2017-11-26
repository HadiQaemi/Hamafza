<style>
    .form_coupon .form-group
    {
        margin-bottom: 10px;
    }
</style>
<form class="form_coupon" style="padding: 10px; display: none;">
    <table class="table table_coupon table-condensed">
        <colgroup>
            <col class="col-sm-3">
            <col class="col-sm-9">
        </colgroup>
        <tr>
            <td>
                <label for="applicant">{!! trans('bazaar.discountcoupon.applicant') !!}:</label>
            </td>
            <td>
                <select class="form-control" id="applicant">
                    @foreach (['1', '2', '3', '5', '6', '7', '8', '9', '4', ] as $i)
                        <option value="{!! $i !!}" data-document="{!! trans("bazaar.discountcoupon.applicant_documents.$i") !!}">
                            {!! trans("bazaar.discountcoupon.applicant_values.$i") !!}
                        </option>
                    @endforeach
                </select>
            </td>
        </tr>
        <tr>
            <td>
                <label for="count">{!! trans('bazaar.discountcoupon.count') !!}:</label>
            </td>
            <td>
                <input type="text" class="form-control" id="count" value="0" />
            </td>
        </tr>
        <tr>
            <td>
                <label>{!! trans('bazaar.discountcoupon.required_document') !!}:</label>
            </td>
            <td>
                <span id="required_document">{!! trans("bazaar.discountcoupon.applicant_documents.1") !!}</span>
            </td>
        </tr>
        <tr>
            <td>
                <label>{{trans('filemanager.attachs')}}</label>
            </td>
            <td class="filemanager-buttons-client-place">
            </td>
        </tr>
        <tr>
            <td colspan="2">
                {!! $document['ShowResultArea']['couponrequest_document'] !!}
            </td>
        </tr>
    </table>
    <div style="display: none;">{!! $document['Buttons']['couponrequest_document'] !!}</div>
    <input type="hidden" class="form-control" id="subject_id" value="" />
</form>
{!! $document['UploadForm'] !!}
{!! $document['JavaScripts'] !!}
