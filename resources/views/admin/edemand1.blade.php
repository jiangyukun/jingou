@extends('admin.master')
@section('title')
竞购管理 @parent
@endsection
@section('script')

@endsection
@section('content')



<div class="col-md-11  col-lg-offset-1 ">

<div class="panel-body">
    <div class="panel-group" id="accordion">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" class="collapsed">Collapsible Group Item #1</a>
                </h4>
            </div>
            <div id="collapseOne" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                <div class="panel-body">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" class="collapsed" aria-expanded="false">Collapsible Group Item #2</a>
                </h4>
            </div>
            <div id="collapseTwo" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                <div class="panel-body">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree" class="collapsed" aria-expanded="false">Collapsible Group Item #3</a>
                </h4>
            </div>
            <div id="collapseThree" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                <div class="panel-body">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                </div>
            </div>
        </div>
    </div>
</div>











<form role="form"  class="form-inline" style="background: #fff;">

<fieldset >
    <legend>竞购详细情况</legend>
    <div class="form-group col-sm-12 mb15"  >

        <div class="col-sm-6">
            <label class="col-sm-2" style="text-align: left">商品分类</label>

            <div class="col-sm-10">
                <select class="form-control" onchange="loadArea(this.value,'second')">
                    <option value="-1">请选择</option>
                    <? echo $catetree; ?>
                </select>
            </div>



        </div>



        <div class="col-sm-3" >
            <label class="col-sm-3" style="text-align: right">品牌</label>
            <div class="col-sm-9"  >   <input class="form-control"  ></div>
        </div>
        <div class="col-sm-3" >
            <label class="col-sm-3" style="text-align: right">型号</label>
            <div class="col-sm-9"  >   <input class="form-control" ></div>
        </div>
</fieldset>
<fieldset>

    <div class="form-group col-sm-3 mb15"  >
        <label class="col-sm-4">用户名</label>
        <div class="col-sm-8"><input class="form-control" placeholder="Enter text" value="{{$user->username}}"></div>
    </div>
    <div class="form-group col-sm-3 mb15">
        <label class="col-sm-4">发布时间</label>
        <div class="col-sm-8"><input class="form-control" placeholder="Enter text"  value="{{$demand->created_at}}"></div>
    </div>
    <div class="form-group col-sm-3 mb15">
        <label class="col-sm-4">结束时间</label>
        <div class="col-sm-8"><input class="form-control" placeholder="Enter text" value="{{$demand->expire_time}}" ></div>
    </div>
    <div class="form-group col-sm-3 mb15">
        <label class="col-sm-5">新结束时间</label>
        <div class="col-sm-7"><input class="form-control" placeholder="Enter text" value=""></div>
    </div>
    <div class="form-group col-sm-3 mb15">
        <label class="col-sm-4">时间状态</label>
        <div class="col-sm-8">
            <select class="form-control">
                <option value="0"  @if(strtotime($demand->expire_time)>=strtotime('now')) selected @endif >进行中</option>
                <option value="">延时中</option>
                <option value="4" @if(strtotime($demand->expire_time)<strtotime('now')) selected @endif>已结束</option>
            </select>
        </div>
    </div>

</fieldset>
<fieldset>

    <div class="form-group col-sm-3 mb15">
        <label class="col-sm-4">起始竞价</label>

        <div class="col-sm-8"><input class="form-control" placeholder="Enter text" value="<?if($bidinfo['firstbid']) echo  $bidinfo['firstbid']->price;?>"></div>
    </div>
    <div class="form-group col-sm-3 mb15">
        <label class="col-sm-4">中标价</label>

        <div class="col-sm-8"><input class="form-control"  value="<?
            if($bidinfo['winbid']) echo $bidinfo['winbid']->price;else echo "没有中标价";
            ?>"></div>
    </div>

    <div class="form-group col-sm-3 mb15">
        <label class="col-sm-4">最低价</label>

        <div class="col-sm-8"><input class="form-control" placeholder="Enter text"
                                     value="<? if($bidinfo['lowbid'] ) echo $bidinfo['lowbid']->price; ?>"></div>
    </div>

    <div class="form-group col-sm-3 mb15">
        <label class="col-sm-4">竞购状态</label>
        <div class="col-sm-8"><input class="form-control" ></div>
    </div>
    <div class="form-group col-sm-3 mb15">
        <label class="col-sm-4">竞价状态</label>
        <div class="col-sm-8"><input class="form-control"  ></div>
    </div>
    <div class="form-group col-sm-3 mb15">
        <label class="col-sm-5">竞价商家数</label>
        <div class="col-sm-7"><input class="form-control"  value="{{count($bids)}}"></div>
    </div>
    <div class="form-group col-sm-3 mb15">
        <label class="col-sm-4">中标商家</label>
        <div class="col-sm-8"><input class="form-control"
                                     value="<? if($bidinfo['winbid']) echo $bidinfo['winuser']->username;?>"></div>
    </div>

