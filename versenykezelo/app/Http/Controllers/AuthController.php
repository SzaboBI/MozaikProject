<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use App\Rules\Password;

use App\Models\User;
use Closure;
use Hash;

class AuthController extends Controller
{
    public function showRegister(){
        return view('register');
    }
    
    public function login(Request $request): RedirectResponse {
        $validator = Validator::make($request->all(), [
            'emailAddress' => ['required', 'email'],
            'password' => ['required'],
        ])->validate();
        if ($validator->fails()){
            return redirect('/')->withErrors($validator->errors());
        }
    }

    public function register(Request $request){
        $passwdAgain = $request-> passwdAgain;
        $validator = Validator::make($request->all(),[
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
            'email.email' => 'Nem megfelelő e-mail cím formátumot adott meg!',
            'email.unique' => 'Az e-mail címmel már regisztráltak!',
            'name.require' => 'A teljes név mezőt meg kell adni!',
            'passwd.required' => 'A jelszó mezőt meg kell adni!',
            'passwd.regex' => 'A jelszónak tartalmaznia kell minimum egy nagybetűt, egy kisbetűt, egy számjegyet és 1 speciális karaktert (_.:;)!',
            'passwd.min' => 'A jelszónak legalább 8 karakter hosszúnak kell lennie!',
            'passwdAgain.required' => 'A jelszó mégegyszer mezőt ki kell tölteni!',
            'postcode.required' => 'Az irányítószám mezőt meg kell adni!',
            'postcode.between', 'postcode.integer' => 'Megfelelő irányítószámot kell megadni!',
            'c.required' => 'A település mezőt meg kell adni!',
            'street.required' => 'Az utca mezőt meg kell adni!',
            'house.required' => 'A házszám mezőt meg kell adni!',
            'house.integer', 'house.min' => 'Megfelelő házszámot kell megadni!',
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
        $result = $user-> save();
    }
}
