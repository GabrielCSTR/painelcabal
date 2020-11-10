<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Panel Pro - Login</title>

        <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/main.css') }}">
        <link rel="stylesheet" href="{{ asset('css/util.css') }}">
    </head>
    <body>
        <div class="limiter">
            <div class="container-login100">
                <div class="wrap-login100">
                    <form class="login100-form validate-form" action="{{ route('login.user')}}" method="POST">
                        @csrf
                        @method('POST')

                        <span class="login100-form-title p-b-34">
                            Account Login
                        </span>

                        <div class="wrap-input100 rs1-wrap-input100 validate-input m-b-20" data-validate="Type user name">
                            <input id="first-name" class="input100" type="text" name="username" placeholder="Username">
                            <span class="focus-input100"></span>
                        </div>
                        <div class="wrap-input100 rs2-wrap-input100 validate-input m-b-20" data-validate="Type password">
                            <input class="input100" type="password" name="pass" placeholder="Password">
                            <span class="focus-input100"></span>
                        </div>

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

                        <div class="container-login100-form-btn">
                            <button class="login100-form-btn" type="submit">
                                Login
                            </button>
                        </div>

                        <div class="w-full text-center p-t-27 p-b-239">
                            <span class="txt1">
                                Esqueceu
                            </span>

                            <a href="#" target="_blank" class="txt2">
                                sua senha ?
                            </a>

                            <span class="txt1" style="margin-left: 10%;">
                                Não tem
                            </span>
                            <a href="https://www.cabalmytology.net/#register" target="_blank" class="txt2">
                                Cadastro ?
                            </a>
                        </div>

                        <div class="w-full text-center">
                            © Copyright <a href="https://www.cabalmytology.com.br/" target="_blank" class="txt3">
                                Cabal Mytology
                            </a>. All Rights Reserved

                        </div>
                        <div class="w-full text-center">
                            Desenvolvedor<a href="https://strdeveloped.com.br/" target="_blank" class="txt3">
                                STRDeveloped
                            </a>

                        </div>
                    </form>
                    <div class="login100-more" style="background-image: url('img/bg-01.jpg');"></div>
                </div>
            </div>
        </div>

        <div id="dropDownSelect1"></div>

    </body>
</html>
