<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;

use App\Models\Competitions;
use App\Models\Rounds;

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
        //
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
        $round = Rounds::find($id);
        $round->delete();
        return redirect()->route('showCompetition',['name'=>$round->c_name, 'year'=>$round->c_year]);
    }
}
