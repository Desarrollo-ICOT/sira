<?php

namespace App\Services;

use App\Models\Session;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HospitalService
{
    private $url;

    public function __construct()
    {
        $this->url = env('API_ENDPOINT');
    }

    public function getTreatmentSessionsForToday(Request $request)
    {
        // Extract the cardCode from the request
        $cardCode = $request->input('uid');

        try {
            // Get treatment sessions from the API
            $sessions = $this->fetchTreatmentSessions($cardCode);

            if (empty($sessions)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No hay sesiones para el paciente indicado'
                ]);
            }

            // Process the treatment sessions
            $this->processTreatmentSessions($sessions);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], 400);
        }
    }

    private function fetchTreatmentSessions($cardCode)
    {
        // Make a GET request to the API to fetch treatment sessions
        $response = Http::get($this->url, [
            'tarjeta' => $cardCode,
        ]);

        if (!$response->successful()) {
            throw new \Exception('Error al descargar las sesiones desde SINA', 500);
        }

        // Assuming the response has a 'sessions' key containing the sessions array
        return $response->json() ?? [];
    }

    private function processTreatmentSessions($sessions)
    {
        $now = Carbon::now()->format('Y-m-d H:i:s');

        foreach ($sessions as $sessionData) {
            if ($sessionData['Iniciado'] == env('SESSION_NOT_STARTED')) {
                $this->markSessionAsStarted($sessionData, $now);
            } elseif ($sessionData['Iniciado'] == env('SESSION_STARTED')) {
                $this->markSessionAsDone($sessionData, $now);
            }
        }
    }

    private function markSessionAsStarted($sessionData, $now)
    {
        $data = [
            'id' => $sessionData['appr_id'],
            'current_datetime' => $now,
            'location' => $sessionData['CENT_CODE'],
            'state' => env('STATE_INPROGRESS')
        ];

        $this->sendSessionRequest($data, 'Iniciar Sesión');
    }

    private function markSessionAsDone($sessionData)
    {
        $data = [
            'id' => $sessionData['appr_id'],
            'state' => env('STATE_DONE')
        ];

        $this->sendSessionRequest($data, 'Finalizar Sesión');
    }

    private function sendSessionRequest($data, $successMessage)
    {
        // Make a request to the API to update the session
        $response = Http::post($this->url, $data);
        if (!$response->successful()) {
            throw new \Exception('Fallo al ' . strtolower($successMessage), 500);
        }
    }
}
