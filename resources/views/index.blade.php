@extends('layouts.master')
@section('title')
    @parent
@stop
@section('content')

    <!-- Header Carousel -->
    <header id="myCarousel" class="carousel slide">

        <!-- Wrapper for slides -->
        <div class="carousel-inner">
            <div class="item active">
                <div class="fill" style="background-image:url('{{ url('/img/banner1.jpg') }}');"></div>
            </div>
        </div>
    </header>
    <div class=" page-index">
	    <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <h1 class="page-header">
                        来51竞购，完美你的网购
                    </h1>
                    <p class="lead">　　2004年，淘宝诞生，从此我们和商品只隔着网络！但今天，网络已变得如此庞大，买家商家的信息不对称再次来袭，购物又不再是一件轻松事情。</p>
                    <p class="lead">　　现在，51竞购来了。选定了一种商品，付款之前，来51竞购让商家再来竞价一次，挤挤水分，再给自己一次8折、7折的机会，这样的购物，才是完美的购物。</p>
                </div>


            </div>
	    </div>
        <hr>
        <div class="container">
            <div class="row index-qa">
                <img src="img/index-qa.jpg">
            </div>
            <div class="row">
                <div class="col-xs-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4>Q:我应该在购物的什么阶段发布竞价？</h4>
                        </div>
                        <div class="panel-body">
                            <p>A：确定购买阶段。也就是商品、品牌、价格已经选定，下单前您来51竞购发布竞价，争取最后一次7折、8折的机会。</p>
                        </div>
                    </div>
                </div>
                <div class="col-xs-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4>Q:我购买所有商品都可以发布竞购吗？</h4>
                        </div>
                        <div class="panel-body">
                            <p>A：不是。品牌型号确定的商品适合发布竞购，如品牌加点、3C等，这些商品能让商家在同一标准下竞价。个性服装、鞋包及商家自产自销的商品不适合竞价。</p>
                            <a class="" href="#">详细请查询</a>
                        </div>
                    </div>
                </div>
                <div class="col-xs-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4>Q:什么是起竟价格？</h4>
                        </div>
                        <div class="panel-body">
                            <p>A：您发布的竞价商品，卖家的报价就是起竟价格。</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4>Q:什么是竞价成功？</h4>
                        </div>
                        <div class="panel-body">
                            <p>A：参加竞价的商家发布的竞价中，有二个或二个以上竞价低于起竟价格10%，本次竞价成功。</p>
                        </div>
                    </div>
                </div>
                <div class="col-xs-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4>Q:竞价成功，我必须要选择购买吗？</h4>
                        </div>
                        <div class="panel-body">
                            <p>A：是的，竞价成功，买家应该选择购买，也只有真实的购买，商家才会认真竞价，最终买家受益。</p>
                        </div>
                    </div>
                </div>
                <div class="col-xs-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4>Q:竞价购买的商品能保证质量吗？</h4>
                        </div>
                        <div class="panel-body">
                            <p>A：我们对参加竞购的商家资质有严格的审核，竞价成功后，您的货款由51竞购代保管，只有您确认收货并满意后才会付款。</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="container">
            <div class="row index-invest">
                <div class="col-xs-12">
                    <h2 class="page-header">
                        51竞购，值得您的期待!
                    </h2>
                    <p><a class="btn btn-success" href="mailto:invest@51jinggou.com">投资合作<em>invest@51jinggou.com</em></a> </p>
                </div>
            </div>
        </div>
    </div>
@stop