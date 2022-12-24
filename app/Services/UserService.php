<?php

namespace App\Services;

use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService extends User
{
    /**
     * Register new user and company.
     *
     * @param $firstName
     * @param $lastName
     * @param $email
     * @param $password
     * @param $companyName
     * @param $countryId
     * @param $businessUrl
     * @param $address
     * @return mixed
     */
    public function registration(
        $firstName,
        $lastName,
        $email,
        $password,
        $companyName,
        $countryId,
        $businessUrl = null,
        $address = null
    ){
            $company = Company::where('name', $companyName)->first();
            $company = $company === null ? Company::create(['name' => $companyName]) : $company;

            $user = $this->create([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $email,
                'password' => Hash::make($password),
                'company_id' => $company->id,
                'business_url' => $businessUrl,
                'country_id' => $countryId,
                'address' => $address,
                'user_token' => Hash::make('random_token')
            ]);

        return $user;
    }

    public function authorize($email, $password)
    {
        $user = $this->where(['email' => $email])->first();
        $user = Hash::check($password, $user->password) ? $user : null;

        return $user;
    }

    public function checkToken($token)
    {
        $user = $this->where('user_token', $token)->first();

        return $user;
    }
}

