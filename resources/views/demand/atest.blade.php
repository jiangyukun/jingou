<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ url('/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ url('/css/style.css') }}">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="http://cdn.staticfile.org/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="http://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script type="text/javascript">
        var url = this.location.href;
        var catids=""; //选中的分类编号,按,号分开
        var brands="";//选中的品牌编号,按,号分开
    </script>


    <link href="/ncss/normalize.css" rel="stylesheet" type="text/css">
    <link href="/ncss/fakeLoader.css" rel="stylesheet" type="text/css">
    <link href="/ncss/style.css" rel="stylesheet" type="text/css">
    <script src="/njs/util/arrayUtil.js"></script>
    <script src="/njs/lib/jquery.js"></script>
    <script src="/njs/jquery.more.js"></script>
    <script src="/njs/lib/underscore.js"></script>
    <script src="/njs/lib/backbone.js"></script>
    <!--<script src="../../res/js/bootstrap.js"></script>-->
    <script src="/njs/BrandItem.js"></script>
    <script src="/njs/Brand.js"></script>
    <script src="/njs/SearchBox.js"></script>
    <script src="/njs/Item.js"></script>
    <script src="/njs/SmallCategory.js"></script>
    <script src="/njs/BigCategory.js"></script>
    <script src="/njs/AllCategory.js"></script>
    <script src="/njs/ProductManage.js"></script>
    <script src="/njs/fakeLoader.min.js"></script>



</head>
<body>

<div class="fakeLoader"></div>
<script>
    $(document).ready(function(){
        $(".fakeloader").fakeLoader({
            timeToHide:1200,
            bgColor:"#2ecc71",
            spinner:"spinner1"
        });
    });
</script>
<nav class="navbar navbar-default"  >
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand logo-index" href="#"    hidefocus="true"  >{{$settings["site_name"]}}</a>
            <h4>{{$settings["site_subhead"]}}</h4>
        </div>

        <div>
            <ul class="nav navbar-nav navbar-main">
                <li><a href="{{ url('/') }}"  hidefocus="true"  >{{Lang::get('layout.Home')}}</a></li>
                @if(isset(Auth::user()->id) && Auth::user()->hasRole('bidder'))
                <li><a href="{{ URL::to('bid/my/all') }}"  hidefocus="true" >我的竞价</a></li>
                @else
                <li><a href="{{ URL::to('demand/post') }}" hidefocus="true" >{{Lang::get('layout.PostDemand')}}</a></li>
                @endif
                <li><a href="{{ URL::to('demand/list') }}" hidefocus="true" >{{Lang::get('layout.Demanding')}}</a></li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                @if (Auth::guest())
                <li><a href="{{ url('/auth/login') }}" id="link-login"   hidefocus="true"  >{{Lang::get('layout.Login')}}</a></li>
                <li><a href="{{ url('/auth/register') }}"  hidefocus="true"  >{{Lang::get('layout.Register')}}</a></li>
                <li class="service-phone">{{Lang::get('layout.ServicePhone')}}{{$settings["service_phone"]}}</li>
                @else
                <li>
                    <a href="{{isset(Auth::user()->id) && Auth::user()->hasRole('admin') ? url('/admin/index') : (Auth::user()->hasRole('bidder')?url('/bid/my'):url('/demand/my')) }}"   hidefocus="true"  >
                        {{ Auth::user()->username }}</a>
                </li>
                <li><a href="{{ url('/auth/logout') }}"   hidefocus="true"  >{{ Lang::get('layout.Logout') }}</a></li>
                <li class="service-phone">{{Lang::get('layout.ServicePhone')}}{{$settings["service_phone"]}}</li>
                @endif
            </ul>
        </div>
    </div>
</nav>


<style>

</style>

<div class="page-demand-post">


    <style>
        .search-btn {
            background: none repeat scroll 0 0 #F04243;
            border: 0 none;
            border-radius: 0;
            color: #FFFFFF;
            cursor: pointer;
            height: 35px;
            line-height: 33px;
            padding: 0;
            vertical-align: baseline !important;
            width: 76px;
            text-align: center;
            vertical-align: middle;
            white-space: nowrap;
            margin-bottom: 0;
            font-weight: normal;
            font-size: 14px;
            display: inline-block;
            position: relative;
        }
    </style>


    <?php
    //var_dump( $_GET );
    ?>

    <div class="product-container">

        <div class="form-fields" style="width: 100%;height: 48px;">
            <form method="GET" action="/demand/list/">

                <input type="text" name="s"  id="s_key"
                    <?php
                    if(isset($_GET['s']))
                        echo "value=".urldecode($_GET['s']);

                    ?>
                       name="s" id="s"
                       class="index_bj kw_bj keyword"   style=" width: 400px;height: 32px;">
                <input type="submit" value="搜索" class="search-btn" hidefocus="true">
            </form>
        </div>


        <div class="search-condition">
            <div class="btn-tip">
                <span class="addTip">点此添加商品名称</span>
            </div>
            <div id="selectedProducts" class="clearfix">

                <div class="clearfix">
                    <div class="pull-left reelect">
                        <span id="selectCaption" class="glyphicon reelect-icon-color"></span>
                    </div>
                    <div id="smallCategoryContainer" class="pull-left"></div>
                </div>


                <div class="product-select-tip clearfix">
                    <button class="reelect-btn pull-left" style="display: none">重选</button>
                    <div id="selectTip" class="pull-right icon-color-tip">
                        <span class="tip1" style="display: none">请点击<span class="glyphicon glyphicon-plus icon-color-plus"></span>重新选择商品种类，点击商品品种进一步选择品牌</span>
                        <span class="tip2" style="display: none">每次只能选择一个大类中的商品种类</span>
                        <span class="tip3" style="display: none">请点击“重选”删除全部已选商品种类，点击商品种类名删除该种类</span>
                    </div>
                </div>





            </div>
        </div>


        <div class="small-category-container"></div>
        <div class="search-menu-list clearfix">
            <div class="close-container">
                <span class="confirm-btn">确定</span>
            </div>
            <ul id="category_menu_list">
                @foreach ($cates as $key=>$cate)
                <li class="big-category"><A id="{{$cate['name']}}{{$cate['id']}}" >{{ $cate["slug"] }}</A></li>
                @endforeach

                <li id="current"></li>
            </ul>
            <div class="content">
                @foreach ($cates as $key=>$cate)
                <div class="sub-content">

                    <?php $oc = $cate['children']; ?>
                    <?php foreach ($oc as $one): ?>
                        <dl>
                            <dt>

                                <span>
                                        <input id="{{$one['name']}}_checkbox{{$one['id']}}" name="{{$one['name']}}_checkbox" type="checkbox">
                                        <label for="{{$one['name']}}_checkbox{{$one['id']}}">{{$one['slug']}}</label>
                                </span>
                            </dt>
                            <!--------------level3------------->

                            <?php   $twoc = $one['children'];?>
                            <?php foreach ($twoc as $two): ?>
                                <dd><span id="{{$two['name']}}_{{$two['id']}}"   class="item">{{$two['slug']}}</span></dd>
                            <?php endforeach; ?>

                        </dl>
                    <?php endforeach; ?>

                </div>

                @endforeach


            </div>
        </div>
        <div class="product-brand">
            <div class="clearfix">
                <div class="brand-text">
                    <label class="brand-name">品牌</label>
                    <label class="colonArea">：</label>
                </div>
                <div class="brand-items">
                    <div id="brand-item-all" class="brand-item brand-item-clicked">全部</div>
                </div>
            <span class="brand-more">
                更多<span class="glyphicon glyphicon-chevron-down"></span>
            </span>
            </div>

            <div class="brand-confirm-btn">
                <button id="brandConfirm" class="btn">确定</button>
            </div>
        </div>


        <style>
            .get_more{margin:10px; text-align:center}
            .more_loader_spinner{width:20px; height:20px; margin:10px auto; background: url(loader.gif) no-repeat;}
        </style>



    </div>



    <div class="col-xs-12">
        <div class="page-demand-list" style="border-top:none;padding-top: 0px;">

            <div class="col-xs-9" id="unicontent" style="margin: 0 auto;float: none;width: 1000px;">
                @if (count($demands))
                @foreach ($demands as $demand)
                <div class="row">
                    <div class="d-list-sn"><span>订单编号：{{ $demand->sn }}</span>
                        <span>提交时间：{{ $demand->created_at }}</span>
                        <span class="d-author"><a href="#">{{ $demand->user->username }}</a></span></div>
                    <div class="col-xs-2"><img src="/{{ $demand->thumb }}"></div>
                    <div class="col-xs-7 d-list-title">
                        <h4><a href="{{ URL::to('demand/show/'.$demand->id) }}" title="{{ $demand->title }}">{{ $demand->title }}</a></h4>
                        <a href="{{ $demand->url }}" title="{{ $demand->title }}" target="_blank" rel="nofollow">点击进入竞价对照商品页面</a> </div>
                    <div class="col-xs-3 d-list-info">
                        <p>初始竞价：￥{{ $demand->price }}</p>
                        <p>竞价商家：{{ count($demand->bids)?count($demand->bids):'暂无' }}</p>
                        <p>距离结束：{{ $demand->getexptime() }}</p>
                        <a href="{{ URL::to('demand/show/'.$demand->id) }}" class="btn btn-danger">竞价详情
                            <i class="fa fa-angle-right"></i></a>
                    </div>
                </div>
                @endforeach
                @else
                <div class="row" style="border: none;">

                    <div style="width: 400px;height: 120px;margin: 0 auto;padding-top: 150px;padding-bottom: 300px; ">
                        <img src="/images/emptycart.jpg" style="width: 115px;height: 88px;margin-right: 20px;float:left;"  >

                        <p style="width: 200px;height: 120px;float: left;padding-top: 40px;font-size: 14px;">
                            没有正在竞价的商品哦,马上发布成为第一个吧<br />
                            <a href="/demand/post/">点此发布&gt;</a>
                        </p>

                    </div>
                </div>
                @endif

                <?php echo $demands->render(); ?>

            </div>
        </div>


    </div>



</div>



<script type="text/javascript">
    $(function(){
        $('#more').more({'address': 'data.php'})
    });
</script>
<style>
    /*  .get_more{display: none;}*/
</style>

<a href="javascript:;" class="get_more">&nbsp;</a>


<script id="itemTemplate" type="text/template">
    <span id="[[itemId]]" class="search-container-item">[[text]]</span>
</script>
<script id="brandItemTemplate" type="text/template">
    <span id="[[brandItemId]]" class="brand-item">[[text]]</span>
</script>
<script id="smallCategoryTemplate" type="text/template">
    <div id="[[smallCategoryId]]" class="small-category">
        <div class="item-container"></div>
    </div>
</script>

<script>
    !function () {
        _.templateSettings = {
            interpolate: /\[\[(.+?)]]/g
        };
        var $productContainer = $('.product-container');
        var $searchCondition = $('.search-condition');

        var productManage = new ProductManage($productContainer, $searchCondition);

        // 品牌回调
        productManage.brandCallback(function (id, text) {
            var brandItems = [];

            var str = id;
            var itemid = str.substr(str.lastIndexOf("_")+1);

            $.ajax({
                type: "GET",
                url: "/ajax/ajax_brand",
                data: {id: itemid,rnd:Math.random()},
                dataType: "json",
                async : false,
                success: function(data){
                    for(var i = 0; i <data.length; i++)
                    {
                        var item=data[i];

                        brandItems.push({
                            id: '__brandItem_' + item.cate_id  ,
                            text: item.cate_name
                        });

                    }
                }
            });

            return brandItems;
        });


        //产品选择完毕
        productManage.addListener('close', function (productInfo) {
            // console.log(productInfo);

            if(productInfo.selectProduct.length==0)return;

            var skey=$('#s_key').val();


            var ids="";

            for (var pi = 0; pi < productInfo.selectProduct.length; pi++) {

                var products = productInfo.selectProduct[pi];//选择的产品分类
                for (var i = 0; i < products.length; i++) {
                    var str = products[i];
                    var itemid = str.substr(str.lastIndexOf("_") + 1);
                    ids += itemid + ",";

                }
            }

            catids=ids;//给全局变量赋值

            $("#unicontent").empty();
            $.ajax({
                type: "GET",
                url: "/ajax/ajax_demand",
                data: {id: ids,rnd:Math.random(),key:skey},
                dataType: "json",
                async : false,
                success: function(data){
                    for (var i = 0; i < data.length; i++) {
                        var item = data[i];


                        var src = "<div class='row'>";
                        src += "<div class='d-list-sn'><span>订单编号："+item.sn+"</span>";
                        src += "	<span>提交时间："+item.paytime+"</span>";
                        src += "	    <span class='d-author'><a href='#'>admin</a></span></div> ";
                        src += "    <div class='col-xs-2'><img src='/"+item.thumb+"'></div>	 ";
                        src += "	    <div class='col-xs-7 d-list-title'> ";
                        src += "<h4><a href='/demand/show/"+item.id+"' >";
                        src += item.title+"</a></h4>";
                        src += "<a href='"+item.url+"' ";
                        src += "target='_blank' rel='nofollow'>点击进入竞价对照商品页面</a> </div>	 ";
                        src += "    <div class='col-xs-3 d-list-info'>	 ";
                        src += "	<p>初始竞价：￥"+item.price+"</p>	 ";
                        src += "		<p>竞价商家："+item.bidnum+"</p> ";
                        src += "		<p>距离结束："+item.exptime+"</p> ";
                        src += "	    <a href='/demand/show/"+item.id+"' class='btn btn-danger'>竞价详情 ";
                        src += "		<i class='fa fa-angle-right'></i></a> ";
                        src += "</div> ";
                        src += "</div> ";



                        $("#unicontent").append(src);


                        console.log(item);

                    }
                }
            });






        });

        productManage.addListener('brand', function (productInfo) {

            console.log(productInfo);
            var str= productInfo.smallCategoryId;//选择的产品分类
            var cateid = str.substr(str.lastIndexOf("-")+1);
            cateid = cateid.substr(cateid.lastIndexOf("_")+1);

            var bids="";
            var brands= productInfo.selectedBrand;//选择的产品分类
            for(var i=0;i<brands.length;i++)
            {
                var str = brands[i];
                var itemid = str.substr(str.lastIndexOf("-")+1);
                itemid = itemid.substr(itemid.lastIndexOf("_")+1);
                if(itemid=="all")
                {
                    bids="";
                    break;
                }
                bids+=itemid+",";

            }
            brandids=bids;//全局的品牌编号列表



            var skey=$('#s_key').val();

            $("#unicontent").empty();//清除先前的内容

            $(".fakeloader").fakeLoader();
            $.ajax({
                type: "GET",
                url: "/ajax/ajax_demand",
                data: {id: cateid,bid:bids,rnd:Math.random(),key:skey},
                dataType: "json",
                async : false,
                success: function(data){
                    for (var i = 0; i < data.length; i++) {
                        var item = data[i];
                        var src = "<div class='row'>";
                        src += "<div class='d-list-sn'><span>订单编号："+item.sn+"</span>";
                        src += "	<span>提交时间："+item.paytime+"</span>";
                        src += "	    <span class='d-author'><a href='#'>admin</a></span></div> ";
                        src += "    <div class='col-xs-2'><img src='/"+item.thumb+"'></div>	 ";
                        src += "	    <div class='col-xs-7 d-list-title'> ";
                        src += "<h4><a href='/demand/show/"+item.id+"' >";
                        src += item.title+"</a></h4>";
                        src += "<a href='"+item.url+"' ";
                        src += "target='_blank' rel='nofollow'>点击进入竞价对照商品页面</a> </div>	 ";
                        src += "    <div class='col-xs-3 d-list-info'>	 ";
                        src += "	<p>初始竞价：￥"+item.price+"</p>	 ";
                        src += "		<p>竞价商家："+item.bidnum+"</p> ";
                        src += "		<p>距离结束："+item.exptime+"</p> ";
                        src += "	    <a href='/demand/show/"+item.id+"' class='btn btn-danger'>竞价详情 ";
                        src += "		<i class='fa fa-angle-right'></i></a> ";
                        src += "</div> ";
                        src += "</div> ";



                        $("#unicontent").append(src);


                        console.log(item);

                    }
                }
            });

            $(".fakeloader").fadeOut();






        });

        $('#productInfo').click(function () {
            console.log(productManage.getProductInfo());

        });

        productManage.addListener('searchItemClicked', function (type, productInfo) {
            console.log(type);
            console.log(productInfo);
            var str = productInfo.smallCategoryId;
            var cateid = str.substr(str.lastIndexOf("-") + 1);
            cateid = cateid.substr(cateid.lastIndexOf("_") + 1);
            var skey=$('#s_key').val();
            $("#unicontent").empty();
            $.ajax({
                type: "GET",
                url: "/ajax/ajax_demand",
                data: {id: cateid, rnd: Math.random(), key: skey},
                dataType: "json",
                async: false,
                success: function (data) {
                    for (var i = 0; i < data.length; i++) {
                        var item = data[i];


                        var src = "<div class='row'>";
                        src += "<div class='d-list-sn'><span>订单编号：" + item.sn + "</span>";
                        src += "	<span>提交时间：" + item.paytime + "</span>";
                        src += "	    <span class='d-author'><a href='#'>admin</a></span></div> ";
                        src += "    <div class='col-xs-2'><img src='/" + item.thumb + "'></div>	 ";
                        src += "	    <div class='col-xs-7 d-list-title'> ";
                        src += "<h4><a href='/demand/show/" + item.id + "' >";
                        src += item.title + "</a></h4>";
                        src += "<a href='" + item.url + "' ";
                        src += "target='_blank' rel='nofollow'>点击进入竞价对照商品页面</a> </div>	 ";
                        src += "    <div class='col-xs-3 d-list-info'>	 ";
                        src += "	<p>初始竞价：￥" + item.price + "</p>	 ";
                        src += "		<p>竞价商家：" + item.bidnum + "</p> ";
                        src += "		<p>距离结束：" + item.exptime + "</p> ";
                        src += "	    <a href='/demand/show/" + item.id + "' class='btn btn-danger'>竞价详情 ";
                        src += "		<i class='fa fa-angle-right'></i></a> ";
                        src += "</div> ";
                        src += "</div> ";


                        $("#unicontent").append(src);


                        console.log(item);
                    }
                }
            });

        });



    }();
</script>




<div class="copyright">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <a href="#"   hidefocus="true"  >关于我们</a>
                <a href="#"   hidefocus="true"  >加入51竞购</a>
                <a href="#"  hidefocus="true"  >联系我们</a>
                <span>Copyright &copy; 2015 www.51jinggou.com All Rights Reserved</span>
                <span>杭州竟商网络有限公司 浙ICP备09032634</span>
            </div>
        </div>
    </div>
</div>
<a href="#" id="back-to-top"><i class="fa fa-angle-up"></i></a>
<!-- 最新的 Bootstrap 核心 JavaScript3.3.5 文件 -->
<script src="{{ url('/js/bootstrap.min.js') }}"></script>
<script src="{{ url('/js/jquery.validate.js') }}"></script>
<script src="{{ url('/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ url('/js/locales/bootstrap-datepicker.zh-CN.min.js') }}"></script>
@yield('script')
<script src="{{ url('/js/script.js') }}"></script>

@if (count($errors) > 0)
<div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content alert-danger alert">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">&nbsp;</h4>
            </div>
            <div class="modal-body">
                <p class="">
                    @foreach ($errors->all() as $error)
                    {{ $error }}
                    @endforeach
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">确定</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script type="text/javascript">
    $('#errorModal').modal('show');
</script>
@endif



</body>
</html>