@extends('layouts.master')
@section('title')
    支付订金 - {{$demand->title}} - @parent
@stop
@section('content')
    <div class="page-pay-deposit">
        <!-- Page Content -->
        <div class="container">
                <!-- Page Heading/Breadcrumbs -->
                <div class="row">
                    <div class="col-xs-12">
                        <ol class="breadcrumb">
                            <li>当前位置：</li>
                            <li><a href="/">首页</a></li>
                            <li><a href="/demand/my">我的竞购</a></li>
                            <li><a href="/demand/show/{{ $demand->id }}">{{ $demand->title }}</a></li>
                            <li class="active">支付订金</li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->

            <br>
                <!-- Portfolio Item Row -->
                <div class="row pay-deposit-box" style="width: 960px;margin: 0 auto;">
                    <div class="col-lg-12">
                    <form method="post" action="" target="_blank">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="row text-center">
                            <div class="col-md-2"> </div>
                            <div class="col-md-2"><hr></div>
                            <div class="col-md-3"><h1>支付订金</h1></div>
                            <div class="col-md-2"><hr></div>
                            <div class="col-md-2"> </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4"> </div>
                            <div class="col-md-4 text-center"><h3>&nbsp;</h3></div>

                        </div>
                        <div class="row" style="border: 1px solid #dcdcdc;">


                        <style type="text/css">

                            table{ text-align: left; }
                            input[type=radio], input[type=checkbox] { outline: none;}
                            #mytable { width: 100%; padding: 0; margin: 0;}
                            #mytable th {
                                font: bold 11px "Trebuchet MS", Verdana, Arial, Helvetica, sans-serif;
                                color: #4f6b72;
                                border-right: 1px solid #AFD5F3;
                                border-bottom: 1px solid #AFD5F3;
                                border-top: 1px solid #AFD5F3;
                                letter-spacing: 2px;
                                text-transform: uppercase;
                                text-align: left;
                                padding: 6px 6px 6px 12px;
                                background: #E6F3FB  no-repeat;
                            }



                            #mytable td {
                                border-right: 1px solid #C1DAD7;
                                border-bottom: 1px solid #C1DAD7;
                                background: #fff;
                                font-size:11px;
                                padding: 6px 6px 6px 12px;
                                color: #4f6b72;
                            }

                            td{border:none;  padding: 6px 6px 6px 12px;}


                            td.alt {
                                background: #F5FAFA;
                                color: #797268;
                            }

                            th.spec {
                                border-left: 1px solid #C1DAD7;
                                border-top: 0;
                                background: #fff no-repeat;
                                font: bold 10px "Trebuchet MS", Verdana, Arial, Helvetica, sans-serif;
                            }

                            .listtable {
                                font-size: 12px;
                                line-height: 20px;
                                padding-bottom: 80px;
                            }
                            .font_price {
                                font-size: 18px;
                                font-family: Arial, Helvetica, sans-serif;
                                color: #cc0000;
                                line-height: 25px;
                            }



                            .cart_TabContent
                            {
                                padding: 0px 0 20px 50px;
                                float: left;
                                width: 840px;
                                color: #474747;
                                text-align: left;
                                line-height: 20px;
                            }
                            .cart_TabContent ul
                            {
                                width: 100%;
                            }
                            .cart_TabContent li
                            {
                                float: left;
                                width: 280px;
                                padding-bottom: 10px;
                                height: 43px;
                            }
                            .payment_content_bgwhite {
                                width: 840px;
                                margin: 0 auto;
                                overflow: hidden;
                                margin-top: 10px;
                                font-size: 14px;
                                color: #CC0000;
                            }

                            span.icon-bank {
                                width: 142px;
                                height: 31px;
                                border: solid 1px #ddd;
                                display: inline-block;
                            }

                            [class^="icon-"], [class*=" icon-"] {
                                font-family: 'iconfont';
                                speak: none;
                                font-style: normal;
                                font-weight: 400;
                                font-variant: normal;
                                text-transform: none;
                                line-height: 1;
                                -webkit-font-smoothing: antialiased;
                                -moz-osx-font-smoothing: grayscale;
                            }
                            [class^="icon-"], [class*=" icon-"] {
                                font-family: 'aliyun-console-font' !important;
                            }
                            .bank-alipay, .bank-icbc, .bank-ccb, .bank-abchina, .bank-psbc, .bank-bankcomm, .bank-cmbchina, .bank-boc, .bank-cebbank, .bank-ecitic, .bank-spdb, .bank-cmbc, .bank-cib, .bank-pingan, .bank-cgbchina, .bank-srcb, .bank-bankofshanghai, .bank-nbcb, .bank-hccb, .bank-bankofbeijing, .bank-bjrcb, .bank-fudian-bank, .bank-wzcb {
                                background: url("/images/T17IKqFbXeXXbb9.QQ-442-311.png") no-repeat;
                            }
                            li, ol, span, ul {
                                margin: 0;
                                padding: 0;
                                border: 0;
                                vertical-align: baseline;
                                list-style: none;
                            }
                            .bank-alipay{background-position: 0 0;}
                            .bank-icbc{background-position: -150px 0;}
                            .bank-ccb{background-position: -300px 0;}
                            .bank-abchina{background-position: 0 -40px;}
                            .bank-psbc{background-position: -150px -40px;}
                            .bank-bankcomm{background-position: -300px -40px;}
                            .bank-cmbchina{background-position: 0 -80px;}
                            .bank-boc{background-position: -150px -80px;}
                            .bank-cebbank{background-position: -300px -80px;}
                            .bank-ecitic{background-position: 0 -120px;}
                            .bank-spdb{background-position: -150px -120px;}
                            .bank-cmbc{background-position: -300px -120px;}
                            .bank-cib{background-position: 0 -160px;}
                            .bank-pingan{background-position: -150px -160px;}
                            .bank-cgbchina{background-position: -300px -160px;}
                            .bank-srcb{background-position: 0 -200px;}
                            .bank-bankofshanghai{background-position: -150px -200px;}
                            .bank-nbcb{background-position: -300px -200px;}
                            .bank-hccb{background-position: 0 -240px;}
                            .bank-bankofbeijing{background-position: -150px -240px;}
                            .bank-bjrcb{background-position: -300px -240px;}
                            .bank-fudian-bank{background-position: 0 -280px;}
                            .bank-wzcb{background-position: -150px -280px;}


                        </style>

                        <table width="98%" border="0" cellspacing="1" cellpadding="2" align="left" class="listtable">
                            <tbody>

                            <tr class="listnr">
                                <td align="left" style="padding-top: 20px;">
                                    <span style="font-weight:bold;">您要支付的中标商品货款</span>
                                </td>
                            </tr>
                            <tr class="listnr">
                                <td align="left">
                                    <table id="mytable" cellspacing="0">
                                        <caption> </caption>
                                        <tr>
                                            <th scope="col" style="border-left: 1px solid #afd5f3;">竞购编号</th>
                                            <th scope="col">竞购编号详情</th>
                                            <th scope="col">应付金额</th>
                                        <th scope="col">发布时间</th>
                                        </tr>
                                        <tr>
                                            <td class="row"  style="border-left: 1px solid #afd5f3;">{{$demand->sn}}</td>
                                            <td class="row">
                                                <a href="{{ URL::to('demand/show/'.$demand->id) }}">查看竞购详情</a>
                                            </td>
                                        <td class="row"><span class="font_price order_money" id="order_money">
                                                {{ $deposit }}</span>元</td>
                                        <td class="row">{{$demand->addtime}}</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>

                            <tr class="listnr"><td height="20">&nbsp;</td>
                            </tr>
                            <tr class="listnr"><td height="20" align="left"> <span style="font-weight: bold;
                        font-family:'Microsoft YaHei','Hiragino Sans GB',Helvetica,Arial,'Lucida Grande',sans-serif;"> 请选择支付方式</span> </td>
                            </tr>

                            <tr class="listnr">
                                <td align="left" style="padding-left: 64px;">
                                    <input type="radio" name="pay_type" value="weixin"   />
                                    <img src="/images/bank/pay-weixin.jpg" align="absmiddle"  style="border: solid 1px #ddd;">
                                </td>
                            </tr>

                            <tr class="listnr">
                                <td align="left" style="padding-left: 64px;">
                                    <input type="radio" name="pay_type" value="alipay" checked="checked"  />
                                    <img src="/images/bank/alipaylogo.jpg" align="absmiddle" style="border: solid 1px #ddd;">
                                </td>
                            </tr>

                            <tr class="listnr">
                                <td>
                                    <div class="cart_TabContent" id="onlineContent">
                                        <div id="C2bBanksBox" class="payment_content_bgwhite" style="display: block;">
                                            <ul>
                                                <li><label>
                                                        <input id="bank-abchina" class="bank-input" type="radio" value="ABC" name="pay_type">
                                                        <span for="bank-abchina" class="icon-bank bank-abchina bankLogo" bankid="ABC"></span>
                                                    </label></li>

                                                <li><label>
                                                        <input id="bank-psbc" class="bank-input" name="pay_type" type="radio" value="POSTGC">
                                                        <span for="bank-psbc" class="icon-bank bank-psbc bankLogo" bankid="POSTGC"></span>
                                                    </label></li>

                                                <li><label>
                                                        <input id="bank-bankcomm" class="bank-input" type="radio" value="COMM" name="pay_type">
                                                        <span for="bank-bankcomm" class="icon-bank bank-bankcomm bankLogo" bankid="COMM"></span>
                                                    </label></li>


                                                <li><label>
                                                        <input id="bank-cmbchina" class="bank-input" name="pay_type" type="radio" value="CMB">
                                                        <span for="bank-cmbchina" class="icon-bank bank-cmbchina bankLogo" bankid="CMB"></span>
                                                    </label></li>

                                                <li><label>
                                                        <input id="bank-boc" class="bank-input" name="pay_type" type="radio" value="BOCB2C">
                                                        <span for="bank-boc" class="icon-bank bank-boc bankLogo" bankid="BOCB2C"></span>
                                                    </label></li>
                                                <li><label>
                                                        <input id="bank-ecitic" class="bank-input" type="radio" value="CITIC-DEBIT" name="pay_type">
                                                        <span for="bank-ecitic" class="icon-bank bank-ecitic bankLogo" bankid="CITIC-DEBIT"></span>
                                                    </label></li>

                                                <li><label>
                                                        <input id="bank-spdb" class="bank-input" type="radio" value="SPDB" name="pay_type">
                                                        <span for="bank-spdb" class="icon-bank bank-spdb bankLogo" bankid="SPDB"></span>
                                                    </label></li>
                                                <li><label>
                                                        <input id="bank-cmbc" class="bank-input" type="radio" value="CMBC" name="pay_type">
                                                        <span for="bank-cmbc" class="icon-bank bank-cmbc bankLogo" bankid="CMBC"></span>
                                                    </label></li>

                                                <li><label>
                                                        <input id="bank-cib" class="bank-input" type="radio" value="CIB" name="pay_type">
                                                        <span for="bank-cib" class="icon-bank bank-cib bankLogo" bankid="CIB"></span>
                                                    </label></li>

                                                <li><label>
                                                        <input id="bank-pingan" class="bank-input" name="pay_type" type="radio" value="SPABANK">
                                                        <span for="bank-pingan" class="icon-bank bank-pingan bankLogo" bankid="SPABANK"></span>
                                                    </label></li>
                                                <li><label>
                                                        <input id="bank-cgbchina" class="bank-input" type="radio" value="GDB" name="pay_type">
                                                        <span for="bank-cgbchina" class="icon-bank bank-cgbchina bankLogo" bankid="GDB"></span>
                                                    </label></li>
                                                <!--借记卡 -->
                                                <li><label>
                                                        <input id="bank-srcb" class="bank-input" name="pay_type" type="radio" value="SHRCB">
                                                        <span for="bank-srcb" class="icon-bank bank-srcb bankLogo" bankid="SHRCB"></span>
                                                    </label></li>
                                                <li><label>
                                                        <input id="bank-bankofshanghai" class="bank-input" name="pay_type" type="radio" value="SHBANK">
                                                        <span for="bank-bankofshanghai" class="icon-bank bank-bankofshanghai bankLogo" bankid="SHBANK"></span>
                                                    </label></li>
                                                <li><label>
                                                        <input id="bank-nbcb" class="bank-input" name="pay_type" type="radio" value="NBBANK">
                                                        <span for="bank-nbcb" class="icon-bank bank-nbcb bankLogo" bankid="NBBANK"></span>
                                                    </label></li>
                                                <li><label>
                                                        <input id="bank-hccb" class="bank-input" name="pay_type" type="radio" value="HZCBB2C">
                                                        <span for="bank-hccb" class="icon-bank bank-hccb bankLogo" bankid="HZCBB2C"></span>
                                                    </label></li>
                                                <li><label>
                                                        <input id="bank-bankofbeijing" class="bank-input" name="pay_type" type="radio" value="BJBANK">
                                                        <span for="bank-bankofbeijing" class="icon-bank bank-bankofbeijing bankLogo" bankid="BJBANK"></span>
                                                    </label></li>
                                                <li><label>
                                                        <input id="bank-bjrcb" class="bank-input" name="pay_type" type="radio" value="BJRCB">
                                                        <span for="bank-bjrcb" class="icon-bank bank-bjrcb bankLogo" bankid="BJRCB"></span>
                                                    </label></li>
                                                <li><label>
                                                        <input id="bank-fudian-bank" class="bank-input" name="pay_type" type="radio" value="FDB">
                                                        <span for="bank-fudian-bank" class="icon-bank bank-fudian-bank bankLogo" bankid="FDB"></span>
                                                    </label></li>
                                                <li><label>
                                                        <input id="bank-wzcb" class="bank-input" name="pay_type" type="radio" value="WZCBB2C-DEBIT">
                                                        <span for="bank-wzcb" class="icon-bank bank-wzcb bankLogo" bankid="WZCBB2C-DEBIT"></span>
                                                    </label></li>


                                                <li><label>
                                                        <input id="bank-icbc" class="bank-input" type="radio" value="ICBCB2C" name="pay_type">
                                                        <span for="bank-icbc" class="icon-bank bank-icbc bankLogo" bankid="ICBCB2C"></span>
                                                    </label></li>

                                                <li><label>
                                                        <input id="bank-ccb" class="bank-input" name="pay_type" type="radio" value="CCB">
                                                        <span for="bank-ccb" class="icon-bank bank-ccb bankLogo" bankid="CCB"></span>
                                                    </label></li>


                                            </ul>
                                        </div>
                                        <div id="B2bBanksBox" class="payment_content_bgwhite" style="display: none;">
                                            <ul>
                                                <li><label>
                                                        <input id="bank-ccbbtb" class="bank-input" name="B2BBankID" type="radio" value="CCBBTB">
                                                        <span for="bank-ccbbtb" class="icon-bank bank-ccb bankLogo" bankid="CCBBTB" alt="建设银行"></span>
                                                    </label></li>
                                                <li><label>
                                                        <input id="bank-abcbtb" class="bank-input" name="B2BBankID" type="radio" value="ABCBTB">
                                                        <span for="bank-abcbtb" class="icon-bank bank-abchina bankLogo" bankid="ABCBTB" alt="中国农业银行"></span>
                                                    </label></li>

                                                <li><label>
                                                        <input id="bank-spdbb2b" class="bank-input" name="B2BBankID" type="radio" value="SPDBB2B">
                                                        <span for="bank-spdbb2b" class="icon-bank bank-spdb bankLogo" bankid="SPDBB2B" alt="浦发银行"></span>
                                                    </label></li>

                                                <li><label>
                                                        <input id="bank-icbcbtb" class="bank-input" name="B2BBankID" type="radio" value="ICBCBTB">
                                                        <span for="bank-icbcbtb" class="icon-bank bank-icbc bankLogo" bankid="ICBCBTB" alt="中国工商银行"></span>
                                                    </label></li>

                                            </ul>
                                        </div>
                                    </div>


                                </td>
                            </tr>
                            </tbody>

                        </table>



                        <div class="col-md-11 text-left" style="margin-top: 40px;padding-left: 80px;height: 64px;
                        line-height: 64px;background: #F7F7F7;margin-left: 20px;font-weight: bold;font-size: 12px;font-family:'Microsoft YaHei';">
                          <span>应付金额</span><span style="color: #FF0000">14</span>  <span>元</span>
                        </div>



                        <div class="col-md-12 text-center" style="margin-top: 40px;margin-bottom: 40px;">
                            <button type="submit" class="btn   btn-lg" style="background: #FE6501;border: #FE6501;border-radius: 0px;
                            color: #ffffff;
                            ">立即支付</button>
                        </div>


                        </div>

                    </form>
                    </div>
                </div>
                <!-- /.row -->
                <br>



        </div>
        <!-- /.container -->
    </div>
@stop