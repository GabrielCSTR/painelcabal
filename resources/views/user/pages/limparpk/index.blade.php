@extends('adminlte::page')

@section('title', 'Chars-')

@section('content_header')
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('user.index') }}">Dashboard</a></li>
      <li class="breadcrumb-item active"><a href="{{ route('user.limparpk') }} ">Limpar PK</a></li>
    </ol>
  <h1>Limpar PK</h1>
@stop

@section('content')
<div class="row">

    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-text" style="font-wieght:bold; font-family:Candara; color:red;">IMPORTANTE!</h5>
                <h5 class="card-text">- Para Limpa sua penalidade é necessário deslogar da sua conta.</h5>
                <h5 class="card-text">- É necessário preenche todos os campos corretamente.</h5>
                <h5 class="card-text">- É necessário ter em seu inventário o valor cobrado por limpar sua penalidade.</h5>
                <hr>

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

                <table class="table table-condensed">
                    <thead>
                        <tr>
                            <th>Nick</th>
                            <th>Level</th>
                            <th>PK</th>
                            <th>Valor</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($chars as $char)
                            <tr>
                                <td>
                                    {{ $char->Name }}
                                </td>
                                <td>
                                    {{ $char->LEV }}
                                </td>
                                <td>
                                    {{ $char->PKPenalty }}
                                </td>
                                <td>
                                    {{ $valor }}
                                </td>
                                @if($char->PKPenalty)
                                <td>
                                    <a href="{{ route('user.limparpk.limpar', $char->CharacterIdx) }}" class="btn btn-danger">LIMPAR PK</a>
                                </td>
                                @else
                                <td>
                                    <a href="" class="btn btn-warning disabled">LIMPAR PK</a>
                                </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop

