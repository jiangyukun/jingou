@extends('admin.master')
@section('title')
竞购管理 @parent
@endsection
@section('content')



<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">

            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="row">
                            <div class="col-lg-12"><h3 class="page-header">竞购详细信息</h3></div>
                            <!-- /.col-lg-12 -->
                        </div>

                        <form role="form" id="Form1" action="/admin/sdemand/{{$demand->id}}"  method="post">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group">
                                <label>竞购标题</label>
                                <input class="form-control" name="title" value="{{$demand->title}}">
                            </div>

                            <div class="form-group">
                                <label>商品地址</label>
                                <input class="form-control" name="url" value="{{$demand->url}}">
                            </div>

                            <div class="form-group">
                                <label>商品图片</label>
                                <img  src="/{{$demand->thumb}}" width="200" height="200" />
                            </div>
                            <div class="form-group">
                                <label>商品分类</label>
                                <select class="form-control" name="category_id"  onchange="load_brand(this.value);" >
                                    <option value="-1">请选择</option>
                                    <? echo $catetree; ?>
                                </select>
                            </div>

                            <div class="form-group"><label>品牌</label>
                                <select class="form-control"  id="catbrand"  name="bid" onchange="loadArea(this.value,'second')">
                                    <option value="0">请选择</option>
                                    @foreach ($brands as $brand)
                                    <option value="{{$brand->id}}"  @if($brand->id==$demand->bid) selected @endif   >{{$brand->bname}}</option>
                                    @endforeach

                                </select>

                            </div>
                            <div class="form-group"><label>型号</label> <input class="form-control" name="model" value="{{$demand->model}}"></div>
                            <div class="form-group"><label>用户名</label>
                                <input class="form-control" placeholder="Enter text" name="username" value="{{$user->username}}">
                            </div>

                           <div class="form-group"><label>发布时间</label>
                                <input class="form-control" name="created_at" value="{{$demand->created_at}}">
                            </div>
                           <div class="form-group"><label>结束时间</label>
                                <input class="form-control"
                                       value="<?
                                       $ctime = strtotime($demand->created_at);
                                       if ($demand->paytime)
                                           $ctime = strtotime($demand->paytime); //从支付时间算起

                                       //echo $demand->avltime;
                                       //echo strtotime("+ ".$demand->avlitime." hours",$ctime);

                                        echo  date("Y-m-d H:i:s", strtotime("+ ".$demand->avltime." hours",$ctime)); ?>">
                            </div>
                            <div class="form-group"><label>新结束时间</label>
                                <input class="form-control"  name="expire_time"  value="{{$demand->expire_time}}">
                            </div>
                            <div class="form-group"><label>发布IP</label>
                                <input class="form-control"     value="{{ $demand->ip }}" disabled>
                            </div>
                            <div class="form-group">

                                <label class="radio-inline"> <input type="checkbox"   name="is_hot" @if($demand->is_hot) checked @endif   value="1">热点</label>
                                <label class="radio-inline"><input type="checkbox"  name="is_top"  @if($demand->is_top) checked @endif   value="1">置顶</label>
                                <label class="radio-inline"> <input type="checkbox"   name="is_recommend"  @if($demand->is_recommend) checked @endif   value="1">推荐</label>
                            </div>

                            <div class="form-group"><label>定金金额</label>
                                <input class="form-control" name="deposit" value="{{$demand->deposit}}">
                            </div>
                            <div class="form-group"><label>浏览次数</label>
                                <input class="form-control" name="view_count" value="{{$demand->view_count}}">
                            </div>
                            <div class="form-group"><label>兑价时间</label>
                                <input class="form-control" name="avltime" value="{{$demand->avltime}}">
                            </div>
                            <div class="form-group"><label>定金状态</label>
                                <select class="form-control">
                                    <option value="0">请选择</option>
                                    <option value="0" <? if($demand->status==0) echo "selected";?> >未收</option>
                                    <option value="1" <? if($demand->status>0) echo "selected";?> >已收</option>
                                    <option value="-10"  <? if($demand->status==-8) echo "selected";?>>已退</option>
                                    <option value="-11"  <? if($demand->status==-9) echo "selected";?>>未退</option>
                                </select>
                            </div>

                    <!---   <div class="form-group"><label>汇款账户</label>
                                <input class="form-control"   value="">
                            </div>
                            -->

                            <div class="form-group"><label>货款金额</label>
                                <input class="form-control" name="price"   value="{{$demand->price}}">
                            </div>
                            <div class="form-group"><label>竞价状态</label>
                                <select class="form-control">
                                    <option value="2" @if($demand->is_pay<=1) selected @endif >未收定金</option>
                                    <option value="2" @if($demand->is_pay>=2) selected @endif >已收定金</option>
                                    <option value="2" @if($demand->is_pay>=2) selected @endif >竞价中</option>
                                    <option value="2" @if($demand->is_pay>=2) selected @endif >已选标</option>
                                </select>
                            </div>

                            <div class="form-group"><label>汇款账户</label>
                                <input class="form-control"   value="{{$user->alipay}}" disabled>
                            </div>


                            <div class="form-group"><label>时间状态</label>
                                <select class="form-control">
                                    <option value="0"  @if(strtotime($demand->expire_time)>=strtotime('now')) selected @endif >进行中</option>
                                    <option value="">延时中</option>
                                    <option value="4" @if(strtotime($demand->expire_time)<strtotime('now')) selected @endif>已结束</option>
                                </select>
                            </div>



                            <button type="submit"  id="mybutton1" class="btn btn-success">保存</button>
                            <button  type="button" onclick="history.back();" class="btn btn-default">返回</button>
                        </form>

                    </div>
                    <!-- /.col-lg-6 (nested) -->
                    <div class="col-lg-4">
                        <div class="row">
                            <div class="col-lg-12"><h3 class="page-header">全部竞价</h3></div>
                            <!-- /.col-lg-12 -->
                        </div>

                        <div class="col-lg-12">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                <tr><th>用户</th><th>价格</th><th>时间</th><th>链接</th><th>中标</th></tr>
                                </thead>
                                <tbody>

                                @foreach ($bids as $bid)
                                <tr  class=" <?
                                if($bidinfo["firstbid"] )
                                {
                                    $fbid=$bidinfo["firstbid"];
                                    if($fbid->id==$bid->id) echo " danger ";
                                }


                                    ?> " >
                                    <td>{{$bid->user->username}}</td>
                                    <td class=" <?
                                    if($bidinfo["lowprice"] )
                                    {
                                        if($bidinfo["lowprice"]==$bid->price) echo " lowprice ";
                                    }

                                    ?> " >{{$bid->price}}</td>
                                    <td>{{$bid->created_at}}</td>
                                    <td> @if($bid->url) <a href=" {{ $bid->url}}"> 链接</a> @else  -   @endif </td>
                                    <td> @if($bid->is_win) 中标 @else  -   @endif </td>
                                </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>

                    </div>
                    <!-- /.col-lg-6 (nested) -->



                    <div class="col-lg-4">
                        <div class="col-lg-12"><h3 class="page-header">相关物流</h3></div>