</fieldset>

<fieldset>
    <legend>状态详细情况</legend>

    <div class="form-group col-sm-3 mb15">
        <label class="col-sm-4">定金金额</label>

        <div class="col-sm-8">

            <input class="form-control"  value="{{$demand->deposit}}">

        </div>
    </div>

    <div class="form-group col-sm-3 mb15">
        <label class="col-sm-4">状态</label>
        <div class="col-sm-8">
            <select class="form-control">
                <option value="0" <? if($demand->status==0) echo "selected";?> >未收</option>
                <option value="1" <? if($demand->status>0) echo "selected";?> >  已收</option>

                <option value="-8"  <? if($demand->status==-8) echo "selected";?>>已退</option>
                <option value="-9"  <? if($demand->status==-9) echo "selected";?>>未退</option>
            </select>
        </div>
    </div>

    <div class="form-group col-sm-3 mb15">
        <label class="col-sm-4">汇款账户</label>
        <div class="col-sm-8"><input class="form-control" ></div>
    </div>

    <div class="form-group col-sm-3 mb15">
        <label class="col-sm-4">货款金额</label>
        <div class="col-sm-8"><input class="form-control"  ></div>
    </div>

    <div class="form-group col-sm-3 mb15">
        <label class="col-sm-4">状态</label>
        <div class="col-sm-8">
            <select class="form-control">
                <option>已收</option>
                <option>未收</option>
                <option>已退</option>
                <option>未退</option>
            </select></div>
    </div>

    <div class="form-group col-sm-3 mb15">
        <label class="col-sm-4">汇款账户</label>
        <div class="col-sm-8"><input class="form-control"  ></div>
    </div>
</fieldset>

<fieldset>
    <legend>物流详细情况</legend>
    <div class="form-group col-sm-3 mb15">
        <label class="col-sm-4">物流单号</label>
        <div class="col-sm-8"><input class="form-control" value="<? if($deli) echo $deli->numbers;else echo "没有物流信息"; ?>"></div>
    </div>

    <div class="form-group col-sm-3 mb15">
        <label class="col-sm-4">物流状态</label>
        <div class="col-sm-8"><input class="form-control"  ></div>
    </div>

    <div class="form-group col-sm-3 mb15">
        <label class="col-sm-4">买家电话</label>

        <div class="col-sm-8"><input class="form-control"  value="{{$user->mobile}}"></div>
    </div>

    <div class="form-group col-sm-3 mb15">
        <label class="col-sm-4">买家支付宝</label>
        <div class="col-sm-8"><input class="form-control" value="{{$user->alipay}}" ></div>
    </div>

    <div class="form-group col-sm-3 mb15">
        <label class="col-sm-4">卖家电话</label>
        <div class="col-sm-8"><input class="form-control"
                                     value="<? if($bidinfo['winuser']) echo $bidinfo['winuser']->mobile; ?>"></div>
    </div>

    <div class="form-group col-sm-3 mb15">
        <label class="col-sm-4">卖家支付宝</label>

        <div class="col-sm-8"><input class="form-control" value="<? if($bidinfo['winuser']) echo $bidinfo['winuser']->alipay; ?>"></div>
    </div>

    <div class="form-group col-sm-12 mb15">
        <label class="col-sm-1">发货地址1:</label>

        <div class="col-sm-8"><input class="form-control"
                                     value="<? if($deli) echo $deli->address;else echo "";?> "></div>
    </div>

    <div class="form-group col-sm-12 mb15">
        <label class="col-sm-1">发货地址2:</label>

        <div class="col-sm-8"><input class="form-control"></div>
    </div>



</fieldset>
<button type="submit" class="btn btn-default">保存</button>
<button type="button" onclick="history.back();" class="btn btn-default">返回</button>


</form>

</div>






@endsection


<script>

    function loadArea(catid, catetype) {
        ajaxurl="/ajax/category/?cateid="+catid+"&rnd="+new Date().getTime();
        $.get(ajaxurl,  function (data) {
            if (catetype == 'second') {
                $('#' + catetype).html('<option value="-1">请选择</option>');
                $('#third').html('<option value="-1">请选择</option>');
            } else if (catetype == 'third') {
                $('#' + catetype).html('<option value="-1">请选择</option>');
            }
            if (catetype != 'null') {
                var obj = eval(data);
                $(obj).each(function(index) {
                    var val = obj[index];
                    opt = $("<option/>").text(val.slug ).attr("value", val.id);
                    $('#' + catetype).append(opt);
                });

            }
        });
    }


</script>