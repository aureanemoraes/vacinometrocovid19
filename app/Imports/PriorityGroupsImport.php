<?php

namespace App\Imports;

use App\Models\PriorityGroup;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\Importable;

class PriorityGroupsImport implements ToModel, WithHeadingRow, WithCustomCsvSettings
{
    use Importable;

    public function getCsvSettings(): array
    {
        return [
            'demiliter' => ','
        ];
    }

    public function model(array $row)
    {
        //dd($row);
        if(isset($row['codigo']) && isset($row['titulo'])) {
            return new PriorityGroup([
                'name' => $row['codigo'] . ' - ' . $row['titulo']
            ]);
        } else {
            return null;
        }
        
    }
}
