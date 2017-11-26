@include('modals.modalheader')

<div style="padding: 20px">
 
    انتخاب اطلاعیه:
@if(is_array($sura))
 <select dir="rtl" class="form-control" id="thes" name="alert">
     @foreach ($sura as $value)
        <option value="{{$value['id']}}">{{$value['name']}} </option>
       @endforeach  
 </select>

@endif
</div>