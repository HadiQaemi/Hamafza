@php ($file = route('FileManager.DownloadFile', ['type' => 'ID', 'id' => enCode($coupon->request->document_file_id)]))
<table class="table table_coupon">
    <tr>
        <td>{!! trans('bazaar.discountcoupon.coupon') !!}:</td>
        <td>{!! $coupon->coupon !!}</td>
    </tr>
    <tr>
        <td>{!! trans('bazaar.discountcoupon.type') !!}:</td>
        <td>{!! trans($coupon->type ? 'bazaar.discountcoupon.type_amount' : 'bazaar.discountcoupon.type_percentage') !!}</td>
    </tr>
    <tr>
        <td>{!! trans('bazaar.discountcoupon.applicant') !!}:</td>
        <td>{!! trans('bazaar.discountcoupon.applicant_values.' . $coupon->request->applicant) !!}</td>
    </tr>
    <tr>
        <td>{!! trans('bazaar.discountcoupon.count') !!}:</td>
        <td>{!! $coupon->request->count . ' ' . trans('bazaar.discountcoupon.person')!!}</td>
    </tr>
    <tr>
        <td>{!! trans('bazaar.discountcoupon.required_document') !!}:</td>
        <td>{!! trans('bazaar.discountcoupon.applicant_documents.' . $coupon->request->applicant) !!}</td>
    </tr>
    <tr>
        <td>{!! trans('filemanager.attachs') !!}</td>
        <td><a href="{!! $file !!}">{!! trans('filemanager.download') !!}</a></td>
    </tr>
</table>
