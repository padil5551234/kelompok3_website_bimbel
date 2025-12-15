<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'no_hp' => ['required', 'string', 'max:15'],
            'asal' => ['required', 'string', 'max:255'],
            'password' => $this->passwordRules(),
            'agree' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);

        // Assign user role
        $user->assignRole('user');

        // Create user details with no_hp and asal
        $user->usersDetail()->create([
            'id' => $user->id,
            'no_hp' => $input['no_hp'],
            'asal_sekolah' => $input['asal'],
        ]);

        return $user;
    }
}
