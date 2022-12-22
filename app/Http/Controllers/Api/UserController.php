<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreRequest;
use App\Http\Resources\UserLink\IndexResource;
use App\Repositories\LinkRepository;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    /**
     * UserController constructor.
     *
     * @param UserRepository $userRepository
     * @param LinkRepository $linkRepository
     */
    public function __construct(private UserRepository $userRepository, private LinkRepository $linkRepository)
    {
        //
    }


    /**
     * Create user.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('register');
    }

    /**
     * Store user.
     *
     * @param StoreRequest $request
     * @return JsonResponse
     * @throws Exception
     */
    public function store(StoreRequest $request): JsonResponse
    {
        $user = $this->userRepository->storeOrGetUser($request->validated());
        $link = $this->linkRepository->createUserLink($user);
        return (new IndexResource($link))->response();
    }
}
