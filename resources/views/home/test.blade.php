@extends('layouts.dashboard')

@section('content')
 {{ config('config.emails.readyToSend') }}
    @stop