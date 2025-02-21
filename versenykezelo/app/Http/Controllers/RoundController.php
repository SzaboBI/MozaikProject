<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use App\Models\Competitions;
use App\Models\Rounds;
use App\Models\User;

use Closure;

class RoundController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $c_name, $c_year)
    {
        $countCompetition = Competitions::where('name',$c_name)
                            ->where('year',$c_year)
                            ->count();
        if ($countCompetition == 0) {
            return redirect()->route('competitions');
        }
        else{
            $competition = Competitions::where('name',$c_name)
                        ->where('year',$c_year)->first();
            $validator = Validator::make($request->all(),[
                'rNumber' => ['required', 'integer', 'min:1', function (string $attribute, mixed $value, Closure $fail) use ($c_name, $c_year){
                    $roundCount= Rounds::where('c_name',$c_name)
                                ->where('c_year', $c_year)
                                ->where('roundNumber', $value)
                                ->count();
                            if ($roundCount > 0) {
                                $fail('Létezik már ehhez a versenyhez, ilyen forduló!');
                            }
                }],
            ],[
                'rNumber.required' => 'A forduló sorszáma mezőt ki kell tölteni!',
                'rNumber.integer' => 'Érvénytelen sorszám formátum!',
                'rNumber.min' => 'Érvénytelen sorszám formátum!',
            ])->validate();
            $rounds = new Rounds();
            $rounds-> roundNumber = $request-> rNumber;
            $rounds-> c_name = $c_name;
            $rounds-> c_year = $c_year;
            $rounds->save();
            return redirect()->route('showCompetition', ['name'=> $c_name, 'year' => $c_year]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $round= Rounds::find($id);
        $c_users_query = DB::table('users')
                    ->join('versenyzoks','users.email','=','versenyzoks.u_email')
                    ->where('versenyzoks.r_id',$id);
        if ($c_users_query-> count() == 0) {
            $c_users = array();
        }
        else {
            $c_users = $c_users_query-> get();
        }
        $users= User::where('admin', 0)->get();
        return view('roundedit',['round'=> $round, 'c_users'=> $c_users, 'users'=> $users]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $round = Rounds::find($id);
        $validator = Validator::make($request->all(),[
            'email' => ['required','email',function (string $attribute, mixed $value, Closure $fail) use ($round){
                $emailAttachedCount = DB::table('versenyzoks')
                                        ->where('r_id', $round-> id)
                                        ->where('u_email', $value)
                                        ->count();
                if ($emailAttachedCount > 0) {
                    $fail('A felhasználó már hozzá van rendelve a fordulóhoz!');
                }
            }]
        ])->validate();
        DB::table('versenyzoks')->insert(['u_email'=> $request->email, 'r_id' => $id]);
        return redirect()->route('showCompetition',['name' => $round-> c_name, 'year'=> $round-> c_year]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $round = Rounds::find($id);
        $round->delete();
        return redirect()->route('showCompetition',['name'=>$round->c_name, 'year'=>$round->c_year]);
    }

    public function deleteUserRoundConnection($id, $email){

        $countConnection= DB::table('versenyzoks')->where('r_id',$id)-> where('u_email',$email)->count();
        if ($countConnection == 0) {
            return redirect()->route('roundEdit', ['id' => $id])->withErrors(['email' => 'Nincs hozzáadva a megadott felhasználó az adott fordulóhoz!']);
        }
        else {
            DB::table('versenyzoks')->where('r_id',$id)-> where('u_email',$email)->delete();
            return redirect()->route('roundEdit', ['id' => $id]);
        }
    }
}
