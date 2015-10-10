@extends('layouts.master')
@section('title')
    {{Lang::get('layout.User Login')}} - @parent
@stop
@section('content')
    <div class="page-login">
<div class="container-fluid">
	<div class="row">
		<div class="col-xs-8 col-xs-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">{{Lang::get('layout.User Login')}}</div>
				<div class="panel-body">
					<form class="form-horizontal" role="form" method="POST" action="{{ isset($_REQUEST['refe']) ? url('/auth/login').'?refe='.$_REQUEST['refe'] : url('/auth/login') }}" id="login-form">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">

						<div class="form-group control-group">
							<label class="col-xs-4 control-label">{{Lang::get('layout.User Name')}}</label>
							<div class="col-xs-6">
								<input type="text" class="form-control" name="username" value="{{ old('username') }}">
							</div>
						</div>

						<div class="form-group control-group">
							<label class="col-xs-4 control-label">{{Lang::get('layout.Password')}}</label>
							<div class="col-xs-6">
								<input type="password" class="form-control" name="password">
							</div>
						</div>

						<div class="form-group">
							<div class="col-xs-6 col-xs-offset-4">
								<div class="checkbox">
									<label>
										<input type="checkbox" name="remember" checked> {{Lang::get('layout.Remember Me')}}
									</label>
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="col-xs-6 col-xs-offset-4">
								<button type="submit" class="btn btn-primary">{{Lang::get('layout.Login')}}</button>

								<a class="btn btn-link" href="{{ url('/password/email') }}">{{Lang::get('layout.Forgot Your Password?')}}</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
    </div>
@endsection
