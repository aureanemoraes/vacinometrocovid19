<?php

namespace App\Exports;

use App\Models\Form;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromView;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Illuminate\Contracts\View\View;


class FormExport implements FromView, WithCustomCsvSettings
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

    public function view(): View
    {
        $immunizeds = Form::whereBetween('created_at', [$this->initialDate, $this->finalDate])->get();
        //dd($immunizeds[0]);
        return view('import')->with('immunizeds', $immunizeds);
    }
}
