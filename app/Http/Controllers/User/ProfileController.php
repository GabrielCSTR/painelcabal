<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use GuzzleHttp\Psr7\Message;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //verifica se o id exist
        if (!$account = User::find(Auth::id())) {
            return redirect()->back();
        }

        //salva dados do usuario logado
        $this->user = Auth::user();
        //username
        $username = $this->user->name;

        $db = env('DB_ACCOUNT'); // DB
        $profile = DB::select( DB::raw("SELECT * FROM $db.dbo.cabal_auth_table WHERE ID='$username'") );
        $usernum = $profile[0]->UserNum;

        // VERIFICA O CASH DA CONTA
        $cashUser = DB::select( DB::raw("SELECT * FROM CabalCash.dbo.CashAccount WHERE UserNum='$usernum'") );
        $cashTotal = 0;
        if($cashUser)
            $cashTotal = $cashUser[0]->Cash;

        return view('user.pages.profile.index', [
            'profile' => $profile,
            'cash' => $cashTotal
        ]);
    }

    public function edit($id)
    {
        //verifica se o id exist
        if (!$account = User::find(Auth::id())) {
            return redirect()->back();
        }

        //salva dados do usuario logado
        $this->user = Auth::user();
        $username = $id;

        $db = env('DB_ACCOUNT'); // DB
        $profile = DB::select( DB::raw("SELECT * FROM $db.dbo.cabal_auth_table WHERE ID='$username'") );

        if($profile)
        {
            $accountID = array_column($profile, 'ID');

            if($accountID[0] == $account->name)
            {
                return view('user.pages.profile.edit',[
                    'profile' => $profile
                ]);
            }
            else
            {
                return redirect()->back();
            }
        }
        else
        {
            return redirect()->back();
        }

    }

    public function update(Request $request, $id)
    {
        //verifica se o id exist
        if (!$account = User::find(Auth::id())) {
            return redirect()->back();
        }

        // VALIDACAO
        $this->validate($request, [
            'password' => ['required','regex:/^[a-z\d_]{4,15}+$/i', 'string', 'min:4', 'max:15'],
            'passwordR' => ['required', 'regex:/^[a-z\d_]{4,15}+$/i', 'string', 'min:4','max:15']
        ], [

            'password.required' => 'Informe sua senha',
            'passwordR.required' => 'Confirme sua senha',

            'password.min' => 'Atenção, você deve digitar uma senha com no mínimo 5 caracteres.',
            'passwordR.min' => 'Atenção, você deve digitar uma senha com no mínimo 5 caracteres.',

            'password.regex' => 'Atenção, você deve digitar uma senha somente de letras e numeros.',
            'passwordR.regex' => 'Atenção, você deve digitar uma senha somente de letras e numeros.',
        ]);

        //salva dados do usuario logado
        $this->user = Auth::user();
        $db = env('DB_ACCOUNT'); // DB

        $accountDB = DB::update(DB::raw("UPDATE $db.[dbo].[cabal_auth_table] SET Password=pwdencrypt('$request->password') WHERE ID='$id'"));
        // update password table users
        $usersDB = User::where('name', $id)
        ->update([
            'password' => Hash::make($request->get('password'))
        ]);

        if($accountDB && $usersDB)
        {
            $message = 'Obrigado! sua senha foi alterada com sucesso.';
            return redirect()->back() ->with('success', $message);
        }
    }

}
