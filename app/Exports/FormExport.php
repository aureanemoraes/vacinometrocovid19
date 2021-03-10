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

    public function __construct($time, $delimiter = ',', $dose)
    {
        $this->time = $time;
        $this->delimiter = $delimiter;
        $this->dose = $dose;
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
            $immunizeds = Form::select('id', 'name', 'age', 'vacinationplace_id', 'prioritygroup_id', 'created_at', 'dose')
                ->where('vaccinated', 1)
                ->where('dose', $this->dose)->get();;
        } else {
            $immunizeds = Form::select('id', 'name', 'age', 'vacinationplace_id', 'prioritygroup_id', 'created_at', 'dose')
                ->where('vaccinated', 1)
                ->where('dose', $this->dose)
                ->whereBetween('created_at', [$this->time, now()])->get();
        }
        return view('import')->with('immunizeds', $immunizeds);
    }
}
