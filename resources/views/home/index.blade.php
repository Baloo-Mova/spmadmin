@extends('layouts.dashboard')

@section('content')
    <div class='row'>
        <div class='col-md-12'>
            <!-- Box -->
            <div class="box box-primary">
                <div class="box-header with-border text-center">
                    <div class="col-md-6"> Название</div>
                    <div class="col-md-3"> Статус</div>
                    <div class="col-md-3"> Действия</div>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                            <i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div style="margin-top: 10px;"></div>
                    <div class="row">
                        <div class="col-md-6">Темы:</div>
                        <div class="col-md-3 text-center">{{ $data['themeInfo'] }}</div>
                        <div class="col-md-3 text-center"><a class="btn btn-primary" href="{{ url('/delete/themefile') }}">Delete</a> </div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-md-6">Письмо:</div>
                        <div class="col-md-3 text-center">{{ $data['messageInfo'] }}</div>
                        <div class="col-md-3 text-center"><a class="btn btn-primary" href="{{ url('/delete/messagefile') }}">Delete</a></div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-md-6">Загруженно SMTP:</div>
                        <div class="col-md-3 text-center">{{ $data['smtpCount'] }} шт.</div>
                        <div class="col-md-3 text-center"><a class="btn btn-primary" href="{{ url('/delete/smtpclear') }}">Delete</a></div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-md-6">Загруженно файлов с Email:</div>
                        <div class="col-md-3 text-center">{{ $data['mailsFileCount'] }} шт.</div>
                        <div class="col-md-3 text-center"><a class="btn btn-primary" href="{{ url('/delete/') }}">Delete</a></div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-md-6">Загруженно Attach файлов:</div>
                        <div class="col-md-3 text-center">0 шт.</div>
                        <div class="col-md-3 text-center"><a class="btn btn-primary" href="{{ url('/') }}">Delete</a></div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-md-6">Статистика и отображение данных ботов:</div>
                        <div class="col-md-3 text-center">0 шт.</div>
                        <div class="col-md-3 text-center"><a class="btn btn-primary" href="{{ url('/') }}">Delete</a></div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-md-6">Счетчики работы проверок SMTP ботов:</div>
                        <div class="col-md-3 text-center">0 шт.</div>
                        <div class="col-md-3 text-center"><a class="btn btn-primary" href="{{ url('/') }}">Delete</a></div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-md-6">Пулл</div>
                        <div class="col-md-3 text-center">0 шт.</div>
                        <div class="col-md-3 text-center"><a class="btn btn-primary" href="{{ url('/') }}">Delete</a></div>
                    </div>
                    <div style="margin-bottom: 10px;"></div>
                </div><!-- /.box-body -->
                {{--<div class="box-footer">--}}
                {{--</div><!-- /.box-footer-->--}}
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="/css/style.css"/>
@stop