<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaginateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'from' => $this->first()->from,
            'to' => $this->last()->to,
            'total' => $this->total(),
            'currentPage' => $this->currentPage(),
            'firstPageUrl' => $this->url(1),
            'lastPage' => $this->lastPage(),
            'lastPageUrl' => $this->url($this->lastPage()),
            'nextPageUrl' => $this->nextPageUrl(),
            'path' => $this->url($this->currentPage()),
            'perPage' => $this->perPage(),
            'prevPageUrl' => $this->previousPageUrl(),
        ];
    }
}