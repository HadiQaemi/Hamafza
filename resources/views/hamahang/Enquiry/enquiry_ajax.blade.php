@if (3 == $sub_kind)
    @include ('hamahang.Enquiry.helper.subcontent_idea')
@elseif (4 == $sub_kind)
    @include ('hamahang.Enquiry.helper.subcontent_experience')
@else
    @include ('hamahang.Enquiry.helper.subcontent')
@endif
