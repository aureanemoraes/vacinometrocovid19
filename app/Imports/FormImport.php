<?php

namespace App\Imports;

use App\Models\Form;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
//USE Maatwebsite\Excel\Concerns\WithProgressBar;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;

class FormImport implements ToModel, WithHeadingRow, WithCustomCsvSettings
{
    use Importable;

    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ';',
            'input_encoding' => 'iso-8859-1'
        ];
    }


    public function model(array $row)
    {
       // dd($row);
        if(!isset($row['nome'])){
            return null;
        }

        if(isset($row['cpf'])) {
            $exists = Form::where('cpf', $row['cpf'])->first();
            if(isset($exists)) {
                return null;
            } else {
                return new Form([
                    'cpf' => $row['cpf'],
                    'name' => $row['nome'],
                    'age' => $row['idade'],
                    'prioritygroup_id' => $row['grupo_prioritario'],
                    'vacinationplace_id' => $row['unidade_de_saude']
                ]);
            }
        }

        return new Form([
            'name' => trim($row['nome']),
            'age' => trim($row['idade']),
            'prioritygroup_id' => trim($row['grupo_prioritario']),
            'vacinationplace_id' => trim($row['unidade_de_saude'])
        ]);



    }

}
