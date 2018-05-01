@php
    $date = HDate_GtoJ(time(), "m/d", true);
    list ($m, $d) = explode('/', $date);
    $jat = (int) !((6 == (int) $m && 31 == (int) $m) || $m > 6);
@endphp

<div style="text-align: center;">
    <div class="OghatHome">
        <span>امروز</span>
        {{jdate(time())->format('%A %Y/%m/%d ' )}}
        <div>
            <script type="text/javascript" language="javascript" src="{{ url('/theme/Scripts/oghat.js') }}"></script>
            <script language="javascript">var CurrentDate = new Date();
                var JAT = {!! $jat !!};
                function pz() {};
                init();
                document.getElementById('cities').selectedIndex = 12;
                coord();
                main();
            </script>
        </div>
    </div>
</div>