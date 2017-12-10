<div style="text-align: center;">
    <div class="OghatHome">
        <span>امروز</span>
        {{jdate(time())->format('%A %Y/%m/%d ' )}}
        <div>
            <script type="text/javascript" language="javascript" src="{{ url('/theme/Scripts/oghat.js') }}"></script>
            <script language="javascript">var CurrentDate = new Date();
                var JAT = 0;
                function pz() {};
                init();
                document.getElementById('cities').selectedIndex = 12;
                coord();
                main();
            </script>
        </div>
    </div>
</div>