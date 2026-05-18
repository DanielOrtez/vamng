<?php

declare(strict_types=1);

namespace App\Actions\Fortify;

use App\Concerns\CreateUserValidationRules;
use App\Concerns\PasswordValidationRules;
use App\Concerns\ProfileValidationRules;
use App\Models\User;
use App\Settings\GeneralSettings;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

final class CreateNewUser implements CreatesNewUsers
{
    use CreateUserValidationRules;
    use PasswordValidationRules;
    use ProfileValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            ...$this->profileRules(),
            ...$this->extraCreateUserRules(),
            'password' => $this->passwordRules(),
        ])->validate();

        return User::query()->create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => $input['password'],
            'country' => $input['country'],
            'rank_id' => app(GeneralSettings::class)->va_default_rank,
            'hub_id' => $input['hub'],
            'curr_airport_id' => $input['hub'],
        ]);
    }
}
