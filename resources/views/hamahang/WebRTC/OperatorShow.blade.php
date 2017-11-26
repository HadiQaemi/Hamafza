@extends('layouts.master')
@section('specific_plugin_style')
    <link rel="stylesheet" href="{{URL::to('assets/Packages/WebRTC/dist/styl1e.css')}}"/>
@stop
@section('content')
    <div class="row-fluid">
        <div class="col-xs-7" style="position: relative;">
            <div class="widget-box light-border" style="opacity: 1;">
                <div class="widget-header header-color-pink">
                    <h5 class="smaller">
                        <span>نام کاربری شما :</span>
                        <span id="my-id">...</span>
                    </h5>
                    <div class="widget-toolbar" style="min-width: 220px;">
						<span>
							<label>
								<input id="video_call" name="switch_call" type="radio" value="video_call">
								<span class="lbl">
									<i class="fa fa-video-camera"></i> |
									<i class="fa fa-microphone"></i>
									<span> صدا و تصویر</span>
								</span>
							</label>
						</span>
                        <span>    |    </span>
                        <span>
							<label>
								<input id="audio_call" name="switch_call" type="radio" value="audio_call">
								<span class="lbl">
									<i class="fa fa-microphone"></i>
									<span> فقط صدا</span>
								</span>
							</label>
						</span>
                    </div>
                </div>
                <div class="widget-body">
                    <div class="widget-main padding-6">
                        <div class="col-xs-12 well well-sm">
                            <video class="col-xs-12" id="their-video" autoplay></video>
                            <div class="clearfix"></div>
                        </div>
                        <video style="border:1px solid #ccc; position: absolute; z-index:100000; bottom: 2px; right: 2px; height: 120px; "
                               id="my-video" muted="true" autoplay></video>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-5">
            <div class="row-fluid">
                <div class="col-xs-12">
                    <div id="incoming_call" class="col-xs-12 widget-container-span ui-sortable" style="display: none;">
                        <div class="widget-box light-border" style="opacity: 1;">
                            <div class="widget-header header-color-dark">
                                <h5 class="smaller">
                                    <span class="fa fa-phone fa-2x fa-animated-bell"></span>
                                    <span>درخواست تماس :</span>
                                </h5>
                                <div class="widget-toolbar">
                                    <a id="accept_call" class=" badge badge-success" style="padding: 3px;">
                                        <i class="fa fa-phone"></i>
                                        <strong>پاسخ</strong>
                                    </a>
                                    <a id="reject_call" class="badge badge-important " style="padding: 3px;">
                                        <i class="fa fa-remove"></i>
                                        <strong>قطع</strong>
                                    </a>
                                </div>
                            </div>
                            <div class="widget-body">
                                <div class="widget-main padding-6">
                                    <div class="alert alert-info center">
                                        <span>درخواست تماس دارید...</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row-fluid">
                <div class="col-xs-12">
                    <div class="col-xs-12 widget-container-span ui-sortable">
                        <div class="widget-box light-border" style="opacity: 1;">
                            <div class="widget-header header-color-green2">
                                <h5 class="smaller">
                                    <span class="fa fa-phone-sign fa-2x"></span>
                                    <span>برقراری تماس :</span>
                                </h5>
                                <div class="widget-toolbar"></div>
                            </div>
                            <div class="widget-body">
                                <div class="widget-main padding-6">
                                    <div class="alert alert-success  center">
                                        <div class="row-fluid">
                                            <div id="step1">
                                                <p>لطفا برروی "allow" کلیک نمایید تا بتوانیم به میکروفن و دوربین جهت تماس دسترسی پیدا
                                                    کنیم.</p>

                                                <div id="step1-error">
                                                    <p>عدم دسترسی به دوربین و میکروفن جهت برقراری تماس</p>
                                                    <a href="#" class="btn btn-yellow btn-small " id="step1-retry">
                                                        <i class="fa fa-refresh"></i>
                                                        <span>تلاش دوباره</span>
                                                    </a>
                                                </div>
                                            </div>
                                            <div id="step2">
                                                <div class="form-search">
                                                    <input class="input-medium search-query" type="text" placeholder="شناسه کاربری ..."
                                                           id="callto-id">
                                                    <button id="make-call" class="btn btn-purple btn-small" type="button">
                                                        <i class="fa fa-phone fa fa-on-right bigger-110"></i>
                                                        <span>تماس</span>
                                                    </button>
                                                </div>
                                            </div>
                                            <div id="step3">
                                                <p>
                                                    <span>هم اکنون تماس شما با </span>
                                                    <span id="their-id">...</span>
                                                    <span> برقرار است.</span>
                                                </p>
                                                <p>
                                                    <button type="button" class="btn btn-danger btn-block" id="end-call">پایان تماس</button>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <hr class="hr hr-4"/>
