
<style>
    .myinput{
        width: 100%;
        height: 24px;
        margin-top: 10px;
        font-size: 14px;
        color: #000;
        margin-bottom: 10px;
    }
</style>

<div class="p-tab-cot"  >
    <div class="p-share" id="param-share">
        <ul>

            <li>

                <form class="form-horizontal" role="form" method="POST" action="{{ url('/bid/add') }}" id="bid-form">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="demand_id" value="{{ $demand->id }}">
                    <input type="hidden" name="bid_id" value="{{ isset($myBid) ? $myBid->id : 0 }}">
                    <div class="form-group control-group">
                        <div class="col-xs-6">
                            <input type="text" class="myinput" placeholder="我的出价" name="price" value="{{ isset($myBid)? $myBid->price : old('price') }}">
                        </div>
                    </div>
                    <div class="form-group control-group">
                        <div class="col-xs-8">
                            <input type="text" class="myinput" name="url"  placeholder="商品连接"  value="{{ isset($myBid)? $myBid->url : old('url') }}" placeholder="选填">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-xs-8">
                            <textarea type="text" class="myinput" style="height: 46px;" placeholder="{{ Lang::get('layout.Details') }}" name="details" rows="4">{{ isset($myBid)? $myBid->details : old('details') }}</textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <div> <button type="submit" class="main-btn">{{ isset($myBid)? '再次出价' : '出 价' }}</button> </div>
                    </div>

                </form>

            </li>


        </ul>

    </div>
</div>
