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
                        <div class="col-md-3 text-center">{{ $data['themeInfo'] }}   <span class="badge">{{ $data['themeCount'] }}</span> </div>
                        <div class="col-md-3 text-center">
                            <a class="btn btn-primary" href="{{ url('/delete/themefile') }}">Delete</a></div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-md-6">Письмо:</div>
                        <div class="col-md-3 text-center">{{ $data['messageInfo'] }} <span class="badge">{{ $data['messageCount'] }}</span></div>
                        <div class="col-md-3 text-center">
                            <a class="btn btn-primary" href="{{ url('/delete/messagefile') }}">Delete</a></div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-md-6">Загруженно SMTP:</div>
                        <div class="col-md-3 text-center">{{ $data['smtpCount'] }} шт.</div>
                        <div class="col-md-3 text-center">
                            <a class="btn btn-primary" href="{{ url('/delete/smtpclear') }}">Delete</a></div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-md-6">Загруженно файлов с Email: {{ $data['mailsFileCount'] }} шт.</div>
                        <div class="col-md-3 text-center"> Отдано ботам : {{ $data['go_mailsFileCount'] }} </div>
                        <div class="col-md-3 text-center">
                            <a class="btn btn-primary" href="{{ url('/delete/mailfilesclear') }}">Delete</a></div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-md-6">Загруженно Attach файлов:</div>
                        <div class="col-md-3 text-center"> {{ $data['attachFileCount'] }} шт.</div>
                        <div class="col-md-3 text-center">
                            <a class="btn btn-primary" href="{{ url('/delete/attachfilesclear') }}">Delete</a></div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-md-6">Статистика и отображение данных ботов:</div>
                        <div class="col-md-1" data-toggle="tooltip" data-placement="top" data-html="true" data-animated="fade" title="<img src='{{ rand(0,1) == 1? url('img/1.jpg') : url('img/hi.png') }}' />">Online
                            <span class="badge">{{ $botsInfo['online'] }}</span></div>
                        <div class="col-md-1">Offline <span class="badge">{{ $botsInfo['off'] }}</span></div>
                        <div class="col-md-1">Spam <span class="badge">{{ $botsInfo['spam'] }}</span></div>
                        <div class="col-md-1">Wait <span class="badge"> {{ $botsInfo['wait'] }} </span></div>
                        <div class="col-md-1" style="color:green" data-toggle="tooltip" data-placement="top" title="Clear online bots">Online
                            <span class="badge">{{  $botsInfo['clear_online'] }}</span></div>
                        <div class="col-md-1" style="color:red" data-toggle="tooltip" data-placement="top" title="Online bots in black list">Online
                            <span class="badge">{{ $botsInfo['black_online'] }}</span></div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-md-6">SMTP
                            <a href="{{ url('/download/goodSmtp') }}" class="btn btn-success btn-sm" style="margin-left: 20px;"> Download good </a>
                            <a href="{{ url('/download/badSmtp') }}" class="btn btn-danger btn-sm" style="margin-left: 20px;"> Download bad </a>
                            <a href="{{ url('/delete/clearSmtpTable') }}" class="btn btn-info btn-sm" style="margin-left: 20px;"> Clear check smtp </a>
                        </div>
                        <div class="col-md-1">All <span class="badge">{{ $smtpInfo['all'] }}</span></div>
                        <div class="col-md-1">Wait <span class="badge">{{ $smtpInfo['needCheck'] }}</span></div>
                        <div class="col-md-2 ">Checking <span class="badge">{{ $smtpInfo['inCheck'] }}</span></div>
                        <div class="col-md-1">Good <span class="badge">{{ $smtpInfo['good'] }}</span></div>
                        <div class="col-md-1">Bad <span class="badge">{{ $smtpInfo['bad'] }}</span></div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-md-7">Пулл <a href="{{ url('/update-smtp-pull?redirect=yes') }}"><i class="fa fa-refresh"></i></a></div>
                        <div class="col-md-1">Wait <span class="badge">{{ $pool['needCheck'] }}</span></div>
                        <div class="col-md-2 ">Checking <span class="badge">{{ $pool['inCheck'] }}</span></div>
                        <div class="col-md-1">Good <span class="badge">{{ $pool['good'] }}</span></div>
                        <div class="col-md-1">Bad <span class="badge">{{ $pool['bad'] }}</span></div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-md-6">Emails for find smtp
                            <a href="{{ url('/download/goodEmail') }}" class="btn btn-success btn-sm" style="margin-left: 20px;"> Download good </a>
                            <a href="{{ url('/download/badEmail') }}" class="btn btn-danger btn-sm" style="margin-left: 20px;"> Download bad </a>
                            <a href="{{ url('/delete/clearEmailTable') }}" class="btn btn-info btn-sm" style="margin-left: 20px;"> Clear </a>
                        </div>
                        <div class="col-md-1">All <span class="badge">{{ $emailInfo['all'] }}</span></div>
                        <div class="col-md-3">Wait <span class="badge">{{ $emailInfo['needCheck'] }}</span></div>
                        <div class="col-md-1">Checked <span class="badge">{{ $emailInfo['checked'] }}</span></div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-md-7">Пулл <a href="{{ url('/update-email-pull?redirect=yes') }}"><i class="fa fa-refresh"></i></a></div>
                        <div class="col-md-1">Wait <span class="badge">{{ $Epool['needCheck'] }}</span></div>
                        <div class="col-md-2 ">Checking <span class="badge">{{ $Epool['inCheck'] }}</span></div>
                        <div class="col-md-1 ">Checked <span class="badge">{{ $Epool['checked'] }}</span></div>
                    </div>

                    <div style="margin-bottom: 10px;"></div>
                </div><!-- /.box-body -->
                {{--<div class="box-footer">--}}
                {{--</div><!-- /.box-footer-->--}}
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->
    <div class="text-center">
        <div class="btn-group">
            <a href="{{ url('/status/START') }}" class="btn {{ $status == "START"? "btn-success" : "btn-default" }}">{{ $status != "START"? "START" : "WORKING" }}</a>
            <a href="{{ url('/status/STOP') }}" class="btn {{ $status == "STOP"? "btn-success" : "btn-default" }}">{{ $status != "STOP" ? "STOP" : "STOPPED" }}</a>
            <a href="{{ url('/status/BANALL') }}" class="btn {{ $status == "BANALL"? "btn-success" : "btn-default" }}">{{ $status != "BANALL"? "BAN ALL" : "BAN ALL" }}</a>
            <a href="{{ url('/status/SMTPCHECK') }}" class="btn {{ $status == "SMTPCHECK"? "btn-success" : "btn-default" }}">{{ $status != "SMTPCHECK"? "START SMTP CHECK" : "SMTP CHECK WORKING" }}</a>
            <a href="{{ url('/status/SMTPFIND') }}" class="btn {{ $status == "SMTPFIND"? "btn-success" : "btn-default" }}">{{ $status != "SMTPFIND"? "START SMTP FIND" : "SMTP FIND WORKING" }}</a>
        </div>
    </div>
    <div class="text-center">
        <div class="btn-group">
            <a href="{{ url('/blackList/needCheckBlack') }}" class="btn {{ $checkBlackList == "needCheckBlack"? "btn-success" : "btn-default" }}">{{ $checkBlackList != "needCheckBlack"? "Чекать в блек листах" : "Чекает в блек листах" }}</a>
            <a href="{{ url('/blackList/noNeedCheckBlack') }}" class="btn {{ $checkBlackList == "noNeedCheckBlack"? "btn-success" : "btn-default" }}">{{ $checkBlackList != "noNeedCheckBlack" ? "Не чекать в блек листах" : "Не чекает в блек листах" }}</a>
        </div>
    </div>
    <div style="margin-top: 10px;"></div>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border text-center">
                    <div class="col-md-3"> Id</div>
                    <div class="col-md-3"> IP-адресс</div>
                    <div class="col-md-3"> Статус</div>
                    <div class="col-md-3"> Дата|Время</div>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                            <i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    @forelse($bots as $bot)
                        <div class="col-md-3"> {{ $bot->id }}</div>
                        <div class="col-md-3"> {{ $bot->ip }}</div>
                        <div class="col-md-3"> {{ $bot->status }}</div>
                        <div class="col-md-3"> {{ $bot->updated_at }}</div>
                        @empty
                        <div class="col-md-12 text-center"> There are no bots yet!</div>
                    @endforelse

                </div>
                <div class="box-footer text-center">
                    {{ $bots->render() }}
                </div>
            </div>
        </div>
    </div>

@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="/css/style.css"/>
@stop