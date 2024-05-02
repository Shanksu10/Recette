<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Mockery\Undefined;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'firstName' => ['required', 'regex:/^[a-zA-Z ]+$/', 'max:255'],
            'lastName' => ['required', 'regex:/^[a-zA-Z ]+$/', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
            'password_confirmation' => 'required|same:password',
            'birthday' => ['required', 'date', 'after_or_equal:01/01/1920', 'before:01/01/2013'],
            'picture' => ['nullable', 'image', 'mimes:jpeg,png,jpg'],
            'agreeTerms' => ['required'],
        ])->validate();
        if(array_key_exists('picture', $input))
        {
            $pic = $input['picture'];
            $imageName = time() . '.' . $pic->extension();
            $pic->move(public_path('/assets/img/user'), $imageName);
        }
        else
        {
            $imageName = null;
        }
        return User::create([
            'first_name' => $input['firstName'],
            'last_name' => $input['lastName'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'birthday' => $input['birthday'],
            'picture' => $imageName
        ]);
    }
}
