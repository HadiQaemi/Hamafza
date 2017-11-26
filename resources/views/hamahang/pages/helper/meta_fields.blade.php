<table>
    @foreach ($meta_fields as $field)
        <tr>
            <td>{!! $field->name !!}:</td>
            <td><input class="form-control" type="text" name="meta_fields[{!! $field->id !!}]" value="{!! $field->field_value !!}" /></td>
        </tr>
    @endforeach
</table>