@stop
@section('specific_plugin_scripts')
    <script type="text/javascript" src="{{URL::to('assets/Packages/WebRTC/dist/peer.js')}}"></script>
    <script type="text/javascript">
        // Compatibility shim
        navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia;
        // PeerJS object
        //var peer = new Peer({ key: 'lwjd5qra8257b9', debug: 3});
        //'pick-an-id', {key: 'myapikey'}
        var peer = new Peer('Operator_{{$Operator_ID}}', {host: 'atis.site', port: 9000, debug: 3, secure: true});
        peer.on('open', function () {
            $('#my-id').text(peer.id);
        });
        // Receiving a call
        peer.on('call', function (call) {
            // Answer the call automatically (instead of prompting user) for demo purposes
            //call.answer(window.localStream);
            //step3(call);
            $('#incoming_call').show();
            var audio = new Audio('{{URL::to('assets/Packages/WebRTC/RingTones/new_ring_tone.mp3')}}');
            audio.loop = true;
            audio.play();
            var not_cliked = true;
            setTimeout(function () {
                if (not_cliked) {
                    $("#reject_call").click();
                }
            }, 10000);
            $("#accept_call").click(function () {
                not_cliked = false;
                call.answer(window.localStream);
                step3(call);
                audio.pause();
                $('#incoming_call').hide();
            });
            $("#reject_call").click(function () {
                not_cliked = false;
                window.call = call.answer();
                setTimeout(function () {
                    call.close();
                }, 100);
                audio.pause();
                $('#incoming_call').hide();
            });
        });
        peer.on('error', function (err) {
            alert(err.message);
            // Return to step 2 if error occurs
            step2();
        });
        // Click handlers setup
        $(function () {
            $('#make-call').click(function () {
                // Initiate a call!
                var call = peer.call($('#callto-id').val(), window.localStream);

                step3(call);
            });
            $('#end-call').click(function () {
                window.existingCall.close();
                step2();
            });
            // Retry if getUserMedia fails
            $('#step1-retry').click(function () {
                $('#step1-error').hide();
                step1({
                    audio: true,
                    video: true
                });
            });
            $("#video_call").on('click', function () {
                $('#step1-error').hide();
                step1({
                    audio: true,
                    video: true
                });
            });
            $("#audio_call").on('click', function () {
                $('#step1-error').hide();
                step1({
                    audio: true,
                    video: false
                });
            });
        });
        function step1(gUMOptions) {
            // Get audio/video stream
            navigator.getUserMedia(gUMOptions, function (stream) {
                // Set your video displays
                $('#my-video').prop('src', URL.createObjectURL(stream));

                window.localStream = stream;
                step2();
            }, function () {
                $('#step1-error').show();
            });
        }
        function step2() {
            $('#step1, #step3').hide();
            $('#step2').show();
        }
        function step3(call) {
            // Hang up on an existing call if present
            if (window.existingCall) {
                window.existingCall.close();
            }

            // Wait for stream on the call, then set peer video display
            call.on('stream', function (stream) {
                $('#their-video').prop('src', URL.createObjectURL(stream));
            });

            // UI stuff
            window.existingCall = call;
            $('#their-id').text(call.peer);
            call.on('close', step2);
            $('#step1, #step2').hide();
            $('#step3').show();
        }
        setTimeout(function () {
            $("#video_call").click();
        }, 2000);
    </script>
@stop

@include('sections.tabs')
@section('position_right_col_3')
    @include('sections.desktop_menu')
@stop