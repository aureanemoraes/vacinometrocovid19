<?php

namespace App\Imports;

use App\PriorityGroup;
use Maatwebsite\Excel\Concerns\ToModel;

class PriorityGroupsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new PriorityGroup([
            //
        ]);
    }
}
