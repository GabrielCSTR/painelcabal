<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProfileController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //salva dados do usuario logado
        $this->user = Auth::user();
        //username
        $username = $this->user->name;

        $db = env('DB_ACCOUNT'); // DB 
        $profile = DB::select( DB::raw("SELECT * FROM $db.dbo.cabal_auth_table WHERE ID='$username'") );

        return view('user.pages.profile.index', [
            'profile' => $profile,
        ]);
    }

    public function edit($id)
    {
        //salva dados do usuario logado
        $this->user = Auth::user();
        $username = $this->user->name;

        $db = env('DB_ACCOUNT'); // DB 
        $profile = DB::select( DB::raw("SELECT * FROM $db.dbo.cabal_auth_table WHERE ID='$username'") );

        return view('user.pages.profile.edit',[
            'profile' => $profile
        ]);
    }

    public function update(Request $request, $id)
    {
        //salva dados do usuario logado
        $this->user = Auth::user();
        $username = $this->user->name;
        $db = env('DB_ACCOUNT'); // DB 
        $profile = DB::select( DB::raw("SELECT * FROM $db.dbo.cabal_auth_table WHERE ID='$username'") );
        
        //$profile->update($request->all());

        //dd($request->all());

        return redirect()->route('user.index');
    }
}
