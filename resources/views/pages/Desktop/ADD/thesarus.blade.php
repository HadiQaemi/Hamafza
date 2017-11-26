
<div class="panel-body text-decoration">

    <div class='text-content'>
        {{ Form::open(array('url' => 'AddThesaurus')) }}
        <div class="col-md-12">
            <table class="table table-striped">
                <tr>
                    <td class="table-active">
                        نام
                    </td>
                    <td>
                        <input type="text"  required="" class="form-control col-xs-4" name="name" value="{{$name}}">
                    </td>
                </tr>
               
                <tr>
                    <td>

                    </td>
                    <td>
                        @if($id!=0)
                        <input type="hidden"   name="id" value="{{$id}}">
                        <input type="hidden"   name="edit" value="ok">

                        @endif
                        <button type="submit" class="btn btn-primary" name="addasubject">تایید</button>

                    </td>
                </tr>
            </table>
            {{ Form::close() }}
        </div>
    </div>

