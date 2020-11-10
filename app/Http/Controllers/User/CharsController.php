<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class CharsController extends Controller
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
        $username = $this->user->name;

        $db = env('DB_ACCOUNT'); // DB
        $account = DB::select( DB::raw("SELECT * FROM $db.dbo.cabal_auth_table WHERE ID='$username'") );
        // USERNUM
        $UserNum = array_column($account, 'UserNum');
        $AccountON = array_column($account, 'Login');

        //VERIFICA CONTA LOGADA
        if((int)$AccountON != 1)
        {
            $message = 'Voce deve sair do jogo para acessar esta função';
            return redirect()->back() ->with('warning', $message);
        }

        // DB
        $db = env('DB_SERVER01');
        //SELECT CHARS
        $chars = DB::select( DB::raw("SELECT * FROM $db.dbo.cabal_character_table WHERE CharacterIdx/8=$UserNum[0]") );

        if($chars[0])
        {
            return view('user.pages.chars.index', [
                'chars' => $chars
            ]);
        }
        else
        {
            $message = 'Voce deve ter pelo menos um personagem criado para acessar esta função.!';
            return redirect()->back() ->with('warning', $message);
        }

    }

    public function show($charidx)
    {
        //verifica se o id exist
        if (!$account = User::find(Auth::id())) {
            return redirect()->back();
        }

        //salva dados do usuario logado
        $this->user = Auth::user();
        $username = $this->user->name;

        $db = env('DB_ACCOUNT'); // DB
        $account = DB::select( DB::raw("SELECT * FROM $db.dbo.cabal_auth_table WHERE ID='$username'") );

        if($account)
        {
            // USERNUM
            $UserNum = array_column($account, 'UserNum');
            // LOGIN
            $AccountON = array_column($account, 'Login');

            //VERIFICA CONTA LOGADA
            if((int)$AccountON[0])
            {
                $message = 'Voce deve sair do jogo para acessar esta função';
                return redirect()->back() ->with('warning', $message);
            }

            //CHECK ID
            if(((int)$charidx/8) != (int)$UserNum[0])
            {
                return redirect()->back();
            }

            // DB
            $db = env('DB_SERVER01');
            //SELECT CHARS
            $chars = DB::select( DB::raw("SELECT * FROM $db.dbo.cabal_character_table WHERE  CharacterIdx=$charidx") );

            return view('user.pages.chars.viewchar', [
                'chars' => $chars
            ]);
        }
        else
        {
            return redirect()->back();
        }

    }

    public function update(Request $request, $charidx)
    {
        //verifica se o id exist
        if (!$account = User::find(Auth::id())) {
            return redirect()->back();
        }

        // VALIDACAO
        $this->validate($request, [
            'FOR' => ['required','integer'],
            'INT' => ['required', 'integer'],
            'DES' => ['required', 'integer']
        ], [

            'FOR.required' => 'Informe o valor da FOR',
            'INT.required' => 'Informe o valor da INT',
            'DES.required' => 'Informe o valor da DES',

            'FOR.integer' => 'Atenção, digite apenas numero no campo FOR',
            'INT.integer' => 'Atenção, digite apenas numero no campo INT',
            'DES.integer' => 'Atenção, digite apenas numero no campo DES',
        ]);

        // total de pontos que vai ser distribuidos
        $calc	= ($request->FOR + $request->INT + $request->DES);

        // DB
        $db = env('DB_SERVER01');
        // PEGA INFORMACOES DO CHAR
        $chars = DB::select( DB::raw("SELECT * FROM $db.dbo.cabal_character_table WHERE CharacterIdx=$charidx") );
        // TOTAL DE PONTOS DO CHAR
        $charPNT = array_column($chars, 'PNT');
        // Check se o valor de pontos é maior q o valor de pontos que o char tem
        if($charPNT < (int)$calc)
        {
            $message = 'Atenção, este personagem não tem pontos suficientes para serem adicionados.';
            return redirect()->back() ->with('warning', $message);
        }
        elseif((int)$charPNT==0)
        {
            $message = 'Atenção, personagem não possui pontos para distribuir.';
            return redirect()->back() ->with('warning', $message);
        }
        else
        {
            $db = env('DB_SERVER01'); // DB
            $accountDB = DB::update(DB::raw("UPDATE $db.[dbo].[cabal_character_table] SET STR=STR+'$request->FOR', DEX=DEX+'$request->DES', INT=INT+'$request->INT', PNT=PNT-'$calc' WHERE CharacterIdx='$charidx'"));
            if($accountDB)
            {
                $message = 'Pontos adicionados com sucesso!';
                return redirect()->back() ->with('success', $message);
            }
            else
            {
                $message = 'Falha erro -202!';
                return redirect()->back() ->with('danger', $message);
            }

        }

    }
}
