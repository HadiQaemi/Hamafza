<script>
    loading = function(selector,state){
        var img = "<div id='DivLoading'  style='z-index: 99999;position: absolute;left: 0 ; top: 0;text-align: center;display: none; ;width: 100%;height: 100%;background-color: rgba(0,0,0,0.1);margin: auto;'><span class='fa fa-spin' style='position: absolute;top: 45%;left: 46.5%;color: cornflowerblue'><i class='fa fa-spinner fa-5x fa-fw fa-pulse'></i></span></div>";
        if(selector.class)
        {
            $('.'+selector.class).html('');
            $('.'+selector.class).append(img);
        }else if(selector.id){
            $('.'+selector.class).html('');
            $('#'+selector.id).append(img) ;
        }
        if(parseInt(state) == 1)
        {
            $('#DivLoading').show();
        } else if(parseInt(state)==0){
            $('#DivLoading').hide();
        }
    };
</script>
