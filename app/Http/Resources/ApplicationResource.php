<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApplicationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'position' => $this->position,
            'link' => $this->link,
            'contact' => $this->contact,
            'applied_date' => $this->applied_date,
            'interview_date' => $this->interview_date,
            'salary' => $this->salary,
            'feedback' => $this->feedback,
            'status' => new StatusResource($this->whenLoaded('status')),
            'company' => new CompanyResource($this->whenLoaded('company')),
            'city' => new CityResource($this->whenLoaded('city')),
            'modality' => new ModalitiesResource($this->whenLoaded('modality')),
            'contract' => new ContractResource($this->whenLoaded('contract')),
            'category' => new CategoryResource($this->whenLoaded('category')),
        ];
    }
}
