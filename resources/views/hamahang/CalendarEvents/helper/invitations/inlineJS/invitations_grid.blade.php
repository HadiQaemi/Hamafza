<script>
    $(document).ready(function() {


        $('#invitationGrid').DataTable({
            "dom": window.CommonDom_DataTables,
            "language": LangJson_DataTables,
            processing: true,
            serverSide: true,
            ajax: {
                url: '{!! route('hamahang.calendar_events.fetch_invitation')!!}',
                type : 'POST'
            },
            columns: [
                {
                    data: 'rowIndex',
                    name: 'rowIndex' ,
                    width :'1%'


                },
                {   data: 'about',
                    name: 'about' ,
                    width : '24%',
                    mRender :function(data, type, full)
                    {
                        if(data.length > 8)
                        {
                            return data.slice(0,8)+'...';
                        }
                        else
                        {
                            return data;
                        }
                    }
                },
                {
                    data: 'startdate',
                    name: 'startdate',
                    width : '20%',
                    mRender :function(data, type, full)
                    {
                        var startdate = data.split(' ');
                        console.log(startdate[1]);
                        if(startdate[1]=='00:00:00')
                        {
                            startdate[1] ='------';
                        }
                        return  '<table class=col-xs-12"><tr>' +
                                '<td class="col-xs-1 fa fa-calendar"></td>'+
                                '<td class="col-xs-5"> <spane>'+startdate[0]+'</span></td>'+
                                '<td class="col-xs-1 glyphicon glyphicon-time"> </td> ' +
                                '<td class="col-xs-5"> <span> '+startdate[1]+'</span></td>'+
                                '</tr></table>';
                    }
                },
                {
                    data: 'enddate',
                    name: 'enddate',
                    width : '20%',
                    mRender :function(data, type, full)
                    {
                        var enddate = data.split(' ');
                        if(enddate[1]=='00:00:00')
                        {
                            enddate[1] ='------';
                        }
                        return  '<table class=col-xs-12"><tr>' +
                                 '<td class="col-xs-1 fa fa-calendar"></td>'+
                                '<td class="col-xs-5"> <spane>'+enddate[0]+'</span></td>'+
                                 '<td class="col-xs-1 glyphicon glyphicon-time"> </td> ' +
                                '<td class="col-xs-5"><span> '+enddate[1]+'</span></td>'+
                                '</tr></table>';;
                    }
                },
                {
                    data: 'title',
                    name: 'title',
                    width : '25%',
                    mRender :function(data, type, full)
                    {
                        if(data.length > 8)
                        {
                            return data.slice(0,8)+'...';
                        }
                        else
                        {
                            return data;
                        }
                    }

                },
                { data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    width : '10%',
                    mRender :function (data, type, full)
                    {

                         var actions ='<a class="cls3"   alt='+'{{trans('calendar_events.ce_edit_label')}}'+' title='+'{{trans('calendar_events.ce_edit_label')}}'+'  style="margin: 2px" onclick="editEvent('+full.id+','+2+')" href="#"><i class="fa fa-edit"></i></a>'+
                                '<a class="cls3"  alt='+'{{trans('calendar_events.ce_delete_label')}}'+' title='+'{{trans('calendar_events.ce_delete_label')}}'+' style="margin: 2px" onclick="deleteّinvitattionEvent('+full.id+')" href="#"><i class="fa fa-close"></i></a>';

                                return actions;





                    }

                }

            ]
        });

    });
</script>