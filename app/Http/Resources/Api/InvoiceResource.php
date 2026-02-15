<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'reference_no' => $this->reference_no,
            'provider_no' => $this->provider_no,
            'collection_no' => $this->collection_no,
            'status' => $this->status,
            'amount' => number_format($this->amount / 100, 2),
            'currency' => $this->currency,
            'batch' => $this->batch,
            'retry' => $this->retry,
            'created_at' => $this->created_at,
        ];
    }
}
