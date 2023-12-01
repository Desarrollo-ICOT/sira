@extends('layouts.app')

@php
    $healthCenterCodePath = env('HEALTH_CENTER_CODE_PATH');
    $healthCenterCode = file_get_contents($healthCenterCodePath);
    $url = asset("assets/img/{$healthCenterCode}.jpg");
    $requestRoute = route('request');
@endphp


    @section('content')
        <link href="{{ asset('css/welcome.css') }}" rel="stylesheet">
        <div class="wrapper fadeInDown">
            <style>
                /* body {
                    background-image: url("{{ $url }}");
                    background-size: auto;
                    background-repeat: no-repeat;
                    background-size: cover;
                } */
            </style>
            <div id="messageAlert" class="alert" role="alert"
                style="display: none;padding: 30px;font-size: 20px;    text-transform: uppercase;
        ">
            </div>
            <div id="formContent" class="container">
                <div class="card" style="background-color: transparent;box-shadow: 0 0 20px rgba(0, 0, 0, 1.3);">
                    <div id="front" class="fadeIn first">
                        <br>
                        <img src="{{ asset('assets/img/logo_icot_sombra.png') }}" id="logo" alt="icot logo" />
                        <p class="font-weight-bold" style="font-size: 38px;margin-top:200px;">
                            ¡¡BIENVENIDO!!</p>
                        <p class="font-weight-bold" style="font-size: 30px;">
                            {{ ucfirst(\Carbon\Carbon::now()->isoFormat('dddd, D [de] MMMM')) }}</p>
                        <div id="clock" style="margin-bottom: 25px;"></div>
                        <form class="mt-2" id="readCardForm" method="GET">
                            @csrf
                            @method('GET')
                            {{-- <label for="card_code" style="font-weight: bold;">Paciente: </label> --}}
                            <label id="patientCardLabel" class="data-label"></label>
                            <input id="uid" type="text" class="fadeIn second" name="uid" required autofocus
                                placeholder="Código Tarjeta">
                            <br>
                        </form>
                    </div>
                    <div class="back">
                        BACK FACE CONTENT
                    </div>
                </div>
            </div>

        </div>
    @endsection

    <script>
        const requestRoute = "{{ $requestRoute }}";
    </script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('js/welcome.js') }}"></script>

