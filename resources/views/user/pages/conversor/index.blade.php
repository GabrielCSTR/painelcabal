@extends('adminlte::page')

@section('title', 'Chars-')

@section('content_header')
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('user.index') }}">Dashboard</a></li>
      <li class="breadcrumb-item active"><a href="{{ route('user.limparpk') }} ">Conversor</a></li>
    </ol>
  <h1>Conversor</h1>
@stop

@section('content')
<div class="row">

    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <h1>Converta suas Horas logadas em Cash</h1>

                <div class="card-text" style="font-weight: normal; font-size:12px; margin-left:4px;"><b><a href="">Requisitos</b></a>:</div><br>

                <div class="card-text" style="font-weight: normal; font-size:12px; margin-left:4px;">- Sua conta deve estar <font color="#FF0000"><u>OFFLINE</u></font> para converter.</div>

                <div class="card-text" style="font-weight: normal; font-size:12px; margin-left:4px;">- Com o conversor voc&ecirc; troca seus Cash por horas que voce passou<font style="color:green"> online</font></div>

                <div class="card-text"style="height:3px;"></div>

                <div style="font-weight: normal; font-size:12px; margin-left:4px;">- voce pode juntar Cash e gastar no webshop da forma que desejar.</div>

                <div class="card-text" style="font-weight: normal; font-size:12px; margin-left:4px;">- Valor da Hora Logada: 1000</div>
                <div class="card-text" style="height:10px;"></div>
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
                            <th>Horas</th>
                            <th>Quantidade a ser convertida</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <form action="{{ route('user.conversor.convert', $charidx) }}" class="form" method="POST">
                        @csrf
                        @method('PUT')

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
                                        {{ $horas }}
                                    </td>
                                    <td>
                                        <input type="text" name="txtHoras" class="form-control" placeholder="{{ $horas }}" >
                                    </td>
                                    @if($horas)
                                    <td>
                                        <button type="submit" class="btn btn-dark">CONVERTER</button>
                                    </td>
                                    @else
                                    <td>
                                        <button type="submit" class="btn btn-dark disabled">CONVERTER</button>
                                    </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </form>
                </table>

            </div>
        </div>
    </div>
</div>
@stop



