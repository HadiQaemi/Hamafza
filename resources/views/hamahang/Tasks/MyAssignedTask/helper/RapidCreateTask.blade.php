<style>
    .datepicker-plot-area_2 {
        position: relative !important;
        top: 50% !important;
        left: -80% !important;
    }
</style>
<div class="row row_height rapid-task">
    <hr class="hr-4"/>
    <form method="POST" id="form_create_rapid_task">
        <div class="col-xs-3" dir="rtl">
            <input type="text" class="form-control" autocomplete="off" placeholder="عنوان وظیفه" name='task_title' id="create_rapid_task_title"/>
        </div>
        <div class="col-xs-6" style="padding-left: 15px">
            <div class="input-group">
                <select id="create_rapid_task_multi_selected_users" name="selected_users[]" data-placeholder="{{trans('tasks.responsible')}}" multiple="multiple"></select>
                <span class="input-group-addon">
                    <i class="">
                        <a href="{!! route('modals.setting_user_view',['id_select'=>'create_rapid_task_multi_selected_users']) !!}" class="jsPanels" title="{{ trans('tasks.selecet_user') }}">
                          <span class="icon icon-afzoodane-fard fonts"></span>
                          </a>
                    </i>
                </span>
            </div>
        </div>
        <div class="col-xs-2">
            <div class="input-group">
                {{--<span class="input-group-addon">--}}
                    {{--<span class="fa fa-calendar"></span>--}}
                {{--</span>--}}
                <input type="text" class="DatePickersss form-control col-xs-2" autocomplete="off" placeholder="مهلت..." dir="rtl" id="create_rapid_task_respite_date" name='respite_date'/>
            </div>
        </div>
        <div class="col-xs-5 form-inline" id="create_rapid_task_priority" style="display: none">
            <div class="col-xs-6 center_text_align">
                <label class="radio-inline">
                    {{--<input checked type="radio" name="importance" id="create_rapid_task_importance" value="1"/>--}}
                    <input checked type="radio" name="importance" value="1"/>
                    {{trans('tasks.important')}}
                </label>
                <label class="radio-inline">
                    {{--<input type="radio" name="importance" id="create_rapid_task_importance" value="0"/>--}}
                    <input type="radio" name="importance" value="0"/>
                    {{trans('tasks.non-important')}}
                </label>
                <span style="margin-right: 10px;">|</span>
            </div>

            <div class="col-xs-6 center_text_align" style="padding-right: 0px;padding-left: 0px;">
                <label class="radio-inline" style="padding-right: 10px;">
                    {{--<input checked type="radio" name="immediacy" id="create_rapid_task_immediate" value="1"/>--}}
                    <input checked type="radio" name="immediacy" value="1"/>
                    {{trans('tasks.immediate')}}
                </label>
                <label class="radio-inline">
                    {{--<input type="radio" name="immediacy" id="create_rapid_task_immediate" value="0"/>--}}
                    <input type="radio" name="immediacy" value="0"/>
                    {{trans('tasks.non-immediate')}}
                </label>
            </div>
        </div>
        <div class="col-xs-1 center_text_align">
            <a class="btn btn-primary pull-left" id="{{\Route::currentRouteName()=='hamahang.project.show_project_tasks_list' ? 'create_rapid_task_to_project_btn_submit' : 'create_rapid_task_btn_submit'}}"><i></i>{{trans('app.confirm')}}</a>
        </div>
        <input type="hidden" name="pid" id="pid" value="{{isset($pid) ? enCode($pid): ''}}">
    </form>
    <div class="clearfixed"></div>

</div>
@include('hamahang.Tasks.MyAssignedTask.helper.RapidCreateTask_JS',['function'=>@$function])
<script>
    // $('#create_rapid_task_respite_date').click(function () {
    //     alert('asdasd');
    //     $('.datepicker-plot-area').css('top','70% !important');
    // });
    $("#create_rapid_task_respite_date").click(function(){
        $('.datepicker-plot-area').addClass("datepicker-plot-area_2");
    });
</script>