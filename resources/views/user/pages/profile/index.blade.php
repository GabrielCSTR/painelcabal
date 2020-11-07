@extends('adminlte::page')

@section('title', 'Dashboard')

@foreach ($profile as $info)

@section('content_header')
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('user.index') }}">Dashboard</a></li>
      <li class="breadcrumb-item active"><a href="{{ route('user.profile') }} ">Perfil</a></li>
    </ol>
  <h1>Perfil - {{ $info->ID }}</h1>
@stop

@section('content')
    <div class="row">
        
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">
                  Perfil - {{ $info->ID }}
                </div>
                <div class="card-body">
                  <h5 class="card-text">ID: {{ $info->ID }}</h5> 
                  <h5 class="card-text">Email: {{ $info->Email }}</h5> 
                  <h5 class="card-text">Conta ativada: {{ $info->Ativado }}</h5> 
                  <h5 class="card-text">Conta Criada: {{ $info->createDate }}</h5> 
                </div>
                <a href="{{ route('user.edit', $info->ID) }}" class="btn btn-info">Editar</a>
            </div>
        </div>
    </div>
@stop
@endforeach
