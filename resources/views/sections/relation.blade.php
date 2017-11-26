@if(isset($Rel) && is_array($Rel) && count($Rel)>0)
    <div class="spacer">
        <div class="panel panel-light fix-box1">
            <div class="fix-inr1">
                <div class=" panel-heading-darkblue" style="border-width: 1px; border-color: rgb(62, 179, 50); border-bottom: 1px solid rgb(62, 179, 50); padding: 10px ;"> دریچه ناوبری</div>
                <div style="padding: 0;" class="panel panel-light panel-list padding-remove"></div>
                <div class="panel-body text-decoration" style="padding: 5px;">
                    <!--                <b>دریچه ناوبری</b> -->
                    @foreach($Rel as $r)
                        <p class="Dar">
                            <b>
                                @if( $r['DaricheTitle']!='')
                                    {{$r['DaricheTitle']}}
                                @endif
                                @if($r['SubjectID']!='')
                                    <?php
                                    $urls = \App\HamafzaPublicClasses\FunctionsClass::CratePagelink($r['SubjectID']);
                                    ?>
                                    <a href="{{$urls}}">
                                        {{ $r['SubjectTitle']}}
                                    </a>
                                @endif
                            </b>

                            @if(is_array($r['pages']) && count($r['pages'])>0)
                                <?php

                                $end = end($r['pages']);
                                ?>
                                <br>
                                @foreach($r['pages'] as $p)
                                    <?php
                                    $url = \App\HamafzaPublicClasses\FunctionsClass::CratePagelink($p->id);
                                    ?>
                                    <a href="{{$url}}">{{$p->title}}</a>
                                    @if(($p->id!=$end->id) && ($p->title!=$end->title))
                                        <span class="icon-2-2" style="height: 5px;font-size: 4pt;"></span>
                                    @endif
                                @endforeach
                            @endif
                        </p>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
@endif
<style>
    .Dar {
        border-bottom: 2px solid #e5e5e5;
        font-size: 12px;
        margin: 0;
        padding: 5px 10px;
    }
</style>