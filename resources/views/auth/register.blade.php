@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Register</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
                        {{ csrf_field() }}
                        
                        <div class="form-group{{ $errors->has('role') ? ' has-error' : '' }}">
                            <label for="" class="col-md-4 control-label">Role</label>

                            <div class="col-md-6">
                                <input id="cente" type="radio" class="col-md-4 fade" value="2" name="role" data="center" disabled ="" required> <label class="col-md-8 fade" for="cente">Center</label>
                                <input id="ware" type="radio" class="col-md-4" value="3" name="role" data="warehouse"  required> <label class="col-md-8" for="ware">Warehouse</label>
                                
                                @if ($errors->has('role'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('role') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <fieldset class="fade1 registrationShow">

                        <div class="form-group{{ $errors->has('asigned') ? ' has-error' : '' }}">
                            <label for="" class="col-md-4 control-label">Assign a <span id="assign"></span></label>
                            <div class="col-md-6">
                                <select id="asigned"  class="form-control"  name="assign" value="{{ old('asigned') }}" required>
                                    <option value="0">-------Select-------</option>
                                </select>
                                
                                @if ($errors->has('asigned'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('asigned') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Register
                                </button>
                            </div>
                        </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

