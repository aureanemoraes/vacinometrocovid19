<?php

namespace App\Exports;

use App\Models\Form;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;

class FormExport implements FromQuery
{
    use Exportable;

    public function __construct($initialDate, $finalDate)
    {
        $this->initialDate = Carbon::parse($initialDate);
        $this->finalDate = Carbon::parse($finalDate);

    }

    public function query()
    {
        //dd($this->initialDate, $this->finalDate);
        return Form::query()->whereBetween('created_at', [$this->initialDate, $this->finalDate]);
    }
}
