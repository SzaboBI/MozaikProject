<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Password implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $pattern = '/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[_\.:;])[A-Za-z\d_\.:;]+$/';
        return preg_match($pattern, $value) == 1;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'A jelszónak tartalmaznia kell minimum egy nagybetűt, egy kisbetűt, egy számjegyet és 1 speciális karaktert (_.:;)!';
    }
}
