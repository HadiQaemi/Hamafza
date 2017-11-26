@if(isset($tools_menu))
    {!! $tools_menu !!}
@else
    {!! toolsGenerator([1=>['sid'=>4260,'p'=>1],2,3,4,5,6,7,8,9],1,4) !!}
@endif