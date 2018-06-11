<div class="col-xs-12">
    <div class="col-md-12 " >
        <button class="btn btn-primary pull-left "  id="InsertBtn_task_time">درج</button>
    </div>
    </div>
</div>
<script>
    $('#InsertBtn_task_time').click(function(){
        var droppedOn = $('#droppedOn').val();
        startdate = $('#startdate').val().split('-');
        starttime = $('#starttime').val().split(':');
        enddate = $('#enddate').val().split('-');
        endtime = $('#endtime').val().split(':');
        if(startdate[2]==enddate[2])
        {
            start_block = Math.floor((starttime[0]-1)/2);
            end_block = Math.floor((endtime[0]-1)/2);
//            alert(start_block+'+'+end_block);
            if(start_block==end_block)
            {

            }else{
                j = 1;
                for(i=start_block+1;i<=end_block;i++)
                {
                    $('#'+startdate[2]+'-'+i).remove();
                    j++;
                }
                alert(startdate[2]+'-'+start_block);
                alert(j);
                $('#'+startdate[2]+'-'+start_block).attr('colspan',j);
            }
        }
    });
</script>