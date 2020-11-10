<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LimparPKController extends Controller
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
        $account = DB::select(DB::raw("SELECT * FROM $db.dbo.cabal_auth_table WHERE ID='$username'"));

        // USERNUM
        $UserNum = array_column($account, 'UserNum');
        $AccountON = array_column($account, 'Login');

        //VERIFICA CONTA LOGADA
        if ((int)$AccountON[0]) {
            $message = 'Voce deve sair do jogo para acessar esta função';
            return redirect()->back()->with('warning', $message);
        }

        // DB
        $db = env('DB_SERVER01');
        //SELECT CHARS
        $chars = DB::select(DB::raw("SELECT * FROM $db.dbo.cabal_character_table WHERE CharacterIdx/8=$UserNum[0] AND Nation < 3"));

        //CHECK DADOS CHAR
        if ($chars[0]) {

            // VALOR PK
            $calcPK	= 2000 * $chars[0]->PKPenalty;

            return view('user.pages.limparpk.index', [
                'chars' => $chars,
                'valor' => $calcPK
            ]);

        } else {
            $message = 'Voce deve ter pelo menos um personagem criado para acessar esta função.!';
            return redirect()->back()->with('warning', $message);
        }
    }

    public function update($charidx)
    {
        //salva dados do usuario logado
        $this->user = Auth::user();
        $username = $this->user->name;

        $db = env('DB_ACCOUNT'); // DB
        $account = DB::select(DB::raw("SELECT * FROM $db.dbo.cabal_auth_table WHERE ID='$username'"));

        if($account)
        {
            // USERNUM
            $UserNum = array_column($account, 'UserNum');

            // DB
            $db = env('DB_SERVER01');
            //SELECT CHARS
            $chars = DB::select(DB::raw("SELECT * FROM $db.dbo.cabal_character_table WHERE CharacterIdx/8=$UserNum[0] AND Nation < 3"));

            //CHECK DADOS CHAR
            if ($chars[0]) {

                $CharON = array_column($chars, 'Login');

                //VERIFICA CONTA LOGADA
                if ((int)$CharON[0]) {
                    $message = 'Voce deve sair do jogo para acessar esta função';
                    return redirect()->back()->with('warning', $message);
                }

                //CHECK ID
                if(((int)$charidx/8) != (int)$UserNum[0])
                {
                    return redirect()->back();
                }

                // valor do PK
                $calcularPK = 2000 * $chars[0]->PKPenalty;

                if($chars[0]->Alz < $calcularPK)
                {
                    $message = 'Atenção, você não possui alz suficiente para limpar sua punição.';
                    return redirect()->back() ->with('warning', $message);
                }
                elseif($chars[0]->PKPenalty == 0)
                {
                    $message = 'Atenção, você não possui punição para limpar.';
                    return redirect()->back() ->with('warning', $message);
                }
                elseif($account[0]->AuthType ==2 || $account[0]->AuthType==3)
                {
                    $message = 'Atenção, sua conta está bloqueada não é possivel utiliza este sistema!';
                    return redirect()->back() ->with('danger', $message);
                }
                elseif($account[0]->AuthType ==4)
                {
                    $message = 'Atenção, sua conta está temporariamente desativada , é necessário ativa-lá para utilizar esté sistema!';
                    return redirect()->back() ->with('danger', $message);
                }
                else
                {
                    // LIMPAR PK
                    $db = env('DB_SERVER01'); // DB
                    $updateAlz = DB::update(DB::raw("UPDATE $db.[dbo].[cabal_character_table] SET Alz=Alz-$calcularPK WHERE CharacterIdx='$charidx'"));
                    $updatePK = DB::update(DB::raw("UPDATE $db.[dbo].[cabal_character_table] SET PKPenalty=0 WHERE CharacterIdx='$charidx'"));

                    if($updateAlz && $updatePK)
                    {
                        $message = 'Obrigado! sua penalidade foi limpa!';
                        return redirect()->back() ->with('success', $message);
                    }
                    else
                    {
                        $message = 'Falha tente novamente -503!';
                        return redirect()->back() ->with('danger', $message);
                    }


                }
            }
        }

    }
}
