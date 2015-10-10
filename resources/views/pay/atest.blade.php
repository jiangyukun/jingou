@extends('layouts.master')
@section('title')

@stop
@section('script')
<script type="text/javascript">
    //将form转为AJAX提交
    function ajaxSubmit(frm, fn) {
        var dataPara = getFormJson(frm);
        var url=frm.action;
        $.ajax({
            url: url,
            type: frm.method,
            data: dataPara,
            success: fn
        });
    }

    //将form中的值转换为键值对。
    function getFormJson(frm) {
        var o = {};
        var a = $(frm).serializeArray();
        $.each(a, function () {
            if (o[this.name] !== undefined) {
                if (!o[this.name].push) {
                    o[this.name] = [o[this.name]];
                }
                o[this.name].push(this.value || '');
            } else {
                o[this.name] = this.value || '';
            }
        });

        return o;
    }

    //调用
    $(document).ready(function(){
        /* $('#Form1').bind('button', function(){
         ajaxSubmit(this, function(data){
         alert(data);
         });
         return false;
         });
         */
        $("#mybutton").bind("click",function(){
            ajaxSubmit( $('#Form1')[0], function(data){
                alert(data);
            });
        });

    });
</script>

@endsection
@section('content')


<form id="Form1" action="/pay/action" method="post" >
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    名称：<input name="name" type="text" /><br />
    密码：<input name="password" type="password" /><br />
    手机：<input name="mobile" type="text" /><br />
    说明：<input name="memo" type="text" /><br />
    <input type="button" id="mybutton" value="提 交" />
</form>

<form id="Form2" action="/pay/action1" method="get" >
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    名称：<input name="name" type="text" /><br />
    密码：<input name="password" type="password" /><br />
    手机：<input name="mobile" type="text" /><br />
    说明：<input name="memo" type="text" /><br />
    <input type="submit" value="提 交" />
</form>
@stop