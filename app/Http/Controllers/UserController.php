<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthorisationRequest;
use App\Http\Requests\CheckTokenRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\UserService;
use Flugg\Responder\Http\Responses\SuccessResponseBuilder;

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
     * @return SuccessResponseBuilder
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

        return responder()->success([$user]);
    }

    /**
     * @param AuthorisationRequest $request
     * @return SuccessResponseBuilder
     */
    public function authorisation(AuthorisationRequest $request)
    {
        $user = $this->userService->authorize($request->email, $request->password);

        return responder()->success([$user]);
    }

    /**
     * @param CheckTokenRequest $request
     * @return SuccessResponseBuilder
     */
    public function loginWithToken(CheckTokenRequest $request)
    {
        $user = $this->userService->checkToken($request->user_token);

        return responder()->success([$user]);
    }
}
