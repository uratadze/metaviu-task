<?php

namespace App\Services;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
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

        return $user->with(['company', 'country']);
    }

    /**
     * Get user data from email.
     *
     * @param $email
     * @return Builder|Model|object|null
     */
    public function authorize($email)
    {
        $user = $this->with(['company', 'country'])->where(['email' => $email])->first();

        return $user;
    }

    /**
     * Get user data from token.
     *
     * @param $token
     * @return Builder|Model|object|null
     */
    public function checkToken($token)
    {
        $user = $this->with(['company', 'country'])->where('user_token', $token)->first();

        return $user;
    }

    /**
     * User unauthorised request response.
     *
     * @return JsonResponse
     */
    public function unauthorisedResponse(): JsonResponse
    {
        return responder()->error(401, 'Unauthorised request')->respond(401);
    }

}

