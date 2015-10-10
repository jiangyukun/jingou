@extends('admin.master')
@section('title')
    用户管理 @parent
@endsection
@section('content')
<div class="col-xs-12">
    <div class="panel panel-default">
        <div class="panel-heading">编辑用户</div>
        <!-- /.panel-heading -->
        <div class="panel-body">

        <div class="row setting">

            @if (count($user))
                <form class="form-horizontal" role="form" method="POST" action="/admin/user/{{$user->id}}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <div class="col-xs-2 text-right">用户名：</div>
                        <div class="col-xs-5">
                            <input type="text" class="form-control" name="username" value="{{ $user->username }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-2 text-right">手机号：</div>
                        <div class="col-xs-5">
                            <input type="text" class="form-control" name="mobile" value="{{ $user->mobile }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-2 text-right">密码：</div>
                        <div class="col-xs-3">
                            <input type="text" class="form-control" name="password" value="">
                        </div>
                        <div class="col-xs-3">不修改请留空</div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-2 text-right">上次登陆日期：</div>
                        <div class="col-xs-5">
                            <p> {{ $user->last_time }}</p>
                        </div>
                    </div>


                    @if(count($cert)>0)
                    <fieldset>
                        <legend>商家详细信息</legend>


                        <div class="form-horizontal" role="form">
                            <div class="form-group control-group">
                                <label class="col-xs-2  control-label">身份证正面</label>
                                <div class="col-xs-6">

                                   @if(isset($cert->identity_card_front) && $cert->identity_card_front != '')
                                        <img src="/auth/certImg/{{$user->id}}/icf" width="400px">
                                    @endif
                                        <!-- The fileinput-button span is used to style the file input field as button -->
                        <span class="btn btn-success fileinput-button">
                            <i class="glyphicon glyphicon-plus"></i>
                            <span>选择文件</span>
                            <!-- The file input field used as target for the file upload widget -->
                            <input id="fileupload_identity_card_front" type="file" name="identity_card_front">
                        </span>
                                        <br>
                                        <br>
                                        <!-- The container for the uploaded files -->
                                        <div id="file-identity_card_front" class="files"></div>
                                        <br>


                                </div>
                            </div>
                            <div class="form-group control-group">
                                <label class="col-xs-2  control-label">身份证背面</label>
                                <div class="col-xs-6">
                                    @if(isset($cert->identity_card_back) && $cert->identity_card_back != '')
                                    <img src="/auth/certImg/{{$user->id}}/icb" width="400px">
                                    @endif
                        <span class="btn btn-success fileinput-button">
                            <i class="glyphicon glyphicon-plus"></i>
                            <span>选择文件</span>
                            <!-- The file input field used as target for the file upload widget -->
                            <input id="fileupload_identity_card_back" type="file" name="identity_card_back">
                        </span>
                                    <br>
                                    <br>
                                    <!-- The container for the uploaded files -->
                                    <div id="file-identity_card_back" class="files"></div>
                                    <br>

                                </div>
                            </div>
                            <div class="form-group control-group">
                                <label class="col-xs-2  control-label">营业执照</label>
                                <div class="col-xs-6">
                                    @if(isset($cert->business_license) && $cert->business_license != '')
                                        <img src="/auth/certImg/{{$user->id}}/bl" width="400px">
                                    @endif

                        <span class="btn btn-success fileinput-button">
                            <i class="glyphicon glyphicon-plus"></i>
                            <span>选择文件</span>
                            <!-- The file input field used as target for the file upload widget -->
                            <input id="fileupload_business_license" type="file" name="business_license">
                        </span>
                                    <br><br><div id="file-business_license" class="files"></div> <br>

                                </div>
                            </div>

                            <!-- The global progress bar -->
                            <div id="progress" class="progress"> <div class="progress-bar progress-bar-success"></div> </div>
                        </div>




                    </fieldset>
                    @endif





                    <div class="form-group">
                        <div class="col-xs-5 col-xs-offset-4">
                            <button type="submit" class="btn btn-primary">{{Lang::get('layout.Submit')}}</button>
                        </div>
                    </div>
                </form>
            @else
                <h1>用户不存在。</h1>
            @endif
        </div>
  </div>
    </div>
</div>
@endsection

@section('script')
<link rel="stylesheet" href="/css/style.css">
<script src="http://cdn.staticfile.org/jquery/1.11.1-rc2/jquery.min.js"></script>
<!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
<script src="http://cdn.staticfile.org/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
<script src="http://blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js"></script>



<script src="/js/vendor/jquery.ui.widget.js"></script>
<script src="/js/jquery.iframe-transport.js"></script>
<script src="/js/jquery.fileupload.js"></script>

