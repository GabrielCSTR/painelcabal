<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CharsController extends Controller
{
    public function index()
    {
        // DB 
        $db = env('DB_SERVER01');
        //SELECT CHARS 
        $chars = DB::select( DB::raw("SELECT * FROM $db.dbo.cabal_character_table WHERE CharacterIdx/8=5") );
        //dd($chars);
    
        return view('user.pages.chars.index', [
            'chars' => $chars
        ]);
    } 

    public function show($charidx)
    {
        // DB 
        $db = env('DB_SERVER01');
        //SELECT CHARS 
        $chars = DB::select( DB::raw("SELECT * FROM $db.dbo.cabal_character_table WHERE CharacterIdx=$charidx") );
        //dd($chars);

        return view('user.pages.chars.viewchar', [
            'chars' => $chars
        ]);
    }
}
