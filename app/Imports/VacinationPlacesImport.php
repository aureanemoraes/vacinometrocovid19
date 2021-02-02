<?php

namespace App\Imports;

use App\Models\VacinationPlace;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\Importable;

class VacinationPlacesImport implements ToModel, WithHeadingRow, WithCustomCsvSettings
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
        if(isset($row['estabelecimento']) && isset($row['cnes'])) {
            return new VacinationPlace([
                'name' => $row['cnes'] . ' - ' . $row['estabelecimento']
            ]);
        } else {
            return null;
        }
        
    }
}
