<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobSummaryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $jobCountsByDate = $this->jobCountsByDate->map(
            fn($item) => [
                $item->work_date => $item->total,
            ]
        );

        return [
            'success' => true,
            'data' => [
                'job_counts_by_date' => $jobCountsByDate,
                'jobs' => $this->jobs,
            ]
        ];
    }
}