@if($deli)

                        <form role="form" action="/admin/savedeli/{{$demand->id}}" method="post">

                            <input type="hidden" name="_token" value="{{ csrf_token() }}">


                            <div class="form-group"><label>物流公司</label>
                                <input class="form-control"  name="types" value="<? if($deli) echo $deli->types;else echo "没有物流信息"; ?>">
                            </div>

                            <div class="form-group"><label>物流单号</label>
                                <input class="form-control" name="numbers" value="<? if($deli) echo $deli->numbers;else echo "没有物流信息"; ?>">
                            </div>
                            <div class="form-group"><label>物流状态</label>
                                <input class="form-control"  name="status" value="<? if($deli) echo $deli->status;else echo "没有物流信息"; ?>">
                            </div>
                            <div class="form-group"><label>买家电话</label>
                                <input class="form-control" name="mobile"  value="{{$deli->mobile}}">
                            </div>
                            <div class="form-group"><label>发货地址1:</label>
                                <input class="form-control" name="address"
                                       value="<? if($deli) echo $deli->address;else echo "";?> ">
                            </div>
                            <div class="form-group"><label>备注:</label>
                                <textarea name="notes"  class="form-control" ><? if($deli) echo $deli->notes;else echo "";?></textarea>

                            </div>

                            <button type="submit"   class="btn btn-success">保存</button>
                            <button  type="button" onclick="history.back();" class="btn btn-default">返回</button>



                        </form>
     @endif

                    </div>
                    <!-- /.col-lg-6 (nested) -->



                </div>
                <!-- /.row (nested) -->
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>





@endsection


@section('script')
<script>
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
        $("#mybutton").bind("click",function(){
            ajaxSubmit( $('#Form1')[0], function(data){
                alert(data);
            });
        });

    });

    function load_brand(cateid ) {
        ajaxurl="/ajax/brand/?cateid="+cateid+"&rnd="+new Date().getTime();
        $.get(ajaxurl,  function (data) {
            $("#catbrand").empty();
            var obj = eval(data);
            $('#catbrand').append("<option value='0'>请选择</option>");
            $(obj).each(function(index) {
                var val = obj[index];
                opt = $("<option/>").text(val.bname ).attr("value", val.id);
                $('#catbrand').append(opt);
            });
        });

    }

</script>
@endsection


