<?php

namespace App\Http\Resources\UserScore;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ShowResourceCollection extends ResourceCollection
{
    /**
     * The resource that this resource collects.
     * @var string
     */
    public $collects = ShowResource::class;
}
