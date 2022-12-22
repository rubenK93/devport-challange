<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserLink\ShowResourceCollection;
use App\Models\UserLink;
use App\Repositories\LinkRepository;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

class LinkController extends Controller
{
    /**
     * LinkController constructor.
     *
     * @param LinkRepository $repository
     */
    public function __construct(private LinkRepository $repository)
    {
        //
    }

    /**
     * @param UserLink $link
     * @return JsonResponse
     * @throws Exception
     */
    public function store(UserLink $link): JsonResponse
    {
        $user = $link->user;
        $this->repository->createUserLink($user, true);

        return (new ShowResourceCollection($user->manual_links))->response();
    }

    /**
     * @param UserLink $link
     * @return View|Factory|Application
     */
    public function show(UserLink $link): View|Factory|Application
    {
        $user = $link->user;
        $user->load('manual_links');

        return view('home', compact('link', 'user'));
    }

    /**
     * @param UserLink $currentLink
     * @param UserLink $link
     * @return JsonResponse
     */
    public function deactivateLink(UserLink $currentLink, UserLink $link): JsonResponse
    {
        $user = $currentLink->user;
        $this->repository->deactivateUserLink($link);

        return (new ShowResourceCollection($user->manual_links))->response();
    }
}
