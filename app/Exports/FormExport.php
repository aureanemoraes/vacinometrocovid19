<?php

namespace App\Exports;

use App\Models\Form;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;


class FormExport implements FromQuery, WithHeadings, WithCustomCsvSettings
{
    use Exportable;

    public function __construct($initialDate, $finalDate, $delimiter = ',')
    {
        $this->initialDate = Carbon::parse($initialDate);
        $this->finalDate = Carbon::parse($finalDate);
        $this->delimiter = $delimiter;

    }


    public function getCsvSettings(): array
    {
        return [
            'delimiter' => $this->delimiter,
            'use_bom' => true
        ];
    }

    public function headings(): array
    {
        return [
            '#',
            'Nome',
            'Idade',
            'Lugar de vacinação',
            'Grupo prioritário',
            'Criado em',
            'Atualizado em'
        ];
    }

    public function query()
    {
        //dd($this->initialDate, $this->finalDate);
        return Form::query()->whereBetween('created_at', [$this->initialDate, $this->finalDate]);
    }
}
