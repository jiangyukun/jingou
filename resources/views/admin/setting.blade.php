@extends('admin.master')
@section('title')
    {{Lang::get('admin.Setting')}} @parent
@endsection
@section('content')


<div class="col-xs-12">
    <form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/setting') }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="panel panel-default">
        <div class="panel-heading">参数设置</div>
        <div class="panel-body">
            @foreach ($set1 as $set)
            <div class="form-group">
                <div class="col-xs-2 text-right">{{ $set->tips }}</div>
                <div class="col-xs-5">
                    <input type="text" class="form-control" name="{{ $set->set_key }}" value="{{ $set->set_value }}">
                </div>
            </div>
            @endforeach
        </div>
    </div>


    <div class="panel panel-default">
        <div class="panel-heading">系统设置</div>
        <!-- /.panel-heading -->
        <div class="panel-body">


        <div class="row setting">

                @foreach ($setts as $set)
                    <div class="form-group">
                        <div class="col-xs-2 text-right">{{ $set->tips }}</div>
                        <div class="col-xs-5">
                        @if($set->set_key === 'is_close')
                            <div class="btn-group" data-toggle="buttons">
                                <label class="btn btn-sm btn-default @if($set->set_value === '1') active @endif ">
                                    <input type="radio" name="{{ $set->set_key }}" id="option1" value="1" autocomplete="off" @if($set->set_value === '1') checked @endif >是</label>
                                <label class="btn btn-sm btn-default @if($set->set_value === '0') active @endif ">
                                    <input type="radio" name="{{ $set->set_key }}" id="option2" value="0" autocomplete="off" @if($set->set_value === '0') checked @endif >否</label>
                            </div>
                        @else
                            <input type="text" class="form-control" name="{{ $set->set_key }}" value="{{ $set->set_value }}">
                        @endif
                    </div>
                    </div>
                @endforeach
                    <div class="form-group">
                        <div class="col-xs-5 col-xs-offset-4">
                            <button type="submit" class="btn btn-primary">{{Lang::get('layout.Submit')}}</button>
                        </div>
                    </div>


        </div>


            </div>
        </div>

    </form>

    </div>

            @endsection
