@extends('layouts.master')
@section('title')
{{Lang::get('layout.Register')}} - @parent
@endsection
@section('content')
    <div class="page-reg">
<div class="container-fluid">
	<div class="row">
		<div class="col-xs-8 col-xs-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">{{Lang::get('layout.Register')}}</div>
				<div class="panel-body">
					@if (count($errors) > 0)
						<div class="alert alert-danger">
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif

					<form class="form-horizontal reg-form" role="form" method="POST" action="{{ url('/auth/register') }}" id="reg-form">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group reg-type">
                            <label class="col-xs-4 control-label">{{Lang::get('layout.Register Type')}}</label>
                            <div class="col-xs-6">
                                <div class="btn-group btn-block" data-toggle="buttons">
                                    <label class="btn btn-default active">
                                        <input type="radio" name="reg_type" id="reg_type_buyer" value="0" autocomplete="off" checked>{{Lang::get('layout.Buyer')}}
                                    </label>
                                    <label class="btn btn-default">
                                        <input type="radio" name="reg_type" id="reg_type_seller" value="1" autocomplete="off">{{Lang::get('layout.Seller')}}
                                    </label>
                                </div>
                            </div>


                        </div>

                        <div class="form-group control-group">
                            <label class="col-xs-4 control-label">{{Lang::get('layout.User Name')}}</label>
                            <div class="col-xs-6">
                                <input type="text" class="form-control" name="username" value="{{ old('username') }}" id="username">
                            </div>
                        </div>

						<div class="form-group control-group">
							<label class="col-xs-4 control-label">{{Lang::get('layout.Mobile')}}</label>
							<div class="col-xs-6">
								<input type="text" class="form-control" name="mobile" value="{{ old('mobile') }}" id="mobile">
							</div>
						</div>

                        <div class="form-group reg-code control-group">
                            <label class="col-xs-4 control-label">{{Lang::get('layout.Code')}}</label>
                            <div class="col-xs-3">
                                <input type="text" class="form-control" name="mobile_code" value="{{ old('mobile_code') }}"
                                       placeholder="{{ Lang::get('layout.MobileCode') }}" id="mobile_code" disabled="disabled">
                            </div>
                            <div class="col-xs-3">
                                <input type="button" id="getCode" class="form-control btn-default" value="{{ Lang::get('layout.GetCode') }}">
                            </div>
                        </div>

						<div class="form-group control-group">
							<label class="col-xs-4 control-label">{{Lang::get('layout.Password')}}</label>
							<div class="col-xs-6">
								<input type="password" class="form-control" name="password" id="password">
							</div>
						</div>

						<div class="form-group control-group">
							<label class="col-xs-4 control-label">{{Lang::get('layout.Confirm Password')}}</label>
							<div class="col-xs-6">
								<input type="password" class="form-control" name="password_confirmation">
							</div>
						</div>

						<div class="form-group reg-submit">
								<button type="submit" class="btn btn-success">
                                    {{Lang::get('layout.Register')}}
								</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
    </div>
@endsection
