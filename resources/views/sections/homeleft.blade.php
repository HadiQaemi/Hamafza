   <center>
                                        <span class="OghatHome">
                                            امروز 
                                            {{jdate(time())->format('%A %Y/%m/%d ' )}}
                                            <span>
                                                <script type="text/javascript" language="javascript" src="{{App::make('url')->to('/')}}/theme/Scripts/oghat.js"></script>
                                                <script language="javascript">var CurrentDate = new Date();
                                                var JAT = 1;
                                                function pz() {
                                                }
                                                ;
                                                init();
                                                document.getElementById("cities").selectedIndex = 12;
                                                coord();
                                                main();</script>
                                            </span>
                                    </center> 