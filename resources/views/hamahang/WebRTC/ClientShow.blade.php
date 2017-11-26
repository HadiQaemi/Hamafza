@extends('...layout.front_main')
@section('specific_plugin_styles')
    <link rel="stylesheet" href="{{URL::to('assets/css/header-fixed.css')}}"/>
@stop
@section('body_tag_style')
    style=" background: #394557 url('{{URL::to('assets/css/images/background.jpg')}}') repeat scroll 0 0; height:100%;"
@stop

@section('content')
	<div class="container">
		<div class="row-fluid" >
			<div class="span7" style="position: relative; clear: both">
				<div class="span12 well well-sm">
					<video style="max-height: 450px;" class="span12" id="their-video" autoplay> </video>
					<div class="clearfix"></div>
				</div>
				<video style="border:1px solid #ccc; position: absolute; z-index:100000; bottom: 2px; right: 2px; height: 80px; " id="my-video" muted="true" autoplay></video>
			</div>
			<div class="span5">
				<div class="row-fluid">
					<div class="span12">
						<div id="step1" >
							<p>لطفا برروی "allow" کلیک نمایید تا بتوانیم به میکروفن و دوربین جهت تماس دسترسی پیدا کنیم.</p>
							<div id="step1-error">
								<p>عدم دسترسی به دوربین و میکروفن جهت برقراری تماس</p>
								<a href="#" class="btn btn-yellow btn-small " id="step1-retry"><i class="icon icon-refresh"></i>تلاش دوباره</a>
							</div>
						</div>
						<div id="step2">
							<div class="form-search">
								<input class="input-medium search-query" type="hidden" value="Operator_1" id="callto-id">
								<button id="make-call" class="btn btn-purple btn-block" type="button">
									<i class="icon-phone icon-on-right bigger-110"></i>
									<span>تماس با اپراتور</span>
								</button>
							</div>
						</div>
						<div id="step3">
							<p class="center">  تماس شماهم اکنون با<span id="their-id">...</span> برقرار است.</p>
							<p><button type="button" class="btn btn-danger btn-block" id="end-call">پایان تماس</button></p>
						</div>
					</div>
					<div class="clearfixed"></div>
				</div>
			</div>
			<div class="clearfix clear"></div>
		</div>
		<hr class="hr hr-4"/>
	</div>
@stop
@section('specific_plugin_scripts')
    <script type="text/javascript" src="{{URL::to('assets/WebRTC/dist/peer.js')}}"></script>
@stop
@section('inline_page_scripts')
    <script>
        $(".click_link").click(function() {
            window.location = $(this).find("a").attr("href");
            return false;
        });
    </script>
    <script>

        // Compatibility shim
        navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia;

        // PeerJS object
        //var peer = new Peer({ key: 'lwjd5qra8257b9', debug: 3});
        //'pick-an-id', {key: 'myapikey'}
        var peer = new Peer('Customer_{{$Desk_Number}}',{host: 'atis.site',port:9000, debug: 3,secure:true});
        peer.on('open', function(){
            $('#my-id').text(peer.id);
        });

        // Receiving a call
        peer.on('call', function(call){
            // Answer the call automatically (instead of prompting user) for demo purposes
            call.answer(window.localStream);
            step3(call);
        });
        peer.on('error', function(err){
            alert(err.message);
            // Return to step 2 if error occurs
            step2();
        });

        // Click handlers setup
        $(function(){
            $('#make-call').click(function(){
                // Initiate a call!
                var call = peer.call($('#callto-id').val(), window.localStream);

                step3(call);
            });

            $('#end-call').click(function(){
                window.existingCall.close();
                step2();
            });

            // Retry if getUserMedia fails
            $('#step1-retry').click(function(){
                $('#step1-error').hide();
                step1();
            });

            // Get things started
            step1();
        });

        function step1 () {
            // Get audio/video stream
            navigator.getUserMedia({audio: true, video: true}, function(stream){
                // Set your video displays
                $('#my-video').prop('src', URL.createObjectURL(stream));

                window.localStream = stream;
                step2();
            }, function(){ $('#step1-error').show(); });
        }

        function step2 () {
            $('#step1, #step3').hide();
            $('#step2').show();
        }

        function step3 (call) {
            // Hang up on an existing call if present
            if (window.existingCall) {
                window.existingCall.close();
            }

            // Wait for stream on the call, then set peer video display
            call.on('stream', function(stream){
                $('#their-video').prop('src', URL.createObjectURL(stream));
            });

            // UI stuff
            window.existingCall = call;
            $('#their-id').text(call.peer);
            call.on('close', step2);
            $('#step1, #step2').hide();
            $('#step3').show();
        }

    </script>

@stop

@section('class_page_footer')
    food_page
@stop

@section('class_page_header')
    food_page
@stop