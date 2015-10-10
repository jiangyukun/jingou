<div class="row">


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



    <div class="text-center">


        @if($demand->status== 0)
                    @if( $demand->is_pay==0)
                     <a href="/pay/deposit/{{ $demand->id }}" class="btn btn-warning">支付订金</a>
                    @endif

                    @if( $demand->is_pay==1)
                    <!-------竞价中的竞购------->
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="demand_id" value="{{$demand->id}}">
                        @if($demand->getstatus()== '竞价中')
                            <a href="javascript:Win();" class="btn btn-success">提前选择中标</a>
                        @else
                            <a href="javascript:Win();" class="btn btn-success">选择中标商家</a>
                            <a href="{{ url('/demand/choose/'.$demand->id) }}" class="btn btn-success">无满意竞价</a>
                        @endif
                    @endif
        @endif

        @if($demand->status== 1)
             <a href="{{ URL::to('pay/demand/'.$demand->id) }}"
           class="btn btn-warning" title="支付定金">支付尾款 <i class="fa fa-angle-right"></i></a>
        @endif






    </div>


</div>