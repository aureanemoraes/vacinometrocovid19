<?php

namespace App\Imports;

use App\Models\Form;
use Carbon\Carbon;
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
        if(!isset($row['nome'])){
            return null;
        }

        $prioritygroup = trim($row['grupo_prioritario']);
        $vaccinationplace = trim($row['unidade_de_saude']);
        $exists = Form::whereHas('prioritygroup', function( $query) use($prioritygroup){
            $query->where('name', '=', $prioritygroup);
        })->whereHas('vacinationplace', function ( $query) use($vaccinationplace) {
            $query->where('name', '=', $vaccinationplace);
        })->where('name', trim($row['nome']))->where('age', trim($row['idade']))->where('dose', trim($row['dose']))->first();
       // dd($exists);
        if(isset($exists)) {
            return null;
        } else {
            if(isset($row['criado_em'])) {
                return new Form([
                    'name' => trim($row['nome']),
                    'age' => trim($row['idade']),
                    'priority_group' => trim($row['grupo_prioritario']),
                    'vacination_place' => trim($row['unidade_de_saude']),
                    'vaccinated' => 1,
                    'dose' => trim($row['dose']),
                    'created_at' => Carbon::parse($row['criado_em'])
                ]);
            } else {
                return new Form([
                    'name' => trim($row['nome']),
                    'age' => trim($row['idade']),
                    'priority_group' => trim($row['grupo_prioritario']),
                    'vacination_place' => trim($row['unidade_de_saude']),
                    'vaccinated' => 1,
                    'dose' => trim($row['dose'])
                ]);
            }
        }
    }
}
