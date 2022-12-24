<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthorisationRequest;
use App\Http\Requests\CheckTokenRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\UserService;
use Flugg\Responder\Http\Responses\SuccessResponseBuilder;
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
     * @return SuccessResponseBuilder | JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        $userSaved = $this->userService->registration(
            $request->first_name,
            $request->last_name,
            $request->email,
            $request->password,
            $request->company_name,
            $request->country_id,
            $request->business_url,
            $request->address
        );

        return $userSaved
            ? responder()->success()
            : responder()->error(500, 'Server error')->respond(500);
    }

    /**
     * @param AuthorisationRequest $request
     * @return JsonResponse
     */
    public function authorisation(AuthorisationRequest $request): JsonResponse
    {
        $user = $this->userService->authorize($request->email);

        return Hash::check($request->password, $user->password)
            ? responder()->success($user)->respond()
            : $this->userService->unauthorisedResponse();
    }

    /**
     * @param CheckTokenRequest $request
     * @return JsonResponse
     */
    public function loginWithToken(CheckTokenRequest $request): JsonResponse
    {
        $user = $this->userService->checkToken($request->user_token);

        return $user===null
            ? $this->userService->unauthorisedResponse()
            : responder()->success($user)->respond();
    }
}
