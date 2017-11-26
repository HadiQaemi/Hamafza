@if($btn_type=='MyAssignedTaskInfo')
    <div class="row">
        <span class="pull-right">
            <h6 id="do_respite"></h6>
        </span>
        <span class="pull-left" style="padding: 10px">
        <button id="NewTaskPackageSubmitBtn" onclick="do_action()" name="upload_files" value="save"
                class="btn btn-primary" type="button">
            <i class="bigger-125"></i>
            <span>ثبت</span>
        </button>
        </span>
    </div>
@elseif($btn_type == 'select_task_window')
    <div class="">

            <button type="button" onclick="add_selected_tasks()" class="btn btn-default pull-left btn-primary">{{ trans('tasks.add') }}</button>

    </div>
@elseif($btn_type=='MyTaskInfo')
    <div class="">
        <button id="NewTaskPackageSubmitBtn" onclick="do_action()" name="AddNewPackage" value="save"
                class="btn btn-primary" type="button">
            <i class="bigger-125"></i>
            <span>ثبت</span>
        </button>
    </div>
@elseif($btn_type == 'CreateNewTask')
    <div>
        <input type="radio" name="new_task_save_type" class="new_task_save_type_draft" value="0"/>
        <label>{{ trans('general.draft') }}</label>
        <input type="radio" name="new_task_save_type" class="new_task_save_type_final" value="1"/>
        <label>{{ trans('general.final') }}</label>
    </div>
    <a data-form_id = "create_new_task" data-again_save = "1" class="btn btn-primary pull-left save_task" id="">
        <i ></i>
        {{trans('tasks.save_and_create_new')}}
    </a>
    <a class="btn btn-primary pull-left save_task" id="save_commit" type="button" data-again_save = "2" data-form_id="create_new_task">
        <i ></i>
        {{trans('tasks.ok')}}
    </a>
@elseif($btn_type == 'NewProcessWindow')
    <div class="col-xs-12">
        <span class="pull-left">
            <input type="radio" id="save_type" name="save_type" value="0"/>
            <label>{{ trans('app.draft') }}</label>
            <input type="radio" id="save_type" name="save_type" value="1" checked />
            <label>{{ trans('app.finally') }}</label>
            <a class="btn btn-primary" onclick="SaveNewProcess(2)">{{ trans('process.submit_and_create_new_process') }}</a>
            <a class="btn btn-primary" onclick="SaveNewProcess(1)">{{ trans('app.confirm') }}</a>
        </span>
    </div>
@elseif($btn_type == 'CreateNewProject')
    <div class="col-xs-12">
        <div class="pull-left">
            <input type="radio" name="save_type" value="11"/>
            <label>پیش نویس</label>
            <input type="radio" name="save_type" value="22" checked />
            <label>نهایی</label>
            <a class="btn btn-primary">تایید و ثبت پروژه جدید</a>
            <a class="btn btn-primary" id="create_new_project" onclick="CheckForm()">تایید</a>
        </div>
    </div>
@endif