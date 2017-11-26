@include('modals.modalheader')

<style>
    body
    {
        background-color: white;
    }
</style>

<div style="padding: 20px">
 
    انتخاب اطلاعیه:
@if(count($sura)>1)
 <select dir="rtl" class="form-control" id="alert" name="alert">
     @foreach ($sura as $value)
        <option value="{{$value->id}}">{{$value->name}} </option>
       @endforeach  
 </select>

@endif
</div>