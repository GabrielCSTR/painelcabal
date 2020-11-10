@extends('adminlte::page')

@foreach ($profile as $info)

@section('title', "Edit Profile {$info->ID}")

@section('content_header')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('user.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item active"><a href="{{ route('user.profile') }} ">Perfil</a></li>
        <li class="breadcrumb-item active"><a href="{{ route('user.profile') }} ">Perfil Edit</a></li>
    </ol>
    <h1>Editar pefil - {{ $info->ID }}</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-text">Atenção você só pode editar sua senha!</h5>
            @if ($errors->any())
            <div class="container-login100-form-btn">
                <div class="alert alert-danger ">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif

            @if(session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            @endif

            <form action="{{ route('user.update', $info->ID) }}" class="form" method="POST">
                @csrf
                @method('PUT')

               <div class="form-group">
                   <label>Senha:</label>
                   <input type="password" name="password" class="form-control" placeholder="Senha:" >
               </div>
               <div class="form-group">
                    <label>Confirmar Senha:</label>
               <input type="password" name="passwordR" class="form-control" placeholder="Confirma senha:" >
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-dark">Editar</button>
                </div>
            </form>

        </div>
    </div>
@endsection

@endforeach
