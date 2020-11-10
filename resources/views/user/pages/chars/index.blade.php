@extends('adminlte::page')

@section('title', 'Chars-')

@section('content_header')
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('user.index') }}">Dashboard</a></li>
      <li class="breadcrumb-item active"><a href="{{ route('user.chars') }} ">Chars</a></li>
    </ol>
  <h1>Chars</h1>
@stop

@section('content')
    <div class="row">

        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
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
                                    @if($char->PNT)
                                    <td>
                                        <a href="{{ route('user.chars.show', $char->CharacterIdx) }}" class="btn btn-warning">Distribuir pontos</a>
                                    </td>
                                    @else
                                    <td>
                                        <a href="" class="btn btn-warning disabled">Sem pontos</a>
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

