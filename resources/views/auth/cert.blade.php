@extends('layouts.master')
@section('title')
商家认证 - @parent
@endsection
@section('content')
    <link rel="stylesheet" href="/css/jquery.fileupload.css">
<div class="page-cert">
    <div class="container">
        <div class="row text-center"><h3>请先进行认证</h3></div>
        <div class="row">
<div class="form-horizontal" role="form">
                <div class="form-group control-group">
                    <label class="col-xs-4 control-label">身份证正面</label>
                    <div class="col-xs-6">
                        <blockquote>
                        @if(isset($cert->identity_card_front) && $cert->identity_card_front != '')
                            <img src="certImg/{{Auth::user()->id}}/icf">
                            <small>等待审核</small>
                        @else
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
                        @endif
                            </blockquote>
                    </div>
                </div>
                <div class="form-group control-group">
                    <label class="col-xs-4 control-label">身份证背面</label>
                    <div class="col-xs-6">
                        @if(isset($cert->identity_card_back) && $cert->identity_card_back != '')
                            <img src="certImg/{{Auth::user()->id}}/icb">
                            <small>等待审核</small>
                        @else
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
                        @endif
                    </div>
                </div>
                <div class="form-group control-group">
                    <label class="col-xs-4 control-label">营业执照</label>
                    <div class="col-xs-6">
                        @if(isset($cert->business_license) && $cert->business_license != '')
                            <img src="certImg/{{Auth::user()->id}}/bl">
                            <small>等待审核</small>
                        @else
                        <span class="btn btn-success fileinput-button">
                            <i class="glyphicon glyphicon-plus"></i>
                            <span>选择文件</span>
                            <!-- The file input field used as target for the file upload widget -->
                            <input id="fileupload_business_license" type="file" name="business_license">
                        </span>
                        <br>
                        <br>
                        <!-- The container for the uploaded files -->
                        <div id="file-business_license" class="files"></div>
                        <br>
                        @endif
                    </div>
                </div>

                <!-- The global progress bar -->
                <div id="progress" class="progress">
                    <div class="progress-bar progress-bar-success"></div>
                </div>
                <br>
                <div class="form-group">
                    <div class="col-xs-6 col-xs-offset-4">
                        <a href="/" class="btn btn-primary">以后再说</a>
                    </div>
                </div>
</div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="/js/vendor/jquery.ui.widget.js"></script>
<script src="http://blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js"></script>
<script src="http://blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js"></script>
<script src="/js/jquery.iframe-transport.js"></script>
<script src="/js/jquery.fileupload.js"></script>
<!-- The File Upload processing plugin -->
<script src="/js/jquery.fileupload-process.js"></script>
<!-- The File Upload image preview & resize plugin -->
<script src="/js/jquery.fileupload-image.js"></script>
<script>
    /*jslint unparam: true, regexp: true */
    /*global window, $ */
    $(function () {
        'use strict';
        // Change this to the location of your server-side upload handler:
        var url = '/auth/cert';
                /*uploadButton = $('<button/>')
                        .addClass('btn btn-primary')
                        .prop('disabled', true)
                        .text('上传中...')
                        .on('click', function () {
                            var $this = $(this),
                                    data = $this.data();
                            $this
                                    .off('click')
                                    .text('Abort')
                                    .on('click', function () {
                                        $this.remove();
                                        data.abort();
                                    });
                            data.submit().always(function () {
                                $this.remove();
                            });
                        });*/
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