<!-- The File Upload processing plugin -->
<script src="/js/jquery.fileupload-process.js"></script>
<!-- The File Upload image preview & resize plugin -->
<script src="/js/jquery.fileupload-image.js"></script>
<script>
    $(function () {
        'use strict';
        // Change this to the location of your server-side upload handler:
        var url = '/admin/cert/{{$user->id}}';
        $('#fileupload_identity_card_front').fileupload({
            url: url,
            dataType: 'json',

            autoUpload: true,
            acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
            maxFileSize: 999000,
            // Enable image resizing, except for Android and Opera,
            // which actually support image resizing, but fail to
            // send Blob objects via XHR requests:
            disableImageResize: /Android(?!.*Chrome)|Opera/
                .test(window.navigator.userAgent),
            previewMaxWidth: 100,
            previewMaxHeight: 100,
            previewCrop: true,
            singleFileUploads: true
        }).on('fileuploadadd', function (e, data) {
            data.context = $('<div/>').appendTo('#file-identity_card_front');
            $.each(data.files, function (index, file) {
                var node = $('<p/>')
                    .append($('<span/>').text(file.name));
                if (!index) {
                    //node
                    //.append('<br>')
                    //.append(uploadButton.clone(true).data(data));
                }
                node.appendTo(data.context);
            });
        }).on('fileuploadprogressall', function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .progress-bar').css(
                'width',
                progress + '%'
            );
        }).on('fileuploaddone', function (e, data) {
            if (data.result.msg) {
                var msg = $('<span class="text-success"/>').text(data.result.msg);
                $(data.context.children()[0])
                    .append('<br>')
                    .wrap(msg);
            } else if (data.result.error) {
                var error = $('<span class="text-danger"/>').text(data.result.error);
                $(data.context.children()[0])
                    .append('<br>')
                    .append(error);
            }
        }).on('fileuploadfail', function (e, data) {
            $.each(data.files, function (index) {
                var error = $('<span class="text-danger"/>').text('File upload failed.');
                $(data.context.children()[index])
                    .append('<br>')
                    .append(error);
            });
        }).prop('disabled', !$.support.fileInput)
            .parent().addClass($.support.fileInput ? undefined : 'disabled');


        $('#fileupload_identity_card_back').fileupload({
            url: url,
            dataType: 'json',

            autoUpload: true,
            acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
            maxFileSize: 999000,
            // Enable image resizing, except for Android and Opera,
            // which actually support image resizing, but fail to
            // send Blob objects via XHR requests:
            disableImageResize: /Android(?!.*Chrome)|Opera/
                .test(window.navigator.userAgent),
            previewMaxWidth: 100,
            previewMaxHeight: 100,
            previewCrop: true,
            singleFileUploads: true
        }).on('fileuploadadd', function (e, data) {
            data.context = $('<div/>').appendTo('#file-identity_card_back');
            $.each(data.files, function (index, file) {
                var node = $('<p/>')
                    .append($('<span/>').text(file.name));
                if (!index) {
                    //node
                    //.append('<br>')
                    //.append(uploadButton.clone(true).data(data));
                }
                node.appendTo(data.context);
            });
        }).on('fileuploadprogressall', function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .progress-bar').css(
                'width',
                progress + '%'
            );
        }).on('fileuploaddone', function (e, data) {
            if (data.result.msg) {
                var msg = $('<span class="text-success"/>').text(data.result.msg);
                $(data.context.children()[0])
                    .append('<br>')
                    .wrap(msg);
            } else if (data.result.error) {
                var error = $('<span class="text-danger"/>').text(data.result.error);
                $(data.context.children()[0])
                    .append('<br>')
                    .append(error);
            }
        }).on('fileuploadfail', function (e, data) {
            $.each(data.files, function (index) {
                var error = $('<span class="text-danger"/>').text('File upload failed.');
                $(data.context.children()[index])
                    .append('<br>')
                    .append(error);
            });
        }).prop('disabled', !$.support.fileInput)
            .parent().addClass($.support.fileInput ? undefined : 'disabled');


        $('#fileupload_business_license').fileupload({
            url: url,
            dataType: 'json',

            autoUpload: true,
            acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
            maxFileSize: 999000,
            // Enable image resizing, except for Android and Opera,
            // which actually support image resizing, but fail to
            // send Blob objects via XHR requests:
            disableImageResize: /Android(?!.*Chrome)|Opera/
                .test(window.navigator.userAgent),
            previewMaxWidth: 100,
            previewMaxHeight: 100,
            previewCrop: true,
            singleFileUploads: true
        }).on('fileuploadadd', function (e, data) {
            data.context = $('<div/>').appendTo('#file-business_license');
            $.each(data.files, function (index, file) {
                var node = $('<p/>')
                    .append($('<span/>').text(file.name));
                if (!index) {
                    //node
                    //.append('<br>')
                    //.append(uploadButton.clone(true).data(data));
                }
                node.appendTo(data.context);
            });
        }).on('fileuploadprogressall', function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .progress-bar').css(
                'width',
                progress + '%'
            );
        }).on('fileuploaddone', function (e, data) {
            if (data.result.msg) {
                var msg = $('<span class="text-success"/>').text(data.result.msg);
                $(data.context.children()[0])
                    .append('<br>')
                    .wrap(msg);
            } else if (data.result.error) {
                var error = $('<span class="text-danger"/>').text(data.result.error);
                $(data.context.children()[0])
                    .append('<br>')
                    .append(error);
            }
        }).on('fileuploadfail', function (e, data) {
            $.each(data.files, function (index) {
                var error = $('<span class="text-danger"/>').text('File upload failed.');
                $(data.context.children()[index])
                    .append('<br>')
                    .append(error);
            });
        }).prop('disabled', !$.support.fileInput)
            .parent().addClass($.support.fileInput ? undefined : 'disabled');
    });
</script>
@endsection