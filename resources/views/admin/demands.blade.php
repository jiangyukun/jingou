@extends('admin.master')
@section('title')
    竞购管理 @parent
@endsection
@section('content')
<style>
    tbody > tr > td{font-size: 12px;}
</style>
    <div class="row">
                    <div class="col-md-12">


                        <ul class="breadcrumb">
                            <li><a href="/admin/index">后台管理</a> <span class="divider">/</span></li>
                            <li><a href="/admin/demands">竞购管理</a> <span class="divider">/</span></li>
                        </ul>
                        <form class="form-horizontal" role="form" method="get" action="">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label"> 时间 </label>

                                <div class="col-md-6">
                                    <div class="input-daterange input-group col-sm-5" id="datepicker">
                                        <input type="text" class="input-sm form-control" name="start" value="{{Input::get('start')}}" />
                                        <span class="input-group-addon">到</span>
                                        <input type="text" class="input-sm form-control" name="end" value="{{Input::get('end')}}"   />
                                    </div>
                                </div>


                            </div>


                            <div class="form-group">

                                <label for="inputEmail3" class="col-sm-2 control-label">买家状态</label>
                                <div class="col-sm-8">

                                        <? $v = 0; if (isset($_GET['v'])) $v = $_GET["v"]; ?>
                                    <span class="astatus"><input type="checkbox" name="demst[]" value="1"> <a href="?status=0&is_pay=0&v=1" @if($v==1)  style="color:#f00" @endif >定金待付</a>&nbsp;</span>
                                    <span><input type="checkbox" name="demst[]" value="2"><a href="?status=0&is_pay=1&v=2&exp=0"  @if($v==2)  style="color:#f00" @endif  >竞价中</a>&nbsp;</span>

                                    <span><input type="checkbox" name="bidst[]" value="2"><a href="?status=0&is_pay=1&exp=1&v=8"  @if($v==8)  style="color:#f00" @endif >待选标</a>&nbsp;</span>


                                    <span><input type="checkbox" name="demst[]" value="3"><a href="?status=1&is_pay=1&v=3"  @if($v==3)  style="color:#f00" @endif  >待付款</a>&nbsp;</span>
                                    <span><input type="checkbox" name="demst[]" value="4"><a href="?status=2,3&v=4"  @if($v==4)  style="color:#f00" @endif >待收货</a>&nbsp;</span>
                                    <span><input type="checkbox" name="demst[]" value="5"><a href="?status=4,5&v=5"  @if($v==5)  style="color:#f00" @endif >已完成</a>&nbsp;</span>
                                    <span><input type="checkbox" name="demst[]" value="6"><a href="?status=-3&v=6"  @if($v==6)  style="color:#f00" @endif  >已取消</a>&nbsp;</span>
                                    <span><input type="checkbox" name="demst[]" value="6"><a href="?status=-4&v=7"  @if($v==7)  style="color:#f00" @endif  >已放弃</a>&nbsp;</span>
                                </div>

                            </div>

                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-2 control-label">分类</label>
                                <div class="col-sm-6">

                                    <select class="form-control" name="cate">
                                        <option value="0">请选择</option>
                                        <? echo $catetree; ?>
                                    </select>

                                </div>

                            </div>

                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-2 control-label">信息</label>
                                <div class="col-sm-6">
                                    <input type="input" class="form-control inputholder" name="sinfo"  placeholder='请输入用户名、单号、手机号码、支付宝账号'
                                      <?php
                                      if(isset($_GET["sinfo"]))
                                         echo "value='".$_GET["sinfo"]. "' ";
                                      else
                                          echo "value='' ";
                                      ?>  > </div>
                                <div class="col-sm-4"><button type="submit" class="btn btn-primary">确定</button></div>
                            </div>


                        </form>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <style type="text/css">
                            .tab{width:1200px;display: block; }
                            .tab li{height: 60px; border-bottom: 1px solid #ddd; list-style: none; float: left; text-align: center; }
                            .tab .wd1{width:160px;}
                            .tab .wd2{width:420px;}
                            .tab .wd3{width:160px;}
                            .tab .wd4{width:180px;}
                            .tab .wd5{width:140px;}
                            .tab .wd6{width:140px;}
                        </style>

                        <div class="panel panel-default"  id="mypanel">

                            <!-- /.panel-heading -->
                            <div class="panel-body">
                            <div class="dataTable_wrapper">

                                <div class="tab">
                                    <li class="wd1">单号</li>
                                    <li class="wd2">对应商品</li>
                                    <li class="wd3">价格</li>
                                    <li class="wd4">截止日期</li>
                                    <li class="wd5">用户</li>
                                    <li class="wd6">操作</li>
                                </div>

                       @if (count($demands))

                            @foreach($demands as $demand)

    <div class="tab">
        <li class="wd1">
            <a href="{{ URL::to('demand/show/'.$demand->id) }}">{{$demand->sn}} </a> </li>
        <li class="wd2"><img src="/{{$demand->thumb}}" width="20" alt="{{$demand->title}}">
            <a href="{{$demand->url}}" target="_blank">{{$demand->title}}</a></li>
        <li class="wd3">{{$demand->price}}</li>
        <li class="wd4">{{$demand->expire_time}}</li>
        <li class="wd5"><a href="{{url('user/'.$demand->user->id)}}" title="管理该用户">{{$demand->user->username}}</a></li>
        <li class="wd6">
            <a href="{{url('admin/d_demand/'.$demand->id)}}" onclick="return confirm('确定删除？')"><i class="fa fa-times"></i></a>
            <a href="{{url('admin/debid/'.$demand->id)}}" >竞价</a>
            <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{$demand->id}}" aria-expanded="false"
               class="collapsed">修改</a>
        </li>
    </div>



                                <div id="collapse{{$demand->id}}" class="panel-collapse collapse"
                                     aria-expanded="false" style="width: 1200px;height: 450px;   float: left; ">
                                    <div class="panel-body">


                                        <table width="100%"   cellspacing="0" cellpadding="0" class="table table-striped table-bordered table-hover">
                                            <tr>
                                                <td>竞购商品</td>
                                                <td colspan="9">
                                                    <span  class="myedit"  onclick="listTable.edit(this, 'edit_title', {{$demand->id}})"  title="点击修改内容">{{$demand->title}}  </span></td>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <form action="/admin/demands/" id="Form{{$demand->id}}"  method="post">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="hidden" name="act" value="savecate">
                                                <input type="hidden" name="deid" value="{{$demand->id}}">


                                            <tr  id="eform{{$demand->id}}">
                                                <td>商品大类</td>
                                                <td>
                                                    <select name="cat1"  onchange="loadArea(this.value,'city',{{$demand->id}})" >
                                                        <option value="">选择</option>

                                                        @foreach ($cat1 as $cat)
                                                            <option value="{{$cat->id}}"   @if($cat->id==$demand->cat1) selected @endif   >{{$cat->slug}}</option>
                                                        @endforeach

                                                    </select>
                                                </td>
                                                <td>商品小类</td>
                                                <td>
                                                    <select name="cat2"  id="city{{$demand->id}}"  onchange="loadArea(this.value,'district',{{$demand->id}})" >
                                                        <option value="">选择</option>
                                                @foreach ($cat2 as $cat)
                                                <option value="{{$cat->id}}"   @if($cat->id==$demand->cat2) selected @endif   >{{$cat->slug}}</option>
                                                @endforeach

                                                </select>
                                                </td>
                                                <td>商品名</td>
                                                <td>
                                                    <select name="cat3"   id="district{{$demand->id}}"  onchange="loadArea(this.value,'brand',{{$demand->id}})" >
                                                        @foreach ($cat3 as $cat)
                                                        <option value="{{$cat->id}}"   @if($cat->id==$demand->cat3) selected @endif  >{{$cat->slug}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td> 品牌</td>
                                                <td>

                                                    <?

                                                    //print_r($demandbrand["a".$demand->id]);

                                                    $one_brand=$demandbrand["a".$demand->id];

                                                    ?>


                                                    <select name="bname" id="brand{{$demand->id}}" >
                                                        <option value="0">选择</option>

                                                        @foreach ($one_brand as $brand)
                                                        <option value="{{$brand['id']}}"   @if($brand['id']==$demand->bid) selected @endif   >{{$brand['slug']}}</option>
                                                        @endforeach

                                                    </select>
                                                </td>
                                                <td> 型号</td>
                                                <td>
  <span  class="myedit"  onclick="listTable.edit(this, 'edit_model', {{$demand->id}})"
         title="点击修改内容">@if($demand->model!='')  {{$demand->model}} @else 无内容  @endif  </span>

                                                </td>
                                                <td>
                                                    <button type="button" onclick="savef('Form{{$demand->id}}')" class="btn btn-success btn-xs">保存</button>
                                                </td>
                                            </tr>

                                            </form>
        <tr>
            <td>买家用户名</td>
            <td>{{$demand->user->username}}</td>
            <td>发布时间</td>
            <td>{{$demand->created_at}}</td>
            <td>竞价时长</td>
            <td>{{$demand->avltime}}</td>
            <td>距离结束</td>
            <td>{{$demand->getexptime()}}</td>
            <td>有否延时</td>
            <td>{{$demand->getdelay()}}</td>
            <td>&nbsp;</td>
        </tr>

                <?
               $bidinfo= $demand->getbidinfo();
                ?>
                <tr>
                    <td>起始竞价</td>
                    <td>

<span  class="myedit"  onclick="listTable.edit(this, 'edit_price', {{$demand->id}})"
title="点击修改内容">@if($demand->price!='')  {{$demand->price}} @else 无内容  @endif  </span>
</td>
                    <td>中标价</td>
                    <td>{{$bidinfo['winprice']}}</td>
                    <td>最低价</td>
                    <td>{{$bidinfo['lowprice']}}</td>
                    <td>竞价商家数</td>
                    <td>{{count($demand->bids)}}</td>
                    <td>中标商家</td>
                    <td>
                        @if($bidinfo['winuser']!=null)
                          {{ $bidinfo['winuser']->username }}
                        @else
                            无
                        @endif

                    </td>
                    <td>&nbsp;</td>
                </tr>

                                            <form action=""  method="post">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                                <tr>
                                                <td>竞购状态</td>
                                                <td>{{$demand->getstatus()}}</td>
                                                <td>定金金额</td>
                                                <td>{{$demand->deposit}}</td>
                                                <td>状态</td>
                                                <td>
                                                    <select name="is_pay" onChange="changdep(this,{{$demand->id}});">
                                                        <option value="1"  @if($demand->is_pay==0) selected @endif  >未收</option>
                                                        <option value="2"  @if($demand->is_pay==1) selected  @endif>已收</option>
                                                        <option value="-1"  @if($demand->is_pay==-3 ||$demand->is_pay==-1) selected @endif  >已退</option>
                                                    </select>
                                                </td>
                                                <td>货款金额</td>
                                                <td>{{$demand->getwinprice()}}</td>
                                                <td>状态</td>
                                                <td>
                                                    <select name="is_payd" onChange="changleft(this,{{$demand->id}})">
                                                        <option value="1" @if($demand->is_pay==0) selected @endif >未收</option>
                                                        <option value="2" @if($demand->is_pay==2) selected  @endif >已收</option>
                                                        <option value="-2" @if($demand->is_pay==-3 ||$demand->is_pay==-2) selected @endif   >已退</option>
                                                    </select>
                                                </td>
                                                <td>&nbsp;</td>
                                            </tr>
                                        </form>
                                            <tr>
                                                <td>买家电话</td>
                                                <td>{{$demand->user->mobile}}</td>
                                                <td>买家定金账户</td>
                                                <td>{{$demand->user->alipay}}</td>
                                                <td>买家货款账户</td>
                                                <td>{{$demand->user->alipay}}</td>
                                                <td>卖家电话</td>
                                                <td>
                                                    <?
                                                    $winuser=$bidinfo['winuser'];
                                                    if(@$winuser!=null)
                                                      echo $winuser->mobile;
                                                    ?>

                                                </td>
                                                <td>卖家货款账户</td>
                                                <td><?
                                                    if(@$winuser!=null) echo $winuser->alipay;
                                                    ?></td>
                                                <td>&nbsp;</td>
                                            </tr>

 <? $deli=\ZuiHuiGou\delivery::where("deid","=",$demand->id)->get()->first();?>
@if($deli==null)
   <tr><td colspan="12">没有相关物流信息</td></tr>
@else
         <tr>
                <td>物流状态</td>
                 <td>
    <span  class="myedit"  onclick="listTable.edit(this, 'edit_delistatus', {{$deli->id}})"
         title="点击修改内容">@if($deli->status!='')  {{$deli->status}} @else 无内容  @endif  </span>

                </td>
                <td>物流单号</td>
                <td>
    <span  class="myedit"  onclick="listTable.edit(this, 'edit_delinumber', {{$deli->id}})"
           title="点击修改内容">@if($deli->numbers!='')  {{$deli->numbers}} @else 无内容  @endif  </span>

                </td>
                <td>买家收货电话</td>
                <td>
                <span  class="myedit"  onclick="listTable.edit(this, 'edit_delimobile', {{$deli->id}})"
                                 title="点击修改内容">@if($deli->mobile!='')  {{$deli->mobile}} @else 无内容  @endif  </span>
                </td>
                <td>卖家发货电话</td>
                <td>
                 <span  class="myedit"  onclick="listTable.edit(this, 'edit_delisemobile', {{$deli->id}})"
                        title="点击修改内容">@if($deli->sendmobile!='')  {{$deli->sendmobile}} @else 无内容  @endif  </span>

                </td>
                <td>&nbsp;</td>
                <td></td>
                <td>&nbsp;</td>
            </tr>

@endif

<?
$addrs=\ZuiHuiGou\Address::where("user_id","=",$demand->user_id)->get();
//  echo  $demand->user_id ;

?>
                                            @if(count($addrs)>0)
                                                @foreach ($addrs as $addr)
                                                <tr>
                                                    <td>发货地址</td>
                                                    <td colspan="9">
                                                          <span  class="myedit"  onclick="listTable.edit(this, 'edit_address', {{$addr->id}})"
                                                           title="点击修改内容"> {{$addr->fulladdr}} </span>
                                                       </td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                @endforeach
                                            @endif

                                            <tr>
                                                <td>买家评价</td>
                                                <td colspan="9">
                                                    <span  class="myedit"  onclick="listTable.edit(this, 'edit_comment', {{$demand->id}})"
                                                           title="点击修改内容">@if($demand->comment!='')  {{$demand->comment}} @else 无内容  @endif  </span>
                                                   </td>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td colspan="10" align="center" valign="middle">当前所的竞价</td>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td>序号</td>
                                                <td>商家名</td>
                                                <td>竞价时间</td>
                                                <td>竞价价格</td>
                                                <td>说明</td>
                                                <td>链接</td>
                                                <td>竞价状态</td>
                                                <td>中标</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                            </tr>

                                            @if(count($demand->bids)>0)
                                          <?  $bids=$demand->bids;?>
                                            @foreach ($bids as $bid)
                                                <tr>
                                                    <td>{{$bid->id}}</td>
                                                    <td>{{$bid->user->username}}</td>
                                                    <td>{{$bid->created_at}}</td>
                                                    <td>{{$bid->price}}</td>
                                                    <td>{{$bid->details}}</td>
                                                    <td>{{$bid->url}}</td>
                                                    <td> @if($bid->is_win==1) 中标 @else 淘汰 @endif</td>
                                                    <td>
                                                        <input type="radio" onclick="c_win({{$demand->id}},{{$bid->id}})"
                                                               name="is_win{{$demand->id}}"  id="c_win{{$demand->id}}"
                                                        @if($bid->is_win==1)  value="1"  checked="checked"   @else value=0  @endif  />
                                                    </td>
                                                    <td>&nbsp;</td>
                                                    <td>&nbsp;</td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                            @endforeach
                                            @endif

                                        </table>




                                    </div>
                                </div>
                                 @endforeach
                       @endif

                                    </div>
                                <!-- /.table-responsive -->

                            </div>
                            <!-- /.panel-body -->
<div class="col-md-12">
    <?php echo $demands->render(); ?>
</div>

                        </div>
                        <!-- /.panel -->
                    </div>
                    <!-- /.col-xs-12 -->
                </div>

@endsection
@section('script')
<script src="/bower_components/datepicker/js/bootstrap-datepicker.js"></script>

<script src="/js/utils.js"></script>
<script src="/js/jquery.form.js"></script>
<script src="/bower_components/datepicker/locales/bootstrap-datepicker.zh-CN.min.js" charset="UTF-8"></script>
    <script>
    //将form转为AJAX提交
    function ajaxSubmit(frm, fn) {
        var dataPara = getFormJson(frm);
        var url=frm.action;
        $.ajax({
            url: url,
            type: "post",
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
    function savef(fname) {
        ajaxSubmit($('#' + fname), function (data) {
            alert(data);
        });
    }





    function loadArea(areaId, areaType,deid) {
        ajaxurl="/ajax/category/?cateid="+areaId+"&rnd="+new Date().getTime();
 //       burl="/ajax/brand/?cateid="+areaId+"&rnd="+new Date().getTime();

        $.get(ajaxurl,  function (data) {
            if (areaType == 'city') {
                $('#' + areaType+deid).html('<option value="-1">请选择</option>');
                $('#district'+deid).html('<option value="-1">请选择</option>');
            } else if (areaType == 'district') {
                $('#' + areaType+deid).html('<option value="-1">请选择</option>');
            }else if (areaType == 'brand') {
                $('#' + areaType+deid).html('<option value="-1">请选择</option>');
            }
            if (areaType != 'null') {
                var obj = eval(data);
                $(obj).each(function(index) {
                    var val = obj[index];
                    opt = $("<option/>").text(val.slug ).attr("value", val.id);
                    $('#' + areaType+deid).append(opt);
                });

            }
        });


/*
        $.get(burl,  function (data) {
            var obj = eval(data); $('#brandname'+deid ).empty();
            $(obj).each(function(index) {

                var val = obj[index];
                opt = $("<option/>").text(val.bname ).attr("value", val.id);
                $('#brandname'+deid).append(opt);
            });
        });
*/

    }







    function changdep(control,deid)
        {
            var act = "is_pay";
            var t_data = {"_token": $(document).find('input[name=_token]').val(), "act": act, "deid": deid, "val": control.value};
            $.post("/admin/demands", t_data, function (data) {
                var res = eval("(" + data + ")");
                $(res).each(function (index) {
                    if (res.message) {
                        alert(res.message);
                    }
                });
            });
        }
        function changleft(control,deid)
        {
            var act = "is_payd";
            var t_data = {"_token": $(document).find('input[name=_token]').val(), "act": act, "deid": deid, "val": control.value};
            $.post("/admin/demands", t_data, function (data) {
                var res = eval("(" + data + ")");
                $(res).each(function (index) {
                    if (res.message) {
                        alert(res.message);
                    }
                });
            });
        }


        function c_win(deid, bid) {
            var act = "choosewin";
            var t_data = {"_token": $(document).find('input[name=_token]').val(), "act": act, "deid": deid, "bid": bid};
            $.post("/admin/demands", t_data, function (data) {
                var res = eval("(" + data + ")");
                $(res).each(function (index) {
                    if (res.message) {
                        alert(res.message);
                    }

                });
            });
        }


        $(document).ready(function() {

            $('#dataTables-example').DataTable({
                responsive: true
            });
        });


        $('.input-daterange').datepicker({
            format: "yyyy/mm/dd  ",
            weekStart: 1,
            language: "zh-CN"
        });


        $.fn.inputholder=function(){
            var dval=$(this).val();
            $(this).focus(function(){
                $(this).val('').addClass('focous');
            }).blur(function(){
                if($(this).val()==''){
                    $(this).val(dval).removeClass('focous');
                }
            });
        };
        var inputholder=$('.inputholder');
        if(inputholder.length){
            inputholder.each(function() {
                $(this).inputholder()
            })
        };



        if (typeof Utils != 'object')
        {
            alert('Utils object doesn\'t exists.');
        }

        var listTable = new Object;

        listTable.query = "query";
        listTable.filter = new Object;
        listTable.url = location.href.lastIndexOf("?") == -1 ? location.href.substring((location.href.lastIndexOf("/")) + 1) : location.href.substring((location.href.lastIndexOf("/")) + 1, location.href.lastIndexOf("?"));
        listTable.url += "?is_ajax=1";

        /**
         * 创建一个可编辑区
         */
        listTable.edit = function(obj, act, id)
        {
            var tag = obj.firstChild.tagName;

            if (typeof(tag) != "undefined" && tag.toLowerCase() == "input")
            {
                return;
            }

            /* 保存原始的内容 */
            var org = obj.innerHTML;
            var val = Browser.isIE ? obj.innerText : obj.textContent;

            /* 创建一个输入框 */
            var txt = document.createElement("INPUT");
            txt.value = (val == 'N/A') ? '' : val;
            txt.style.width = (obj.offsetWidth + 12) + "px" ;

            /* 隐藏对象中的内容，并将输入框加入到对象中 */
            obj.innerHTML = "";
            obj.appendChild(txt);
            txt.focus();

            /* 编辑区输入事件处理函数 */
            txt.onkeypress = function(e)
            {
                var evt = Utils.fixEvent(e);
                var obj = Utils.srcElement(e);

                if (evt.keyCode == 13)
                {
                    obj.blur();

                    return false;
                }

                if (evt.keyCode == 27)
                {
                    obj.parentNode.innerHTML = org;
                }
            }

            /* 编辑区失去焦点的处理函数 */
            txt.onblur = function(e)
            {
                if (Utils.trim(txt.value).length > 0)
                {

                //    res = Ajax.call(listTable.url, "act="+act+"&val=" + encodeURIComponent(Utils.trim(txt.value)) + "&id=" +id, null, "POST", "JSON", false);

                    var t_data = {"_token": $(document).find('input[name=_token]').val(), act: act, val: encodeURIComponent(Utils.trim(txt.value)), id: id};

                    $.post(listTable.url, t_data, function (data) {
                        var res = eval("(" + data + ")");
                        $(res).each(function (index) {
                            if (res.message) {
                                alert(res.message);
                            }
                            obj.innerHTML = (res.error == 0) ? res.content : org;
                        });
                    });



/*
                    if(res.id && (res.act == 'goods_auto' || res.act == 'article_auto'))
                    {
                        document.getElementById('del'+res.id).innerHTML = "<a href=\""+ thisfile +"?goods_id="+ res.id +"&act=del\" onclick=\"return confirm('"+deleteck+"');\">"+deleteid+"</a>";
                    }

                    obj.innerHTML = (res.error == 0) ? res.content : org;
 */
                }
                else
                {
                    obj.innerHTML = org;
                }
            }
        }





    </script>

@endsection