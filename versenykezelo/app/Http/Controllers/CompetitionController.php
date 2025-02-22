<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;

use App\Models\Competitions;
use App\Models\Rounds;
use App\Models\User;

use Session;
use Closure;

class CompetitionController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = DB::table('users')->where('email', Session::get('loginEmail'))->first();
        $userIsAdmin = $user->admin;
        if ($userIsAdmin == 1) {
            $competitions = Competitions::all();
            return view('welcome', ['competitions' => $competitions, 'isAdmin' => $userIsAdmin]);
        }
        else {
            $competitions = DB::table('competitions')
                                ->join('rounds',function ($join){
                                    $join->on('competitions.name','=','rounds.c_name');
                                    $join->on('competitions.year','=','rounds.c_year');
                                })
                                ->join('versenyzoks','rounds.id','=','versenyzoks.r_id')
                                ->where('versenyzoks.u_email','like',$user->email)
                                ->get();
            return view('welcome',['competitions' => $competitions, 'isAdmin' => $userIsAdmin]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('competitionedit');

    }

    public function store(Request $request): RedirectResponse
    {
        $newName = $request->name;
        $newYear = $request->year;
        $validator = Validator::make($request->all(),[
            'name' => ['required', function (string $attribute, mixed $value, Closure $fail) use ($newName, $newYear){
                $countCompetition = Competitions::where('name',$newName)
                            ->where('year',$newYear)
                            ->count();
                if ($countCompetition > 0) {
                    $fail('Létezik már ilyen elem az adatbázisban!');
                }
            }],
            'year' => ['required', 'integer'],
            'goodanswerpoint' => ['required','integer'],
            'badanswerpoint' => ['required','integer'],
            'emptyanswerpoint' => ['required','integer'],
        ],[
            'name.required' => 'A név mezőt ki kell tölteni!',
            'year.required' => 'Az év mezőt ki kell tölteni!',
            'year.integer' => 'Érvénytelen évszám formátum!',
            'goodanswerpoint.required' => 'A jó válaszért járó pont mezőt ki kell tölteni!',
            'goodanswerpoint.integer' => 'Érvénytelen pontszám formátum!',
            'badanswerpoint.required' => 'A rossz válaszért járó pont mezőt ki kell tölteni!',
            'badanswerpoint.integer' => 'Érvénytelen pontszám formátum!',
            'emptyanswerpoint.required' => 'Az üres válaszért járó pont mezőt ki kell tölteni!',
            'emptyanswerpoint.integer' => 'Érvénytelen pontszám formátum!',
        ])->validate();
        $competition = new Competitions();
        $competition-> name = $request-> name;
        $competition-> year = $request-> year;
        $competition-> pointsForGoodAnswer = $request-> goodanswerpoint;
        $competition-> pointsForBadAnswer = $request-> badanswerpoint;
        $competition-> poinstForEmptyAnswer = $request-> emptyanswerpoint;
        $competition-> save();
        return redirect()->route('competitions');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($name,$year)
    {
        $competition = Competitions::where('name',$name)
                        ->where('year',$year)
                        ->first();
        $user = DB::table('users')->where('email', Session::get('loginEmail'))->first();
        $userIsAdmin = $user->admin;
        $rounds = array();
        if ($userIsAdmin == 1) {
            $rounds = Rounds::where('c_name',$name)
                        ->where('c_year',$year)
                        ->get();
        }
        else {
            $rounds = DB::table('rounds')
                        ->join('versenyzoks','r_id','like','id')
                        ->where('versenyzoks.u_email','like',$user->email)
                        ->where('c_name',$name)
                        ->where('c_year',$year)
                        ->get();
        }
        return view('competitiondetails',['competition' => $competition, 'rounds' => $rounds, 'isAdmin' => $userIsAdmin]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($name, $year)
    {
        $competition = Competitions::where('name',$name)
                        ->where('year',$year)
                        ->first();
        return view('competitionedit', compact('competition'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $name, $year)
    {
        if ($request->name == $name && $request->year == $year) {
            $validator = Validator::make($request->all(),[
                'goodanswerpoint' => ['required','integer'],
                'badanswerpoint' => ['required','integer'],
                'emptyanswerpoint' => ['required','integer'],
            ],[
                'goodanswerpoint.required' => 'A jó válaszért járó pont mezőt ki kell tölteni!',
                'goodanswerpoint.integer' => 'Érvénytelen pontszám formátum!',
                'badanswerpoint.required' => 'A rossz válaszért járó pont mezőt ki kell tölteni!',
                'badanswerpoint.integer' => 'Érvénytelen pontszám formátum!',
                'emptyanswerpoint.required' => 'Az üres válaszért járó pont mezőt ki kell tölteni!',
                'emptyanswerpoint.integer' => 'Érvénytelen pontszám formátum!',
            ])->validate();
            $affected = DB::table('competitions')
                ->where('name',$name)
                ->where('year',$year)
                ->update(['pointsForGoodAnswer' => $request->goodanswerpoint, 
                        'pointsForBadAnswer' => $request->badanswerpoint,
                        'poinstForEmptyAnswer' => $request->emptyanswerpoint
                    ]);
            return redirect()->route('competitions');
        }
        else{
            $newName = $request->name;
            $newYear = $request->year;
            $validator = Validator::make($request->all(),[
                'name' => ['required', function (string $attribute, mixed $value, Closure $fail) use ($newName, $newYear){
                    $countCompetition = Competitions::where('name',$newName)
                                ->where('year',$newYear)
                                ->count();
                    if ($countCompetition > 0) {
                        $fail('Létezik már ilyen elem az adatbázisban!');
                    }
                }],
                'year' => ['required', 'integer'],
                'goodanswerpoint' => ['required','integer'],
                'badanswerpoint' => ['required','integer'],
                'emptyanswerpoint' => ['required','integer'],
            ],[
                'name.required' => 'A név mezőt ki kell tölteni!',
                'year.required' => 'Az év mezőt ki kell tölteni!',
                'year.integer' => 'Érvénytelen évszám formátum!',
                'goodanswerpoint.required' => 'A jó válaszért járó pont mezőt ki kell tölteni!',
                'goodanswerpoint.integer' => 'Érvénytelen pontszám formátum!',
                'badanswerpoint.required' => 'A rossz válaszért járó pont mezőt ki kell tölteni!',
                'badanswerpoint.integer' => 'Érvénytelen pontszám formátum!',
                'emptyanswerpoint.required' => 'Az üres válaszért járó pont mezőt ki kell tölteni!',
                'emptyanswerpoint.integer' => 'Érvénytelen pontszám formátum!',
            ])->validate();

            /*$competition = Competitions::where('name', $name)
                        ->where('year', $year)
                        ->first();
            $competition->email = $newName;
            $competition->year = $newYear;
            $competition->save();*/
            $affected = DB::table('competitions')
                ->where('name',$name)
                ->where('year',$year)
                ->update(['name' => $request->name, 
                        'year' => $request->year, 
                        'pointsForGoodAnswer' => $request->goodanswerpoint, 
                        'pointsForBadAnswer' => $request->badanswerpoint,
                        'poinstForEmptyAnswer' => $request->emptyanswerpoint
                    ]);
            return redirect()->route('competitions');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($name,$year)
    {
        $competition = Competitions::where('name','=',$name)
                        ->where('year','=',$year)
                        ->delete();
        return redirect()->route('competitions');
    }
}
