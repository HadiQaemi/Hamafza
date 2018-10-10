<div @if ('kmkz' !== config('constants.IndexView')) class="" ng-controller="loginController" @endif>
    @if (auth()->check())
        <div style="font-size:9pt;">
            <div class="HomeItemDiv general-list">
                <div  class="icons3 ">
                    <span style="color:#2093d4 !important;font-size: 12pt;"  class="icon-pooshe"></span>
                </div>
                <div style="display: inline;">
                    <a href="{{ auth()->user()->Uname }}/desktop/Tasks/MyTasks/list" style=";color:#FFF;">
                        @if($dashboard['Eghdam']>0)
                        {{$dashboard['Eghdam']}}  وظیفه جدید دارید.
                        @else
                        وظیفه جدیدی ندارید
                        @endif
                    </a>
                </div>
            </div>
            <div class="HomeItemDiv general-list">
                <div class="icons3 ">
                    <span style="color:#42ff00 !important;font-size: 12pt; "  class="icon-tamasbama"></span>
                </div>
                <div style="display: inline;">
                    <a href="{{ auth()->user()->Uname }}/desktop/tickets/inbox" style=";color:#FFF;">
                        @if($dashboard['Email']>0)
                        {{$dashboard['Email']}}  پیام جدید دارید.
                        @else
                         پیام جدیدی ندارید
                        @endif
                    </a>
                </div>
            </div>
            <div class="HomeItemDiv general-list">
                <div class="icons3 " >
                    <span style="font-size: 12pt;"  class="icon-4"></span>
                </div>
                <div style="display: inline;">
                    <a href="{{ auth()->user()->Uname }}/desktop/showgroups" style=";color:#FFF;">
                        @if($dashboard['Group']>0)
                         عضو {{$dashboard['Group']}} گروه بوده
                        @else
                        عضو هیچ گروه نمی باشید
                        @endif

                        @if($dashboard['User']>0)
                          و با {{$dashboard['User']}} کاربر مرتبط هستید.
                        @else
                         و با هیچ کاربری مرتبط نیستید.
                        @endif
                    </a>
                </div>
            </div>
            <div class="HomeItemDiv general-list">
                <div class="icons3 ">
                    <span style="color:#fd9f19 !important;font-size: 12pt;" class="icon-mataleb"></span>
                </div>
                <div style="display: inline;">
                    <a href="{{ auth()->user()->Uname }}/desktop/files/Created_ME" style=";color:#FFF;">
                        @if($dashboard['Post']>0)
                           {{$dashboard['Post']}} مطلب نوشته اید،
                        @else
                           تا کنون مطلبی ننوشته اید
                        @endif
                        @if($dashboard['Page']>0)
                            و {{$dashboard['Page']}} صفحه ایجاد کرده‌اید.
                        @else
                          و هیچ صفحه ای ایجاد نکرده اید
                        @endif
                    </a>
                </div>
            </div>
        </div>
    @elseif ('kmkz' == config('constants.IndexView'))
        @include('sections.homelogin-kmkz')
    @else
        @include('sections.homelogin')
    @endif
</div>
