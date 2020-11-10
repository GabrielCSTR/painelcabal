<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ConversorController extends Controller
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

            $temp = $chars[0]->PlayTime / 60;
            $Horas = floor($temp);

            return view('user.pages.conversor.index', [
                'chars' => $chars,
                'horas' => $Horas,
                'charidx' => $chars[0]->CharacterIdx
            ]);
        }
    }

    public function update(Request $request, $charidx)
    {
        if($request->txtHoras <= 0)
        {
            $message = 'Informe a quantidade de horas que você quer converter.';
            return redirect()->back()->with('warning', $message);
        }
        elseif(preg_match("/[^0-9]/i", $request->txtHoras))
        {
            $message = 'Digite apenas numeros';
            return redirect()->back()->with('warning', $message);
        }

        //salva dados do usuario logado
        $this->user = Auth::user();
        $username = $this->user->name;

        $db = env('DB_ACCOUNT'); // DB
        $account = DB::select(DB::raw("SELECT * FROM $db.dbo.cabal_auth_table WHERE ID='$username'"));

        if ($account) {

            // USERNUM
            $UserNum = array_column($account, 'UserNum');

            if ($account[0]->AuthType == 2 || $account[0]->AuthType == 3) {
                $message = 'Atenção, sua conta está bloqueada não é possivel utiliza este sistema!';
                return redirect()->back()->with('danger', $message);
            } elseif ($account[0]->AuthType == 4) {
                $message = 'Atenção, sua conta está temporariamente desativada , é necessário ativa-lá para utilizar esté sistema!';
                return redirect()->back()->with('danger', $message);
            }

            // DB
            $db = env('DB_SERVER01');
            //SELECT CHARS
            $chars = DB::select(DB::raw("SELECT * FROM $db.dbo.cabal_character_table WHERE CharacterIdx/8=$UserNum[0] AND Nation < 3"));

            //CHECK DADOS CHAR
            if ($chars[0]) {

                //CHECK ID
                if(((int)$charidx/8) != (int)$UserNum[0])
                {
                    return redirect()->back();
                }

                $txtHoras = $chars[0]->PlayTime/60;

                if($chars[0]->PlayTime/60 <= 0)
                {
                    $message = 'Voce nao possui HORAS suficiente para converter.';
                    return redirect()->back()->with('warning', $message);
                }
                elseif($request->txtHoras > $txtHoras)
                {
                    $message = 'Voce ultrapassou quantidade de HORAS disponiveis';
                    return redirect()->back()->with('warning', $message);
                }
                else
                {
                    //TOTAL HORAS
                    $horasDisminuir = $request->txtHoras;
                    $db = env('DB_SERVER01'); // DB
                    $updateHoras = DB::update(DB::raw("USE $db exec SP_CONVERSORPERSONAGEM '$horasDisminuir','$charidx','$UserNum[0]'"));

                    if($updateHoras)
                    {
                        $message = 'Suas horas foram convertidas para CASH com sucesso';
                        return redirect()->back()->with('success', $message);
                    }
                    else
                    {
                        $message = 'Falha durante o processo -605';
                        return redirect()->back()->with('danger', $message);
                    }

                }

            }
        }
    }
}
