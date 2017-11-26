@include('modals.modalheader')

<style>
    body
    {
        background-color: white;
    }
</style>

@if (is_array($forms) )
<div class="panel panel-light fix-box1" style="padding: 20px;">
    <div class="panel-body text-decoration">
        <select class="inputbox form-control" name="forms" id="forms">
            @foreach($forms as $item)

            <option value="{{$item->id}}">{{$item->title}}</option>
            @endforeach

        </select>

        <br>

        <select class="inputbox form-control" name="sel" id="sel" >
            <option value="1">درون صفحه</option>
            <option value="2">پنجره</option>
        </select>


        <br>
        <div id="textdiv" class="panel-body text-decoration" style="display: none;">
            عبارت نمایشی:
            <input class="inputbox form-control" type="text" name="showtext" id="showtext">
        </div>

        <script>
            $(document).ready(function()
            {
                $("#sel").change(function() {
                    var end = this.value;
                    if(end==1)
                       $("#textdiv").hide();
                   else
                                              $("#textdiv").show();

                });

            });
        </script>
    </div>
</div>
@endif