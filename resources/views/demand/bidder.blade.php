<!--------this is bidders show demand control---------->


<div class="row">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#home" data-toggle="tab" aria-expanded="true">我的竞价</a></li>
        <li class=""><a href="#profile" data-toggle="tab" aria-expanded="false">所有竞价</a></li>

    </ul>
    <div class="tab-content">
        <div class="tab-pane fade active in" id="home">

         @if(   $demand->status>=0 && $demand->is_pay>=1)

            <!--------出价页面开始----->
            <div class="bid-post text-center">
                @if(  isset(Auth::user()->id) )
                <table class="table table-hover">
                    @if(isset($bids))
                    <thead>
                    <tr>
                        <td width="80">序号1</td>
                        <td width="80">投标人</td>
                        <td width="80">投标金额</td>
                        <td width="180">投标时间</td>
                        <td>商品链接</td>
                        <td>中标</td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($bids as $key=>$bid)
                    @if($bid->user_id==Auth::user()->id)
                    <tr >
                        <td scope="row">{{$bid->id}}</td>
                        <td>{{$bid->user->username}}</td>
                        <td @if($bid->price==$lowprice) class="lowprice" @endif>{{$bid->price}}</td>
                        <td>{{ date("Y-m-d h:i:s",strtotime($bid->created_at)) }}</td>
                        <td ><span> @if($bid->url)<a href="{{$bid->url}}" style="color: #f00;">进入链接</a>@endif </span></td>
                        <td>
                            @if(isset(Auth::user()->id) && $demand->user->id==Auth::user()->id && ($demand->status=='待选标'||$demand->status=='竞价中'||$demand->status=='未选标') && $bid->is_win==0)
                            <input type="radio" name="chose-win" class="chose-win" id="chose-win-{{ $bid->id }}" value="{{ $bid->id }}">
                            @elseif($bid->is_win==1)
                            <span class="glyphicon glyphicon-thumbs-up"></span>
                            @endif
                        </td>
                    </tr>
                    @endif

                    @endforeach
                    </tbody>

                    @endif
              @endif<!--------------end of bids----->
                </table>

                @endif<!-------------end of set userid ------------->


                @if(   $demand->status==0 && $demand->is_pay==1  && strtotime($demand->expire_time) >strtotime("now") )
                <h3>
                  @if(  isset(Auth::user()->id) )     {{Auth::user()->username}}，@endif
                    欢迎您参与竞价</h3>
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/bid/add') }}" id="bid-form">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="demand_id" value="{{ $demand->id }}">
                    <input type="hidden" name="bid_id" value="{{ isset($myBid) ? $myBid->id : 0 }}">
                    <div class="form-group control-group">
                        <label class="col-xs-4 control-label">我的出价：</label>
                        <div class="col-xs-1">
                            <input type="text" class="form-control price" name="price" value="{{ isset($myBid)? $myBid->price : old('price') }}">
                        </div>
                    </div>
                    <div class="form-group control-group">
                        <label class="col-xs-4 control-label">商品连接：</label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="url" value="{{ isset($myBid)? $myBid->url : old('url') }}" placeholder="选填">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-xs-4 control-label">{{ Lang::get('layout.Details') }}：</div>
                        <div class="col-xs-6">
                            <textarea type="text" class="form-control" name="details" rows="4">{{ isset($myBid)? $myBid->details : old('details') }}</textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <div> <button type="submit" class="btn btn-danger">{{ isset($myBid)? '再次出价' : '出 价' }}</button> </div>
                    </div>

                </form>
            </div>
<!--------出价页面结束----->
         @endif

        @if($demand->status==2 && $myBid->is_win==1)
            <div class="bid-post text-center">
                <a href="{{ URL::to('bid/f/'.$demand->id) }}" class="btn btn-danger" title="发货">确认发货 <i class="fa fa-angle-right"></i></a>
            </div>
        @endif


            @if($demand->status>=3 && $myBid->is_win==1)
            <div class="bid-post text-center">
                <a href="{{ URL::to('bid/sk/'.$bid->demand->id) }}" class="btn btn-warning" title="确认收款">确认收款 <i class="fa fa-angle-right"></i></a>
            </div>
            @endif


        </div>

        <!--------end of my bidders-------->


        <div class="tab-pane fade" id="profile">
            <!------all bidds---------->


<div class="bid-post" style="min-height: 180px;">
   <table class="table table-hover">
        @if(isset($bids))
        <thead>
        <tr>
            <td width="80">序号</td>
            <td width="80">投标人</td>
            <td width="80">投标金额</td>
            <td width="180">投标时间</td>
            <td>商品链接</td>
            <td>中标</td>
        </tr>
        </thead>
        <tbody>
        @foreach($bids as $key=>$bid)
        <tr @if($bid->is_win==1) class="success"@endif>
            <td scope="row">{{$bid->id}}</td>
            <td>{{$bid->user->username}}</td>
            <td @if($bid->price==$lowprice) class="lowprice" @endif>{{$bid->price}}</td>
            <td>{{ date("Y-m-d h:i:s",strtotime($bid->created_at)) }}</td>
            <td ><span> @if($bid->url)<a href="{{$bid->url}}" style="color: #f00;">进入链接</a>@endif </span></td>
            <td>
                @if(isset(Auth::user()->id) && $demand->user->id==Auth::user()->id && ($demand->status=='待选标'||$demand->status=='竞价中'||$demand->status=='未选标') && $bid->is_win==0)
                <input type="radio" name="chose-win" class="chose-win" id="chose-win-{{ $bid->id }}" value="{{ $bid->id }}">
                @elseif($bid->is_win==1)
                <span class="glyphicon glyphicon-thumbs-up"></span>
                @endif
            </td>
        </tr>
        @endforeach
        </tbody>
        @else
            <thead><tr><th>暂无商家参与竞标</th></tr></thead>
        @endif
    </table>

</div>

            <!------all bidds---------->
        </div>
    </div>
</div>

