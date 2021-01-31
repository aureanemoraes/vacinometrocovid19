<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\VacinationPlace;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Exports\FormExport;
use PDF;

class IndexController extends Controller
{

    public function index()
    {
        $forms = Form::all();
        $vacinationplaces = VacinationPlace::withCount('forms')->get();

        return view('vaccinated_index')
            ->with('forms', $forms)
            ->with('vacinationplaces', $vacinationplaces);
    }

   public function export(Request $request) {
       $initial_date = $request->input('initial_date');
       $final_date = $request->input('final_date');
       $export_type = $request->input('export_type');
       switch($export_type) {
           case 'csv_virgula':
               return (new FormExport($initial_date, $final_date, ','))->download('vacinometrocovid19_'.$initial_date.'_to_'.$final_date.'.csv');
               break;
           case 'csv_ponto_virgula':
               return (new FormExport($initial_date, $final_date, ';'))->download('vacinometrocovid19_'.$initial_date.'_to_'.$final_date.'.csv');
               break;
           case 'xlsx':
               return (new FormExport($initial_date, $final_date, ';'))->download('vacinometrocovid19_'.$initial_date.'_to_'.$final_date.'.xlsx');
               break;
           case 'pdf':
               $initial_date_formatted = Carbon::parse($initial_date);
               $final_date_formatted = Carbon::parse($final_date);
               //$immunizeds = Form::whereBetween('created_at', [$initial_date_formatted, $final_date_formatted])->get();
                $immunizeds = Form::all();
               $pdf = PDF::loadView('import', compact('immunizeds'));
               return $pdf->download('import.pdf');
               break;
       }
   }
}
