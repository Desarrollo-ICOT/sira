<?php

namespace App\Http\Controllers;

use App\Services\HospitalService;
use App\Exceptions\ErrorHandler;

use Illuminate\Http\Request;

class CardReaderController extends Controller
{
    private $hospitalSvc;

    public function __construct(HospitalService $hospitalSvc)
    {
        $this->hospitalSvc = $hospitalSvc;
    }

    public function index()
    {
        $healthCenterCodePath = env('HEALTH_CENTER_CODE_PATH');
        $healthCenterCode =file_get_contents($healthCenterCodePath);

        return view('welcome', compact(
            'healthCenterCodePath',
            'healthCenterCode'
        ));
    }
    
    public function requestSessions(Request $request)
    {
        try {
            return $this->hospitalSvc->getTreatmentSessions($request);
        } catch (\Exception $e) {
            return ErrorHandler::handle($e);
        }
    }
}
