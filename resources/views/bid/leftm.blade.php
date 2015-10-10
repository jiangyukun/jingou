<div class="col-xs-3 side-bar">
    <div class="list-group">

        <?php
        $url = Request::url();
        $urlaction = substr($url, strrpos($url, '/') + 1);
        ?>

        <a class="list-group-item  {{$urlaction=='my'?'active':'' }}  " href="{{ url('bid/my') }}">我的竞价</a>
        <a class="list-group-item {{$urlaction=='myinfo'?'active':'' }} "  href="{{ url('bid/myinfo') }}">商家信息</a>

    </div>
</div>