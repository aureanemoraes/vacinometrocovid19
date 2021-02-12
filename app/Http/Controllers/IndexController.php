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
        $forms = Form::select('id', 'name', 'age', 'birthdate', 'vacinationplace_id', 'prioritygroup_id', 'created_at')->where('vaccinated', 1)->get();

        //dd($forms[0]);
        $vacinationplaces = VacinationPlace::withCount('forms')->get();
        //dd($vacinationplaces[]);

        return view('vaccinated_index')
            ->with('forms', $forms)
            ->with('vacinationplaces', $vacinationplaces);
        //return $forms;
    }

   public function export(Request $request) {
       $time = $request->input('time');
       $export_type = $request->input('export_type');
       switch($time) {
           case 'one_day':
               $time = Carbon::now()->subDays(1);
               break;
           case 'one_week':
               $time = Carbon::now()->subDays(7);
               break;
           case 'one_month':
               $time = Carbon::now()->subMonth();
               break;
           case 'all':
               $time = null;
               break;
       }
       switch($export_type) {
           case 'csv_virgula':
               return (new FormExport($time, ','))->download('vacinometrocovid19_'. now() .'.csv');
               break;
           case 'csv_ponto_virgula':
               return (new FormExport($time, ';'))->download('vacinometrocovid19_'. now() .'.csv');
               break;
           case 'xlsx':
               return (new FormExport($time))->download('vacinometrocovid19_'. now() .'.xlsx');
               break;
               /*
           case 'pdf':

               $initial_date_formatted = Carbon::parse($initial_date);
               $final_date_formatted = Carbon::parse($final_date);
               //$immunizeds = Form::whereBetween('created_at', [$initial_date_formatted, $final_date_formatted])->get();
                $immunizeds = Form::all();
               $pdf = PDF::loadView('import', compact('immunizeds'));
               return $pdf->download('import.pdf');
               break;
               */
       }
   }
}
