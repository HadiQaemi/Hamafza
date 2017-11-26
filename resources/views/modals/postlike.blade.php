<link rel="stylesheet" type="text/css" href="{{App::make('url')->to('/')}}/theme/bootstrap/css/bootstrap.min.css"/>
<link rel="stylesheet" type="text/css" href="{{App::make('url')->to('/')}}/theme/Content/css/bootstrap-rtl.min.css"/>
<link rel="stylesheet" type="text/css" href="{{App::make('url')->to('/')}}/theme/Content/css/style.css"/>
<link rel="stylesheet" type="text/css" href="{{App::make('url')->to('/')}}/theme/Content/css/public.css"/>
<link rel="stylesheet" type="text/css" href="{{App::make('url')->to('/')}}/theme/Content/css/social.css"/>
<script src="{{App::make('url')->to('/')}}/theme/Scripts/jquery.notice.js"></script>

<style>
    #SelectedDiv #SelectedUsers{
         height: 370px;
         /*overflow: auto;*/
}
.person-list .person-circle.grey {
    background: #ececec none repeat scroll 0 0;
}
.person-list .person-circle.green {
    background: #32b38c none repeat scroll 0 0;
    color: #fff;
}
    .person-list li {
        background: #fff none repeat scroll 0 0;
        border: 1px solid #dbdbdb;
        box-shadow: 0 4px 7px rgba(162, 162, 162, 0.54);
        float: right;
        height: 100px!important;
        margin: 5px!important;
        padding: 0;
        position: relative;
        width: 48%!important;
    }
    .person-list li .person-detail{
        padding: 13px 10px 0px 5px!important;
    }
   
    .col-md-9 .person-list .person-moredetail {
    font-size: 11px;
    line-height: 17px;
    height: 55px;
    overflow: auto;
}
    #SelectedDiv{
        position: relative;
        height: 400px;
       
    }
    #InsertBut{
    height: 30px
    }
</style>
<div class="col-md-9 ">
    
    {{$H}}

</div>