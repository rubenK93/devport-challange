<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserScore\StoreRequest;
use App\Http\Resources\UserScore\ShowResource;
use App\Http\Resources\UserScore\ShowResourceCollection;
use App\Models\UserLink;
use App\Models\UserScore;
use App\Repositories\ScoreRepository;
use Illuminate\Http\JsonResponse;

class ScoreController extends Controller
{
    /**
     * UserController constructor.
     *
     * @param ScoreRepository $scoreRepository
     */
    public function __construct(private ScoreRepository $scoreRepository)
    {
        //
    }

    /**
     * Get last 3 scores.
     *
     * @param UserLink $link
     * @return JsonResponse
     */
    public function index(UserLink $link): JsonResponse
    {
        $scores = $link->user->last_three_scores;
        return (new ShowResourceCollection($scores))->response();
    }

    /**
     * Store score.
     *
     * @param UserLink $link
     * @param StoreRequest $request
     * @param UserScore $score
     * @return JsonResponse
     */
    public function store(UserLink $link, StoreRequest $request, UserScore $score): JsonResponse
    {
        $data = $request->validated();
        $countedScore = $score->calculateScore($data['number']);
        $score = $this->scoreRepository->storeScore($link->user, $countedScore, $data['number']);

        return (new ShowResource($score))->response();
    }
}
