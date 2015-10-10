@extends('layouts.master')
@section('title')
    {{Lang::get('layout.PostDemand')}} - @parent
@stop
@section('content')

<link href="/acss/style.css" rel="stylesheet" type="text/css">
<script src="/ajs/lib/jquery.js"></script>
<script src="/ajs/lib/underscore.js"></script>
<!--<script src="../../res/js/bootstrap.js"></script>-->
<script src="/ajs/util/arrayUtil.js"></script>
<script src="/ajs/BrandItem.js"></script>
<script src="/ajs/Brand.js"></script>
<script src="/ajs/SearchBox.js"></script>
<script src="/ajs/Item.js"></script>
<script src="/ajs/SmallCategory.js"></script>
<script src="/ajs/BigCategory.js"></script>
<script src="/ajs/AllCategory.js"></script>
<script src="/ajs/ProductManage.js"></script>

    <div class="page-demand-post">
	    <div class="container">
            <div class="col-xs-3 side-bar">
                <div class="list-group">
                    <a class="list-group-item active" href="{{ url('demand/post') }}">发布竞购</a>
                    <a class="list-group-item" href="{{ url('demand/my') }}">我的竞购</a>
                    <a class="list-group-item" href="{{ url('bidder/fav') }}">商家收藏</a>
                </div>
            </div>


            <div class="row">
            <form class="form-horizontal" role="form" method="POST" action="{{ url('/demand/post') }}" id="demand-post-form">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">




            <div class="col-xs-9 topics-show main-col">


            <div class="product-container" style="padding-bottom: 12px;">
                <div class="search-condition">
                    <div class="item-container form-control">
                        <span class="addTip">点此添加商品名称</span>
                    </div>
                    <input type="hidden"  id="esCate" name="esCate" />
                    <div class="empty-product-item-tip" style="display: none;">*请先选择商品品种</div>
                </div>
                <div class="search-menu-list clearfix">
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
                                    <dt><span id="{{$one['name']}}_{{$one['id']}}"   class="item">{{$one['slug']}}</span></dt>
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
                <div id="selectBrand" class="select-brand">
                    <div class="select-brand-tip  form-control">
                        <span>请选择品牌</span>
                    </div>
                    <input type="hidden"  id="esbrand" name="esbrand" />
                </div>
                <div class="product-brand">
                    <div class="clearfix">
                        <div class="brand-text">
                            <label class="brand-name">品牌</label>
                            <label class="colonArea">：</label>
                        </div>
                        <div class="brand-items">
                            <!--<div id="brand-item-all" class="brand-item">全部</div>-->
                        </div>
                        <span class="brand-more">
                            更多<span class="glyphicon glyphicon-chevron-down"></span>
                        </span>
                    </div>
                </div>


            </div>


            <template id="itemTemplate">
                <span id="[[itemId]]" class="product-item">[[text]]</span>
            </template>
            <template id="brandItemTemplate">
                <span id="[[brandItemId]]" class="brand-item">[[text]]</span>
            </template>
            <template id="selectedBrandTemplate">
                <span data-id="[[selectedBrandItemId]]">[[selectedBrandItemName]]</span>
            </template>

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
                        var i, brandItems = [];

                        /*    for (i = 0; i < 40; i++) {
                         brandItems.push({
                         id: '__brandItem_' + id + i,
                         text: text + i
                         })
                         }
                         return brandItems;*/

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

                    productManage.addListener('brand', function (productInfo) {
                        console.log(productInfo);

                        var str= productInfo.selectProduct;//选择的产品分类
                        var cateid = str.substr(str.lastIndexOf("-")+1);
                        cateid = cateid.substr(cateid.lastIndexOf("_")+1);

                        var brands= productInfo.selectedBrand;//选择的产品分类
                        var brandid = brands.substr(brands.lastIndexOf("-")+1);
                        brandid = brandid.substr(brandid.lastIndexOf("_")+1);

                        $('#esCate').val(cateid);
                        $('#esbrand').val(brandid);



                    });
                    $('#get').click(function () {
                        var productInfo = productManage.getProductInfo();
                        console.log(productInfo);
                    });
                }();
            </script>


                        <div class="form-group get-info">
                            <div class="col-xs-8">
                                <input type="text" placeholder="输入竞价商品链接" class="form-control" name="url" value="{{ old('url') }}" id="url">
                                <input type="hidden" name="isInfo" id="isInfo" value="0">
                            </div>
                            <div class="col-xs-2">
                                <button type="button" data-loading-text="获取中..." class="btn btn-success" id="getInfo">获取信息</button></div>
                        </div>
                        <div class="info-box col-xs-12" id="info-box">

                            <div class="form-group">
                                <div class="col-xs-8">
                                    <input type="text" class="form-control" name="title" id="title" value="{{ old('title') }}">
                                </div>
                                <div class="col-xs-2"></div>
                            </div>

                            <div class="form-group">

                                <div class="col-xs-2">
                                    <input type="text" placeholder="输入总价商品竞价起始价格" class="form-control" name="price" id="price" value="{{ old('price') }}">
                                </div>
                                <div class="col-xs-2"></div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-2" id="goods-img">
                                    <input type="hidden" class="form-control" name="thumb" id="thumb" value="{{ old('thumb') }}">
                                    <img src="{{ url("/img/blank.gif") }}" width="300" height="300" id="goods-pic">
                                </div>
                                <div class="col-xs-2"></div>
                            </div>
                        </div>
                        <div class="form-group">

                                <div class="col-xs-8">
                                    <select name="avltime" id="avltime" class="form-control" min="20" >
                                        <option value="0">选择竞价时间</option>
                                        <option value="24">24</option>
                                        <option value="48">48</option>
                                        <option value="72">72</option>
                                        <option value="96">96</option>
                                    </select>


                                </div>
                            <div class="col-xs-2"></div>
                        </div>
                        <div class="form-group">
                                <div class="col-xs-8">
                                    <textarea type="text" class="form-control" name="details" rows="4">{{ old('details') }}</textarea>
                                </div>
                            <div class="col-xs-2"></div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6 col-xs-offset-5">
                                <button type="submit" class="btn btn-primary">{{Lang::get('layout.Submit')}}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
	    </div>
    </div>
@stop