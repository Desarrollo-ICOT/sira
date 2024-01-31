<?php

namespace App\Services;

use App\Exceptions\ApiException;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HospitalService
{

    private $get_url;
    private $post_url;
    private $healthCenterCodePath;
    private $healthCenterCode;
    private $code;
    private $backgroundImageUrl;

    public function __construct()
    {
        $this->get_url = env('GET_ENDPOINT');
        $this->post_url = env('POST_ENDPOINT');
        $this->healthCenterCodePath = env('HEALTH_CENTER_CODE_PATH');
        $this->code =file_get_contents($this->healthCenterCodePath) ;
        $this->healthCenterCode =trim($this->code) ;
        $this->backgroundImageUrl = asset("assets/img/{$this->healthCenterCode}.jpg");

    }

    public function getImageUrl(){
        return $this->backgroundImageUrl;
    }

    public function getTreatmentSessions(Request $request)
    {
        $cardCode = $request->input('uid');
        // $centerCode = env('CENTER_CODE');
        $sessions = $this->fetchTreatmentSessions($cardCode);
        if (empty($sessions)) {
            return response()->custom(false, env('NO_TREATMENT'), 404, 'danger');
        } else if (!empty($sessions['error'])) {
            $messageText = $sessions['content']['errors'][0]['message'];
            $message = substr($messageText, strpos($messageText, '-') + 2);
            $code = substr($messageText, 0, 3);
            $data = [
                'message' => $message,
                'code' => $code
            ]; 
            if(isset($sessions['content']['pacienteNombre']['patientFullName'])){
                $data ['patientName'] =  $sessions['content']['pacienteNombre']['patientFullName'];
            }
            throw new ApiException($data,  $sessions['httpCode']);
        }
        return $this->processTreatmentSessions($sessions, $cardCode);
    }
    

    private function fetchTreatmentSessions($cardCode)
    {
        $response = Http::get($this->get_url, [
            'centerCode' => $this->healthCenterCode,
            'bandNumber' => $cardCode
        ]);
        if (!$response->successful()) {
            session()->put('error', $response);
            throw new ApiException(env('SINA_ERROR'), 500);
        }
        session()->put('success', $response);
        return $response->json() ?? [];
    }

    private function processTreatmentSessions($sessions, $cardCode)
    {
        $now = Carbon::now();
        foreach ($sessions['content']['treatments'] as $sessionData) {
            $sessionData['bandNumber'] = $cardCode;
            $sessionData['clinicalHistoryNumber'] = $sessions['content']['clinicalHistoryNumber'];
            $sessionData['name'] = $sessions['content']['patientFullName'];
            $sessionDate = Carbon::createFromTimestampMs($sessionData['sessions'][0]['startDate']);
            $startDate= $sessionData['sessions'][0]['startDatePaco']['startDatePaco'];
            $sessionData['sessions'][0]['currentDate'] = $now->format('Y-m-d\TH:i:00');
            if ($sessionDate->isToday()) {
                if (!$sessionData['sessions'][0]['started']) {
                    $response = $this->markSessionAs($sessionData, env('STATE_INPROGRESS'));
                } else {
                    // $sessionDate->setTimezone("EET");
                    $currentDatetime = Carbon:: now();
                    // $timeToCheck = $sessionDate->format('Y-m-d\TH:i:00');
                    // $timeToCheck = $sessionData['sessions'][0]['currentDate'];;
                    $timeDifference = $currentDatetime->diffInMinutes($startDate);
                    if ($timeDifference < 15) {
                        $data = [
                            'message' => env('TIME_ERROR'),
                            'patientName' =>$sessions['content']['patientFullName']
                        ]; 
                        throw new ApiException($data, 404);
                        // return response()->custom(true, env('TIME_ERROR'), 404, 'danger', $sessionData);
                    } else {
                        $response = $this->markSessionAs($sessionData, env('STATE_DONE'));
                    }
                }
            } else {
                return response()->custom(true, env('NO_SESSIONS'), 404, 'warning', $sessionData);
            }
        }
        return $response;
    }

    private function markSessionAs($sessionData, $state)
    {
        $data = [
            "patient" => [
                "identifiers" => [
                    [
                        "type" => 1,
                        "id" => $sessionData['clinicalHistoryNumber'],
                    ],
                    [
                        "type" => 2,
                        "id" => $sessionData['bandNumber'],
                    ],
                ],
                "name" => $sessionData['name'],
            ],
            "order" => [
                "appointments" => [
                    [
                        "code" => $sessionData['sessions'][0]['appointmentCode'],
                        "typeCode" => "1",
                        "locaCode" => isset($sessionData['sessions'][0]['locationCode']) ? $sessionData['sessions'][0]['locationCode'] : env('LOCATION_CODE'),
                        "statusCode" => $state,
                        "startDate" => $sessionData['sessions'][0]['currentDate'],
                    ],
                ],
            ],
            "control" => [
                "idMessage" => "",
                "idTypeMessage" =>  env('IDTYPEMESSAGE'),
                "idTypeEvent" => env('IDTYPEEVENT'),
                "action" => env('ACTION'),
                "type" => env('TYPE'),
                "subType" => env('SUBTYPE'),
                "sourceCode" => env('SOURCE_CODE'),
                "source" => env('SOURCE_CODE'),
                "centerOriginCode" => "",
                "centerDestinationCode" => "",
                "destinationCode" => env('DESTINATION'),
                "destination" => env('DESTINATION'),
            ],
        ];
        return $this->sendSessionRequest($state == env('STATE_DONE') ? env('DONE') : env('STARTED'), $data);
    }

    private function sendSessionRequest($successMessage, $data)
    {
        $response = Http::post($this->post_url, $data);
        if (!$response->successful()) {
            throw new ApiException('Fallo al ' . strtolower($successMessage) . ': ' . $response, 500);
            exec('/assets/sounds/error.mp3');
        } else if (!empty($sessions['error'])) {
            $messageText = $sessions['content']['errors'][0]['message'];
            $message = substr($messageText, strpos($messageText, '-') + 2);
            $code = substr($messageText, 0, 3);
            $patientName = $sessions['content']['pacienteNombre']['patientFullName']; 
            $data = [
                'message' => $message,
                'code' => $code,
                'patientName' => $patientName
            ]; 
            throw new ApiException($data,  $sessions['httpCode']);
            // $message = $sessions['content']['errors'][0]['message'];
            // throw new ApiException(substr($message, strpos($message, '-') + 2), $sessions['httpCode']);
            exec('/assets/sounds/error.mp3');
        }
        $sessionData =[
            'message'=> $successMessage,
            'patientName' => $data['patient']['name']

        ];
        return response()->custom(true, $sessionData, 200, 'success');
    }
}
