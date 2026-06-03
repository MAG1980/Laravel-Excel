<?php

namespace App\Http\Resources\Project;

use App\Http\Resources\Type\TypeResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
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
            // Для генерации ресурса нужно передавать объект отношения, а не его ID
            'type' => new TypeResource($this->type),
            'title' => $this->title,
            'createdAtDate' => $this->created_at_date ? $this->created_at_date->format('Y-m-d') : null,
            'workerCount' => $this->worker_count,
            'serviceCount' => $this->service_count,
            'hasInvestors' => $this->has_investors ? 'Да' : 'Нет',
            'hasOutsource' => $this->has_outsource ? 'Да' : 'Нет',
            'isOnTime' => $this->is_on_time ? 'Да' : 'Нет',
            'isNetwork' => $this->is_network ? 'Да' : 'Нет',
            'deadline' => isset($this->deadline) ? $this->deadline->format('Y-m-d') : null,
            'contractedAt' => $this->contracted_at ? $this->contracted_at->format('Y-m-d') : null,
        ];
    }
}
