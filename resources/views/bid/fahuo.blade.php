@extends('layouts.master')
@section('title')
我的竞购 - @parent
@stop
@section('content')

<style>
    .page-demand-my .row{border: none; margin-bottom:0px; }
</style>

<div class="page-demand-my">
    <div class="container" style="padding-left: 125px;">


        <div class="row text-center">
            <div class="col-md-2"> </div>
            <div class="col-md-2"><hr style=" margin-top: 38px;color: #e2e2e2;border: 1px solid #e2e2e2;"></div>
            <div class="col-md-4"><h1>确认收货信息</h1></div>
            <div class="col-md-2"><hr style=" margin-top: 38px;color: #e2e2e2;border: 1px solid #e2e2e2;"></div>
            <div class="col-md-2"> </div>
        </div>


        <div class="col-md-12">
            <div class="row">
                <form action="" method="post">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <input type="hidden" name="deid" value="{{$demand->id}}">

                    @if($addr)
                    <div id="select-address" >
                        <div class="title w mb10" style="padding-top: 10px;">
                            <b class="fs15">收货人地址信息</b>
                        </div>
                        <div class="title w mb10" style="padding-top: 40px;padding-bottom: 30px;padding-left: 42px;">
                            <span style="color: #676767">{{$addr->name}} &nbsp; {{$addr->fulladdr}} </span>
                            &nbsp; <span style="color: #000"> {{$addr->mobile}} </span>
                        </div>
                    </div>



                    <div class="title w mb10" style="padding-bottom: 13px;">
                        <b class="fs15">收货人地址信息</b>
                    </div>









                    <style>

                        body{font-size: 12px;  font-family:'Microsoft YaHei';  }
                        input[type=radio],input[type=checkbox] {
                            margin: 4px 5px 5px;
                            margin-top: 1px \9;
                            line-height: normal
                        }

                        dl {
                            margin-top: 0;
                            margin-bottom: 0px;
                        }
                        #select-address .title {
                            line-height: 30px;
                            font-size: 12px;
                        }
                        .title a {
                            color: #0033CC;
                            text-decoration: none;
                        }
                        #select-address dl {
                            padding: 5px 0 5px 0;
                            cursor: pointer;
                            width: 100%;
                        }

                        .clearfix:after{ content:'\20'; display:block; overflow:hidden; height:0; clear:both;}
                        .clearboth{ clear:both;}

                        .newaddressform .fill_in_content {
                            margin-left:5px;
                            border: 1px #DEE9F1 solid;
                            padding: 20px;
                            font-size: 12px;
                        }
                        ul, ol {list-style: none;}

                        .newaddressform .fill_in_content li {
                            height: 36px;
                            line-height: 36px;
                            clear: both;
                        }
                        .newaddressform .fill_in_content input {
                            line-height: 17px;
                        }
                        #select-address .field_notice {
                            color: #9C9C9C;
                            margin-left: 5px;
                        }
                        input, button, select, textarea {
                            outline: none;
                        }
                        input, select {
                            vertical-align: middle;
                        }
                        .float-left {
                            float: left;
                        }
                        .a_tips{width: 86px;height: 33px;display: block;float:left; text-align: right; }
                        .a_tips b{color: #f00;margin:0px 2px;}

                    </style>


                    <div class="newaddressform w">
                        <ul class="fill_in_content mt10" id="address_form" style="display: block; height: 257px;">
                            <li>
                               <span class="a_tips"><b>*</b>  选择物流：</span>

                                <select name="express" style="width: 122px;">
                                    <option value="0" class="form-control"  style="width: 120px;display: inline-block;" selected="selected">选择快递</option>
                                    <option value="中通快递">中通快递</option>
                                    <option value="申通快递">申通快递</option>
                                    <option value="圆通快递">圆通快递</option>
                                    <option value="韵达快递">韵达快递</option>
                                    <option value="物流">物流</option>
                                    <option value="其它">其它</option>
                                </select>
                            </li>
                            <li class="clearfix">
                                <div class="float-left">  <span class="a_tips"><b>*</b>  物流单号：</span></div>
                                <div id="region" class="float-left">
                                    <input type="text"
                                           style="width: 120px;display: inline-block;"
                                           size="20" name="numbers" value="">
                                </div>
                            </li>
                            <li style="height: 135px;">
                                 <span class="a_tips"> <b>*</b>上传物流单：</span>

                                <img src=""  style="width: 122px; height: 133px;float: left"  />
                                <a href="" style="height: 135px;line-height: 252px;vertical-align: bottom;
                                display: block;float: left;color: #f00;padding-left: 10px;font-weight: bolder;">上传</a>


                            </li>
                        </ul>
                    </div>



                    <div class="col-md-12  " style="margin-top: 40px;margin-bottom: 20px;">
                        <button type="button" class="btn   btn-lg"  name="bntSubmit"  onClick="ChkReg(this.form);"
                                style="background: #FE6501;border: #FE6501;border-radius: 0px;
                            color: #ffffff;">确认发货</button>
                        <input name="action" type="hidden" id="action" value="choose" />
                    </div>

                    @endif



                </form>

            </div>

        </div>
    </div>
</div>

@stop