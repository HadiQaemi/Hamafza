<form method="post" action="" enctype="multipart/form-data">
    <input type="file" class="data_file" id="data_file" name="data_file" />
    <input type="submit" name="encode" value="Encode" /><br />
    <textarea class="content" id="content" name="content" rows="20" cols="100">{!! $encoded_data !!}</textarea><br />
    <br />
    <input type="submit" name="decode" value="Decode" /><br />
    <br />
    @if ($decoded_data)
        <a href="file://{!! $decoded_data !!}">Download</a>
    @endif
    <input type="hidden" name="_token" value="{!! csrf_token() !!}" />
</form>