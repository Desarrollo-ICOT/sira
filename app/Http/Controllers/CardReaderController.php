<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Session;
use App\Services\HospitalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CardReaderController extends Controller
{
    private $hospitalSvc;
    
    public function __construct(HospitalService $hospitalSvc)
    {
        $this->hospitalSvc = $hospitalSvc;
    }

    public function requestSessions(Request $request)
    {
       return $this->hospitalSvc->getTreatmentSessionsForToday($request);
    }

    public function startSession(Request $request)
    {
    //    return $this->hospitalSvc->markSessionAsStarted($request);
    }




    // public function readCardForEntrance(Request $request)
    // {
    //     $patientCardNumber = $request->input('uid');       
    //     $patient = Patient::where('card_number', $patientCardNumber)->first();

    //     if (!$patient) {
    //         return response()->json(['result' => 'Access denied', 'led_color' => 'red', 'message' => 'Invalid card number']);
    //     }

    //     $treatmentSessions = $hospitalService->getTreatmentSessionsForToday($patient->id);

    //     if ($treatmentSessions->isEmpty()) {
    //         return response()->json(['result' => 'Access denied', 'led_color' => 'orange', 'message' => 'No treatment sessions scheduled for today']);
    //     }

    //     return response()->json(['result' => 'Access granted', 'led_color' => 'green', 'sessions' => $treatmentSessions]);
    // }

}
