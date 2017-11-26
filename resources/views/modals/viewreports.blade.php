<div class="guran-sooreh-list">
  
    @if($Message=='')
    
      <div class="navbar navbar-default">
        <span class="help-icon-span" style="position: absolute;top: -10px;">
            <a href="{{App::make('url')->to('/')}}/modals/helpview?id=17&tagname=abzartanzimat&hid=6" title="راهنمای اینجا" href="#" class="jsPanels icon-help HelpIcon" style="float: left;padding-left: 20px;padding-top: 15px;" title="راهنمای اینجا" data-placement="top" data-toggle="tooltip">
            </a></span>
        <ul class="nav nav-tabs">
            <li class="active"><a aria-controls="sooreh-tab-1" href="#sooreh-tab-1" role="tab" data-toggle="tab">پاسخ دهندگان</a></li>
            <li><a aria-controls="sooreh-tab-2" href="#sooreh-tab-2" role="tab" data-toggle="tab">پاسخ‌ها به تفکیک پاسخ دهندگان </a></li>
            <li><a aria-controls="sooreh-tab-3" href="#sooreh-tab-3" role="tab" data-toggle="tab">پاسخ‌ها به تفکیک پرسش‌ها</a></li>

        </ul>
    </div>
    <div class="tab-content">
        <div id="sooreh-tab-1" role="tabpanel" class="tab-pane active"  style="padding: 10px;">
            @if(is_array($Users) && count($Users)>0)
            <table class="table">
                <tr>
                    <td>ردیف</td>
                    <td>نام</td>
                    <td>تاریخ</td>
                </tr>
                <?php $i = 1; ?>
                @foreach($Users as $item)
                <tr>
                    <td>{{$i}}</td>
                    <td><a target="_blank" href="{{App::make('url')->to('/')}}/{{$item['Uname']}}">{{$item['Name']}} {{$item['Family']}}</a></td>
                    <td>{{$item['Date']}}</td>

                </tr>
                <?php $i++; ?>

                @endforeach
            </table>

            @endif
        </div>
        <div id="sooreh-tab-2" role="tabpanel" class="tab-pane"  style="padding: 10px;">
            @if(is_array($Users) && count($Users)>0)
            @foreach ($Users as $key => $item) 
            <label><a target="_blank" href="{{App::make('url')->to('/')}}/{{$item['Uname']}}">{{$item['Name']}} {{$item['Family']}}</a> ({{$item['Date']}})</label>   
            <br>
            <table class="table">
                @foreach($fileds  as $f => $field)
                <tr>
                    <td style="width: 50%">{{$field}}</td>
                    <td>
                        
                         @if(array_key_exists($f, $vals[$key]))
                        {{$vals[$key][$f]}}
                        @endif
                    </td>
                </tr>
                @endforeach
            </table>
            @endforeach
            </table>

            @endif
        </div>
        <div id="sooreh-tab-3" role="tabpanel" class="tab-pane" style="padding: 10px;">
            @if(is_array($Users) && count($Users)>0)
            @foreach ($fileds  as $f => $field ) 
            <label>{{$field}}</label>
            <br>
            <table class="table">
                @foreach($Users as $key => $item)
                <tr>
                    <td style="width: 50%">
                         <a target="_blank" href="{{App::make('url')->to('/')}}/{{$item['Uname']}}">{{$item['Name']}} {{$item['Family']}}</a>
                        </td>
                    <td>
                        @if(array_key_exists($f, $vals[$key]))
                        {{$vals[$key][$f]}}
                        @endif
                    </td>
                </tr>
                @endforeach
            </table>
            @endforeach
            </table>

            @endif
        </div> 

    </div>
    
    @else
    {{$Message}}
    @endif

</div>