<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Admin;
use Closure;
use Hash;
use Session;

class AuthController extends Controller
{
    public function showRegister(){
        return view('register');
    }

    public function showLogin(): RedirectResponse {
        return redirect()->route('welcome');
    }
    
    public function login(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'passwd' => ['required'],
        ], [
            'email.required' => 'Az e-mail cím mezőt ki kell tölteni!',
            'email.email' => 'Érvénytelen e-mail címet adott meg!',
            'passwd.required' => 'A jelszó mezőt meg kell adni!',
        ])->validate();
        $user = User::where('email', '=', $request->email)->first();
        if ($user && Hash::check($request->passwd, $user-> password)) {
            $request->session()->put('loginEmail', $user->email);
            return redirect()->route('welcome');
        }
        else{
            return redirect()->back()->withErrors('Hibás email cím vagy jelszó!');
        }

    }

    public function logout(Request $request){
        if (Session::has('loginEmail')) {
            $request->session()->invalidate();
        }
        return redirect()->route('welcome');
    }

    public function register(Request $request){
        $passwdAgain = $request-> passwdAgain;
        $validator = Validator::make($request->all(),[
            'userType' => [function (string $attribute, mixed $value, Closure $fail){
                if ($value != 'basic' && $value != 'admin') {
                    $fail("Érvénytelen felhasználó típus!");
                }
            } ],
            'email' => ['required', 'email', 'unique:users'],
            'name' => ['required'],
            'passwd' => ['required', 'min:8', 
                        'regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[_\.:;])[A-Za-z\d_\.:;]+$/', 
                        function (string $attribute, mixed $value, Closure $fail) use ($passwdAgain){
                            if ($value != $passwdAgain) {
                                $fail("A két jelszónak meg kell egyeznie!");
                            }
            }],
            'passwdAgain' => ['required'],
            'postcode' => ['required', 'integer', 'between:1000,9999'],
            'c' => ['required'],
            'street' => ['required'],
            'house' => ['required', 'integer', 'min:1'],
            'mobil' => ['required', 'regex:/\+36(?:20|30|70])[0-9]{7}+$/'],
        ], [
            'email.required' => 'Az e-mail cím mező ki kell tölteni!',
            'email.email' => 'Érvénytelen e-mail címet adott meg!',
            'email.unique' => 'Az e-mail címmel már regisztráltak!',
            'name.required' => 'A teljes név mezőt meg kell adni!',
            'passwd.required' => 'A jelszó mezőt meg kell adni!',
            'passwd.regex' => 'A jelszónak tartalmaznia kell minimum egy nagybetűt, egy kisbetűt, egy számjegyet és 1 speciális karaktert (_.:;)!',
            'passwd.min' => 'A jelszónak legalább 8 karakter hosszúnak kell lennie!',
            'passwdAgain.required' => 'A jelszó mégegyszer mezőt ki kell tölteni!',
            'postcode.required' => 'Az irányítószám mezőt meg kell adni!',
            'postcode.between' =>'Megfelelő irányítószámot kell megadni!',
            'postcode.integer' => 'Megfelelő irányítószámot kell megadni!',
            'c.required' => 'A település mezőt meg kell adni!',
            'street.required' => 'Az utca mezőt meg kell adni!',
            'house.required' => 'A házszám mezőt meg kell adni!',
            'house.integer' => 'Megfelelő házszámot kell megadni!',
            'house.min' => 'Megfelelő házszámot kell megadni!',
            'mobil.required' => 'A telefonszám mezőt meg kell adni!',
            'mobil.regex' => 'Nem megfelelő formátumú telefonszám!'
        ])->validate();
        $user = new User();
        $user ->fullname = $request -> name;
        $user ->email = $request-> email;
        $user ->password = Hash::make($request-> passwd);
        $user ->postcode = $request-> postcode;
        $user ->city = $request-> c;
        $user ->road = $request-> street;
        $user ->houseNumber = $request-> house;
        $user ->telephone = $request-> mobil;
        if ($request-> userType == 'basic') {
            $user ->admin = 0;
        }
        else if($request-> userType == 'admin'){
            $user ->admin = 1;
        }
        $result = $user-> save();
        return redirect()->route('competitions');
    }
}
