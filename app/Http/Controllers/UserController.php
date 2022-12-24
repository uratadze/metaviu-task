<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthorisationRequest;
use App\Http\Requests\CheckTokenRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    /**
     * @var UserService
     */
    protected $userService;

    /**
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        $user = $this->userService->registration(
            $request->first_name,
            $request->last_name,
            $request->email,
            $request->password,
            $request->company_name,
            $request->country_id,
            $request->business_url,
            $request->address
        );

        return responder()->success($user)->respond();
    }

    /**
     * @param AuthorisationRequest $request
     * @return JsonResponse
     */
    public function authorisation(AuthorisationRequest $request)
    {
        $user = $this->userService->authorize($request->email);

        return Hash::check($request->password, $user->password) ?
            responder()->success($user)->respond() :
            $this->userService->unauthorisedResponse();
    }

    /**
     * @param CheckTokenRequest $request
     * @return JsonResponse
     */
    public function loginWithToken(CheckTokenRequest $request)
    {
        $user = $this->userService->checkToken($request->user_token);

        if($user===null)
        {
            return $this->userService->unauthorisedResponse();
        }

        return responder()->success($user)->respond();
    }
}
