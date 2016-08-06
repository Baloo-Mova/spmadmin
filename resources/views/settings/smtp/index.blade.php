@extends('layouts.dashboard')

@section('content')
    <div class="container">
        <div class="col-md-8" style="margin: 0 auto; float: none;">
            <div class="box box-primary">
                <div class="box-header with-border text-center">
                    <h3 class="box-title">Настройки проверки SMTP</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-md-2 control-label">Thread count</label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control" id="inputEmail3" placeholder="Thread count">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-md-2 control-label">Bots count</label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control" id="inputEmail3" placeholder="The number of simultaneous bots">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-md-2 control-label">SMTP count</label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control" id="inputEmail3" placeholder="SMTP count per one request">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-md-2 control-label">Mark</label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control" id="inputEmail3" placeholder="Mark">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-md-2 control-label">Await timeout</label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control" id="inputEmail3" placeholder="Thread count">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-md-2 control-label">Pool base size</label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control" id="inputEmail3" placeholder="Pool base size">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-md-2 control-label">Transfer count</label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control" id="inputEmail3" placeholder="Pool size of the residue to transfer">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6">
                                <label for="checkbox1" class="col-md-6 control-label">Check with include file</label>
                                <input type="checkbox" class="form-control" checked id="includefile">
                            </div>
                            <div class="col-md-6">
                                <label for="control-message-text" class="col-md-6 control-label">Reference letter text</label>
                                <input type="checkbox" class="form-control" checked id="control-message-text">
                            </div>
                        </div>

                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <a href="{{ url('/') }}" class="btn btn-default">Cancel</a>
                        <button type="submit" class="btn btn-primary pull-right">Save</button>
                    </div>
                    <!-- /.box-footer -->
                </form>
            </div>
        </div>
    </div>
@stop
@section('js')
    <script>
        $(function () {
            $('#includefile').bootstrapSwitch();
            $('#control-message-text').bootstrapSwitch();
        });
    </script>
@stop