<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/user';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function loginUser(Request $request)
    {
        // VALIDACAO
        $validator = Validator::make($request->all(), [
            'username' => ['required','regex:/^[a-z\d_]{4,28}+$/i', 'string', 'min:4', 'max:28'],
            'pass' => ['required', 'regex:/^[a-z\d_]{4,15}+$/i', 'string', 'min:4','max:15']
        ], [

            'username.required' => '* Informe o seu username',
            'pass.required' => '* Informe sua senha',

            'username.min' => '* O usuario tem que ter no minimo 4 caracteres!',
            'pass.min' => '* Sua senha tem que ter no minimo 4 caracteres!',

            'username.regex' => '* Campo Login requer apenas letras/numeros, não utilize acentuações ou espaço, e o login requer no minimo 4 caracteres e no máximo 28',
            'pass.regex' => '* Campo Senha requer apenas letras/numeros, não utilize acentuações ou espaço, a senha requer no minimo 4 caracteres e no máximo 15.',
        ]);

        $ClassArrAy = array('-1','-2','-3','-4','-5','-6','-7','-8','-9','INSERT','INTO','DROP','DELETE','UPDATER','WHERE','FROM','insert','into','drop','from','delete','updater','where','hack','sony','machine','cabal','pirata','nexus','lotus');

        $messages = $validator->errors();
        //valida username
        if(in_array($request->username, $ClassArrAy))
        {
            $messages->add('pass.regex','Você utilizou palavras protegidas pelo sistema no campo login, verifique seu login e tente novamente.'); // Add the message

            return redirect('login')
            ->withErrors($messages)
            ->withInput();
        }
        // valida o password
        if(in_array($request->pass, $ClassArrAy))
        {
            $messages->add('pass.regex','Você utilizou palavras protegidas pelo sistema no campo senha, verifique sua senha e tente novamente.'); // Add the message

            return redirect('login')
            ->withErrors($messages)
            ->withInput();
        }

        if($validator->fails())
        {
            //run validation which will redirect on failure
            //$validator->validate();
            return redirect('login')
                ->withErrors($messages)
                ->withInput();
        }

        // Pega informações da tabela cabal_auth_table
        $db = env('DB_ACCOUNT'); // DB
        $account = DB::select(
            DB::raw("SELECT * FROM $db.dbo.cabal_auth_table WHERE ID='$request->username' AND PWDCOMPARE('$request->pass', Password)=1")
        );

        // Validação login
        if ($account) {

            if($account[0]->AuthType ==2 || $account[0]->AuthType==3)
            {
                $messages->add('username','Atenção, sua conta está bloqueada não é possivel fazer login!'); // Add the message

                return redirect('login')
                        ->withErrors($messages)
                        ->withInput();
            }

            //SALVANDO DADOS DO USUARIO
            // EMAIL
            $emailUser = array_column($account, 'Email');
            // USERNAME
            $nameUser = array_column($account, 'ID');

            // VALIDACAO SE EXISTE EMAIL NA CONTA
            if($emailUser[0] === null)
            {
                $messages->add('username','Você precisa de email valido para poder acessar o painel. Caso tenha duvidas entre em contato com o ADM!'); // Add the message

                return redirect('login')
                        ->withErrors($messages)
                        ->withInput();
            }

            // Verifica se existe o email no banco de dados users
            $userEmail = User::where('email', '=', $emailUser[0])->first();

            // Veirifica se tem algum valor
            if($userEmail === null)
            {
                // se os dados estiver certo do banco Account
                // vai criar um novo usuario para o banco laravel
                User::create([
                'name' => $nameUser[0],
                'email' => $emailUser[0],
                'password' => Hash::make($request->get('pass')),
                ]);

                // Validação Auth
                if (Auth::attempt(['email' => $emailUser[0], 'password' => $request->pass])) {
                    // Authentication passed...
                    return redirect()->intended('/user'); // login sucess
                }
                else
                {
                    return redirect()->intended('/login'); // login failed
                }
            }
            else // faz login se a conta ja existir nos 2 bancos
            {
                // Validação Auth
                if (Auth::attempt(['email' => $emailUser[0], 'password' => $request->pass])) {
                    // Authentication passed...
                    $message = 'Logado com sucesso, Seja bem vindo ao painel user - Cabal Mytology!';
                    return redirect()->intended('/user')->with('success', $message);
                }
                else
                {
                    $messages->add('username','Informacoes de Login incorretas. -500'); // Add the message

                    return redirect('login')
                        ->withErrors($messages)
                        ->withInput();
                }
            }

        } else { // dados login invalido

            $messages->add('username','Informacoes de Login incorretas.'); // Add the message

            return redirect('login')
                ->withErrors($messages)
                ->withInput();
        }

        //dd($validator);

    }
}
