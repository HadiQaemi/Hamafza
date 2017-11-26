<center>
    <span class="OghatHome">
        امروز 
        {{jDate::forge(time())->format('%A %Y/%m/%d ' );}}
        <span>
            <script type="text/javascript" language="javascript" src="{{App::make('url')->to('/')}}/theme/Scripts/oghat.js"></script>
            <script language="javascript">var CurrentDate = new Date();
var JAT = 0;
function pz() {
}
;
init();
document.getElementById("cities").selectedIndex = 12;
coord();
main();
            </script>
        </span>
</center> 