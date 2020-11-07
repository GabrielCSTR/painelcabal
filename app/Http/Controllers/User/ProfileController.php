<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $db = env('DB_ACCOUNT'); // DB 
        $profile = DB::select( DB::raw("SELECT * FROM $db.dbo.cabal_auth_table WHERE ID='admin'") );
        //$result = DB::select('select * from ?.dbo.cabal_character_table where CharacterIdx/8=5', [$db]);
        //dump($profile);
        
        return view('user.pages.profile.index', [
            'profile' => $profile,
        ]);
    }

    public function edit($id)
    {
        $db = env('DB_ACCOUNT'); // DB 
        $profile = DB::select( DB::raw("SELECT * FROM $db.dbo.cabal_auth_table WHERE ID='admin'") );

        return view('user.pages.profile.edit',[
            'profile' => $profile
        ]);
    }

    public function update(Request $request, $id)
    {
        $db = env('DB_ACCOUNT'); // DB 
        $profile = DB::select( DB::raw("SELECT * FROM $db.dbo.cabal_auth_table WHERE ID='admin'") );
        
        //$profile->update($request->all());

        //dd($request->all());

        return redirect()->route('user.index');
    }
}
