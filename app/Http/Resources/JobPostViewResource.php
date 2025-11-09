<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobPostViewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // jobPostDatesが複数ある場合にそれぞれ展開
        $dates = $this->jobPostDates->map(fn ($d) => [
            'id' => $this->id,
            'client_id' => $this->client_id,
            'client_name' => $this->client->name ?? '',
            'work_date' => $d->work_date,
            'event_name' => $this->event_name,
            'prefecture' => $this->prefecture,
            'location' => $this->location,
            'description' => $this->description,
            'payment' => $this->payment,
            'contact_method' => $this->contact_method,
            'is_closed' => (bool) $this->is_closed,
            'number_of_position' => (int) $this->number_of_position,
            'deadline' => $this->deadline,
            'tags' => $this->jobTags->map(fn ($t) => [
                'id' => $t->id,
                'name' => $t->name,
            ]),
        ]);

        return $dates;
    }
}
