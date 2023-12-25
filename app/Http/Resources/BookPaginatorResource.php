<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookPaginatorResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'edition' => $this->edition,
            'year' => $this->year,
            'value' => $this->value,
            'publisher' => $this->publisher,
            'authors' => $this->authors,
            'subjects' => $this->subjects,
        ];
    }
}
