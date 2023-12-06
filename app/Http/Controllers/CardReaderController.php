<?php

namespace App\Http\Controllers;

use App\Services\HospitalService;
use App\Exceptions\ErrorHandler;

use Illuminate\Http\Request;

class CardReaderController extends Controller
{
    private $hospitalSvc;
    private $backgroundImageUrl;

    public function __construct(HospitalService $hospitalSvc)
    {
        $this->hospitalSvc = $hospitalSvc;
        $this->backgroundImageUrl = $this->hospitalSvc->getImageUrl();
        
    }

    public function index()
    {
        $healthCenterCodePath = env('HEALTH_CENTER_CODE_PATH');
        $healthCenterCode =file_get_contents($healthCenterCodePath);

        $backgroundImageUrl = $this-> backgroundImageUrl;

        return view('welcome', compact(
            'healthCenterCodePath',
            'healthCenterCode',
            'backgroundImageUrl'

        ));
    }

    public function getHealthCenterCode(){
        return $this->hospitalSvc->getImageUrl();
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
