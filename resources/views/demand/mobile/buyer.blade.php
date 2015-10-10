
<div id="groupSalePanel">
    <div class="line"></div>
    <div class="group-product">
        @if($demand->status== 0)
        @if( $demand->is_pay==0)
        <a href="/pay/deposit/{{ $demand->id }}" class="buy-begin" >支付订金</a>
        @endif

        @if( $demand->is_pay==1)
        <!-------竞价中的竞购------->
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="demand_id" value="{{$demand->id}}">
        @if($demand->getstatus()== '竞价中')
        <a href="javascript:Win();"  class="buy-begin" >提前选择中标</a>
        @else
        <a href="javascript:Win();"  class="buy-begin" >选择中标商家</a>
        <a href="{{ url('/demand/choose/'.$demand->id) }}" class="buy-begin" >无满意竞价</a>
        @endif
        @endif
        @endif

        @if($demand->status== 1)
        <a href="{{ URL::to('pay/demand/'.$demand->id) }}"
           class="buy-begin"  title="支付定金">支付尾款 <i class="fa fa-angle-right"></i></a>
        @endif



    </div>
</div>

