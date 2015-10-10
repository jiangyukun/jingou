@section('title')

@endsection
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>@yield('title') - {{$settings['site_name']}}管理中心</title>
    <!-- Bootstrap Core CSS -->
    <link href="/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- MetisMenu CSS -->
    <link href="/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">
    <!-- Timeline CSS -->
    <link href="/css/timeline.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="/css/sb-admin-2.css" rel="stylesheet">
    <!-- Morris Charts CSS -->
    <link href="/bower_components/morrisjs/morris.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link id="bsdp-css" href="/bower_components/datepicker/css/bootstrap-datepicker3.css" rel="stylesheet">

</head>

<body>

<div class="row">
    <div class="col-md-12">
        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">

                <a class="navbar-brand" href="index.html">最惠购管理中心</a>
            </div>
            <!-- /.navbar-header -->



            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li><a href="/admin/index">主页</a></li>
                    <li><a href="/admin/demands">竞购管理</a></li>
                    <li><a href="/admin/bids">竞价管理</a></li>
                    <li><a href="/admin/bidders">商家管理</a></li>
                    <li><a href="/admin/users">用户管理</a></li>
                    <li><a href="/admin/cate">商品分类</a></li>
                    <li><a href="/admin/setting">系统设置</a></li>

                    <!-------------
                    <li class="active"><a href="#">Link</a></li>
                    <li><a href="#">Link</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown<strong class="caret"></strong></a>
                        <ul class="dropdown-menu">

                            <li class="divider">
                            </li>
                            <li>
                                <a href="#">Separated link</a>
                            </li>
                            <li class="divider">
                            </li>
                            <li>
                                <a href="#">One more separated link</a>
                            </li>
                        </ul>
                    </li>----->
                </ul>



                <ul class="nav navbar-top-links navbar-right">


                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="/auth/logout"><i class="fa fa-sign-out fa-fw"></i> 退出</a>
                            </li>
                        </ul>
                        <!-- /.dropdown-user -->
                    </li>
                    <!-- /.dropdown -->
                </ul>
                <!-- /.navbar-top-links -->
                <!--
                   <div class="navbar-default sidebar" role="navigation">
                       <div class="sidebar-nav navbar-collapse">
                           <ul class="nav" id="side-menu">
                               <li>
                                   <a href="/admin/index"><i class="fa fa-dashboard fa-fw"></i> 主页</a>
                               </li>
                               <li>
                                   <a href="/admin/demands"><i class="fa fa-table fa-fw"></i> 竞购管理</a>
                               </li>
                               <li>
                                   <a href="/admin/bids"><i class="fa fa-table fa-fw"></i> 竞价管理</a>
                               </li>
                               <li>
                                   <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> 商家管理<span class="fa arrow"></span></a>
                                   <ul class="nav nav-second-level">
                                       <li>
                                           <a href="/admin/bidders">商家列表</a>
                                       </li>
                                       <li>
                                           <a href="/admin/certs">认证审核</a>
                                       </li>
                                   </ul>

                        </li>
                        <li>
                            <a href="/admin/users"><i class="fa fa-edit fa-fw"></i> 用户管理</a>
                        </li>
                        <li>
                            <a href="/admin/setting"><i class="fa fa-edit fa-fw"></i> 系统设置</a>
                        </li>
                    </ul>
                </div>

            </div>
       /.navbar-static-side -->
        </nav>

    </div>
</div>

<div class="row">
    <div class="col-md-11">
        @yield('content')
        <!--------------------------------->
        </div>
</div>


        <!-- /.row -->


<!-- /#wrapper -->

<!-- jQuery -->
<script src="/bower_components/jquery/dist/jquery.min.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="/bower_components/metisMenu/dist/metisMenu.min.js"></script>

<!-- DataTables JavaScript -->
<script src="/bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
<script src="/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>


<!-- Custom Theme JavaScript -->
<script src="/js/sb-admin-2.js"></script>
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
@yield('script')

</body>

</html>
