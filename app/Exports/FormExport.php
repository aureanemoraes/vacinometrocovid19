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

    public function __construct($time, $delimiter = ',')
    {
        $this->time = $time;
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
        if($this->time == null) {
            $immunizeds = Form::all();
        } else {
            $immunizeds = Form::whereBetween('created_at', [$this->time, now()])->get();
        }
        return view('import')->with('immunizeds', $immunizeds);
    }
}
