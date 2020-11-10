@extends('adminlte::page')

@foreach ($profile as $info)

@section('title', "Perfil - $info->ID")

@section('content_header')
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('user.index') }}">Dashboard</a></li>
      <li class="breadcrumb-item active"><a href="{{ route('user.profile') }} ">Perfil</a></li>
    </ol>
@stop

@section('content')
    <div class="row">

        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">
                  <h1> Perfil - {{ $info->ID }}</h1>
                </div>
                <div class="card-body">
                  <h5 class="card-text">Conta: <span style="font-wieght:bold; font-family:Candara; color:orange;">{{ $info->ID }}</span></h5>
                  <h5 class="card-text">Email: <span style="font-wieght:bold; font-family:Candara; color:orange;">{{ $info->Email }}</span></h5>

                  <h5 class="card-text">Conta Criada: <span style="font-wieght:bold; font-family:Candara; color:orange;"> <?=date('d-m-Y h:m',strtotime($info->createDate))?> </span></h5>

                  <h5 class="card-text">Cash: <span style="font-wieght:bold; font-family:Candara; font-size: 20px; color:rgb(207, 0, 0);"> {{ $cash }} </span></h5>

                  @if ($info->LogoutTime)
                  <h5 class="card-text">Ultima Conexao: <span style="font-wieght:bold; font-family:Candara; color:orange;"> <?=date('d-m-Y h:m',strtotime($info->LogoutTime))?> </span></h5>
                  @endif

                  @if ($info->Ativado)
                    <h5 class="card-text">Conta Status: <span style="font-wieght:bold; font-family:Candara; color:green;">ATIVADO</span></h5>
                    @else
                    <h5 class="card-text">Conta Status: <span style="font-wieght:bold; font-family:Candara; color:red;">DESATIVADO</span></h5>
                  @endif

                </div>
                <a href="{{ route('user.edit', $info->ID) }}" class="btn btn-info">Editar</a>
            </div>
        </div>
        <div class="col-sm-6">
            @if(session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            @endif
        </div>
    </div>
@stop
@endforeach
