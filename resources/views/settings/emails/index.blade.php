@extends('layouts.dashboard')

@section('content')
    <div class="container-fluid">
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border text-center">
                    <h3 class="box-title">Настройки Спама</h3>
                </div>
                <form class="form-horizontal" method="POST">
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-md-4 control-label">Количество писем от сервера</label>
                            <div class="col-sm-8">
                                <textarea name="emails_from_server" class="form-control" id="inputEmail3">{{ $settings['emails_from_server'] }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-md-4 control-label">ПРАВИЛО | МАКРОС | ИМЯ АТТАЧА </label>
                            <div class="col-sm-8">
                                <textarea name="attach_name_macros" class="form-control" id="inputEmail3" placeholder="">{{ $settings['attach_name_macros'] }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-md-4 control-label">Thread count</label>
                            <div class="col-sm-8">
                                <textarea name="thread_count" class="form-control" id="inputEmail3" placeholder="">{{ $settings['thread_count'] }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-md-4 control-label">X-mailer</label>
                            <div class="col-sm-8">
                                <textarea name="x_mailer" class="form-control" id="inputEmail3" placeholder="">{{ $settings['x_mailer'] }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-md-4 control-label">Количество SMTP за 1 заход</label>
                            <div class="col-sm-8">
                                <textarea name="smtp_count" class="form-control" id="inputEmail3" placeholder="">{{ $settings['smtp_count'] }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-md-4 control-label">Макрос 1</label>
                            <div class="col-sm-8">
                                <textarea name="macros1" class="form-control" id="inputEmail3" placeholder="">{{ $settings['macros1'] }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-md-4 control-label">Макрос 2</label>
                            <div class="col-sm-8">
                                <textarea name="macros2" class="form-control" id="inputEmail3" placeholder="">{{ $settings['macros2'] }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-md-4 control-label">Макрос 3</label>
                            <div class="col-sm-8">
                                <textarea name="macros3" class="form-control" id="inputEmail3" placeholder="">{{ $settings['macros3'] }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-md-4 control-label">Тема сообщения</label>
                            <div class="col-sm-8">
                                <textarea name="message_theme" class="form-control" id="inputEmail3" placeholder="">{{ $settings['message_theme'] }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-md-4 control-label">Текст сообщения</label>
                            <div class="col-sm-8">
                                <textarea name="message_text" class="form-control" id="inputEmail3" placeholder="">{{ $settings['message_text'] }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-2">
                                <label for="checkbox1" class="col-md-6 control-label">Отправлять аттачи</label>
                                <input type="checkbox" name="send_attach" {{ $settings['send_attach'] ? "checked" : "" }} class="form-control" id="includefile">
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
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header text-center">
                    <h3 class="box-title">Дополнительный функционал</h3>
                </div>
                <div class="box-body">
                    <p>
                        <a href="{{ route('smtp.upload') }}" class="btn btn-primary"> Загрузить SMTP для спама</a>
                        <span class="btn-label">Файлы будут загружены из папки <b> {{ storage_path()."\\".config('config.smtpFolder') }}</b></span>
                    </p>
                    <p>
                        <a href="{{ route('smtp.upload') }}" class="btn btn-primary"> Загрузить SMTP для спама</a>
                        <span class="btn-label">Файлы будут загружены из папки <b> {{ storage_path()."\\".config('config.smtpFolder') }}</b></span>
                    </p>
                    <p>
                        <a href="{{ route('smtp.upload') }}" class="btn btn-primary"> Загрузить SMTP для спама</a>
                        <span class="btn-label">Файлы будут загружены из папки <b> {{ storage_path()."\\".config('config.smtpFolder') }}</b></span>
                    </p>

                </div>
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