@extends('layouts.dashboard')

@section('content')
    <div class="container">
        <div class="col-md-8" style="margin: 0 auto; float: none;">
            <div class="box box-primary">
                <div class="box-header with-border text-center">
                    <h3 class="box-title">Настройки Email</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" method="POST">
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-md-4 control-label">Количество писем от сервера</label>
                            <div class="col-sm-8">
                                <textarea name="kolps" class="form-control" id="inputEmail3">{{ $settings['kolps'] }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-md-4 control-label">Ваш email</label>
                            <div class="col-sm-8">
                                <textarea    name="mot" class="form-control" id="inputEmail3" placeholder="">{{ $settings['mot'] }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-md-4 control-label">ПРАВИЛО | МАКРОС | ИМЯ АТТАЧА </label>
                            <div class="col-sm-8">
                                <textarea     name="macros_one" class="form-control" id="inputEmail3" placeholder="">{{ $settings['macros_one'] }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-md-4 control-label">Thread count</label>
                            <div class="col-sm-8">
                                <textarea  name="sh" class="form-control" id="inputEmail3" placeholder="">{{ $settings['sh'] }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-md-4 control-label">Строк в файле с мылами</label>
                            <div class="col-sm-8">
                                <textarea  name="bb" class="form-control" id="inputEmail3" placeholder="">{{ $settings['bb'] }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-md-4 control-label">X-mailer</label>
                            <div class="col-sm-8">
                                <textarea   name="redirects" class="form-control" id="inputEmail3" placeholder="">{{ $settings['redirects'] }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-md-4 control-label">Забор редиректов 2</label>
                            <div class="col-sm-8">
                                <textarea  name="theme" class="form-control" id="inputEmail3" placeholder="">{{ $settings['theme'] }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-md-4 control-label">DNS SERVERS</label>
                            <div class="col-sm-8">
                                <textarea  name="macros_two" class="form-control" id="inputEmail3" placeholder="">{{ $settings['macros_two'] }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-md-4 control-label">Забор аттачей</label>
                            <div class="col-sm-8">
                                <textarea   name="message" class="form-control" id="inputEmail3" placeholder="">{{ $settings['message'] }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-md-4 control-label">Строк в файле с SMTP</label>
                            <div class="col-sm-8">
                                <textarea  name="macros_try" class="form-control" id="inputEmail3" placeholder="">{{ $settings['macros_try'] }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-md-4 control-label">Макрос 1</label>
                            <div class="col-sm-8">
                                <textarea   name="macros1" class="form-control" id="inputEmail3" placeholder="">{{ $settings['macros1'] }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-md-4 control-label">Макрос 2</label>
                            <div class="col-sm-8">
                                <textarea   name="macros2" class="form-control" id="inputEmail3" placeholder="">{{ $settings['macros2'] }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-md-4 control-label">Макрос 3</label>
                            <div class="col-sm-8">
                                <textarea   name="macros3" class="form-control" id="inputEmail3" placeholder="">{{ $settings['macros3'] }}</textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-2">
                                <label for="checkbox1" class="col-md-6 control-label">Отправлять аттачи</label>
                                <input type="checkbox" name="html" {{ $settings['html'] ? "checked" : "" }} class="form-control" id="includefile">
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
        });
    </script>
@stop