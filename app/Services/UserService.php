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
     * @return bool
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
        $this->first_name = $firstName;
        $this->last_name = $lastName;
        $this->email = $email;
        $this->password = Hash::make($password);
        $this->company_id = Company::firstOrCreate(['name' => $companyName])->id;
        $this->business_url = $businessUrl;
        $this->country_id = $countryId;
        $this->address = $address;
        $this->user_token = Hash::make('random_token');

        return $this->save();
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
        return responder()->error(401, 'Unauthorized request')->respond(401);
    }

}

