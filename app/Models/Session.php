<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;

    protected $fillable = 
    [
        'appr_id', //session id
        //'patient_card_number',
        'pati_clinical_history_id', //NHC
        'pati_full_name', //patient name
        'CENT_CODE', //centre code
        'SERV_CODE', //service code
        'appo_code', //codigo interno SINA
        'fecha',
        'hora_ini',
        'hora_fin',
        'loca_description_es',
        'prof', //assigned professional
        'Iniciado' ,
        'state',
        'current_datetime'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
