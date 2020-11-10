@extends('adminlte::page')

<!-- Styles -->
<style>
    .pink-text {
        color: #e91e63 !important;
    }
</style>

@section('title', 'Chars-')

@foreach ($chars as $char)
@section('content_header')
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('user.index') }}">Dashboard</a></li>
      <li class="breadcrumb-item active"><a href="{{ route('user.chars') }} ">Chars</a></li>
      <li class="breadcrumb-item active"><a href="{{ route('user.chars') }} ">{{ $char->Name }}</a></li>
    </ol>
  <h1>Distribuir Pontos: Char - <span style="font-wieght:bold; font-family:Candara; color:red;">{{ $char->Name }}</span></h1>
@stop

@section('content')

    <div class="col-sm-12">
        <!-- Card -->
        <div class="card testimonial-card">

            <!-- Background color -->
            <div class="card-up indigo lighten-1"></div>

            <!-- Content -->
            <div class="card-body">
                <h5 class="card-text" style="font-wieght:bold; font-family:Candara; color:red;">IMPORTANTE!</h5>
                <h5 class="card-text">- Para adicionar pontos em seu personagem é necessário deslogar da sua conta.</h5>
                <h5 class="card-text">- Seu personagem precisa ter pontos acima de [0].</h5>
                <hr>
                <!-- Name -->
                <h3 >Pontos: {{ $char->PNT }} </h3>
                <hr>
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

                @if(session()->has('danger'))
                    <div class="alert alert-danger">
                        {{ session()->get('danger') }}
                    </div>
                @endif

                @if(session()->has('warning'))
                    <div class="alert alert-warning">
                        {{ session()->get('warning') }}
                    </div>
                @endif

                @if(session()->has('success'))
                    <div class="alert alert-success">
                        {{ session()->get('success') }}
                    </div>
                @endif

                <!-- INFOS -->
                <form action="{{ route('user.chars.update', $char->CharacterIdx) }}" class="form" method="POST">
                    @csrf
                    @method('PUT')

                   <div class="form-group">
                       <label>FOR: {{ $char->STR }} </label>
                       <input type="text" name="FOR" class="form-control" placeholder="{{ $char->STR }}" >
                   </div>
                   <div class="form-group">
                        <label>INT: {{ $char->INT }} </label>
                        <input type="text" name="INT" class="form-control" placeholder="{{ $char->INT }}" >
                    </div>
                    <div class="form-group">
                        <label>DES: {{ $char->DEX }}</label>
                        <input type="text" name="DES" class="form-control" placeholder="{{ $char->DEX }}" >
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-dark">Salvar pontos</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- Card -->
    </div>
@stop
@endforeach



