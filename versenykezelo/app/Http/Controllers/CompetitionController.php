<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Competitions;
use App\Models\Rounds;

use Session;

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
            return view('welcome', ['competitions' => $competitions]);
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
            return view('welcome',['competitions' => $competitions]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

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
        $rounds = Rounds::where('c_name',$name)
                        ->where('c_year',$year)
                        ->get();
        return view('competitiondetails',['competition' => $competition, 'rounds' => $rounds]);
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
        return view('competitionedit', ['competition' => $competition]);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
