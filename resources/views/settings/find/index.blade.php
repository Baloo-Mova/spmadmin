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
                <form class="form-horizontal" method="POST">
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-md-2 control-label">Thread count</label>
                            <div class="col-sm-10">
                                <input type="text" value="{{ $settings['threads'] }}" name="threads" class="form-control" id="inputEmail3" placeholder="Thread count">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-md-2 control-label">Count emails for one request</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="count_emails" value="{{ $settings['count_emails'] }}" id="inputEmail3" placeholder="The number of simultaneous bots">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-md-2 control-label">Pull size</label>
                            <div class="col-sm-10">
                                <input type="text" name="pull_size" value="{{ $settings['pull_size'] }}" class="form-control" id="inputEmail3" placeholder="SMTP count per one request">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-md-2 control-label">Pull swap size</label>
                            <div class="col-sm-10">
                                <input type="text" name="pull_swap_size" value="{{ $settings['pull_swap_size'] }}" class="form-control" id="inputEmail3" placeholder="Mark">
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