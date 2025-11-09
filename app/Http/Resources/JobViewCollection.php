<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class JobPostsViewCollection extends ResourceCollection
{
    public function toArray($request)
    {
        // ResourceをflatMapで展開して1日付1件の形に
        return $this->collection
            ->flatMap(fn ($job) => JobPostViewResource::make($job))
            ->values();
    }
}
