<?php

namespace App\Imports;

use App\Factories\ProjectFactory;
use App\Models\Project;
use App\Models\Type;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ProjectsImport implements ToCollection
{
    private function getTypesMap($types): array
    {
        $map = [];

        foreach ($types as $type) {
            $map[$type->title] = $type->id;
        }

        return $map;
    }

    public function collection(Collection $collection)
    {
        $types = $this->getTypesMap(Type::all());

        foreach ($collection as $row) {
            if ($row->isEmpty() || $row[0] === 'Тип') {
                continue;
            }

            dump($row[2]);

            $project = ProjectFactory::make($types, $row->toArray());

            Project::updateOrCreate([
                'type_id' => $project['type_id'],
                'title' => $project['title'],
                'comment' => $project['comment'],
                'contracted_at' => $project['contracted_at'],
                'created_at_date' => $project['created_at_date'],
            ], $project);
        }
    }
}
