@extends('layouts.app')

@php
    // $healthCenterCodePath = env('HEALTH_CENTER_CODE_PATH');
    // $code = file_get_contents($healthCenterCodePath);
    // $healthCenterCode= trim($code);
    $url = asset('assets/img/fondo_gris.jpg');
    $requestRoute = route('request');
    $imageUrl = '';

@endphp

@section('content')
    <div class="wrapper fadeInDown">
        <style>
            body {
                background-image: url("{{ $url }}");
                background-repeat: no-repeat;
                background-size: cover;
            }
        </style>
        <div id="alertError" class="alert alert-danger" role="alert" style="display: none">
        </div>
        <div id="alertSuccess" class="alert alert-success" role="alert" style="display: none">
        </div>

        <div id="formContent" class="container">
            <div class="insideCard">

                <div id="img1" class="img1">
                    <img src="{{ asset('assets/img/logo_icot_sombra.png') }}" id="logo" alt="icot logo" />
                </div>
                <div id="img2" class="img2">
                    <img src="{{ asset('assets/img/34aniversario_rojo.png') }}" id="aniversario" alt="icot aniversario" />
                </div>
                <div class="datetime">
                    <p>{{ ucfirst(\Carbon\Carbon::now()->isoFormat('dddd, D [de] MMMM')) }}</p>
                    <div id="clock"></div>
                </div>
                <div id="patientLabel">
                    <label id="patientCardLabel" class="data-label"></label>
                </div>
                <form id="readCardForm" method="GET">
                    @csrf
                    @method('GET')
                    <input id="uid" type="text" class="fadeIn second" name="uid" required autofocus
                        placeholder="Código Tarjeta">
                    <br>
                </form>
            </div>
        </div>

    </div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

{{-- <script>
    window.imageUrl = "{{ $imageUrl }}";
</script>

<script src="{{ asset('js/preload-images.js') }}"></script> --}}

<script type="text/javascript">
    $(document).ready(function() {
        startClock();
        $('#patientLabel').hide();
        $('#messageAlert').hide();
        const form = document.getElementById('readCardForm');
        const cardCodeInput = document.getElementById('uid');
        const messageAlert = document.getElementById('messageAlert');
        const clock = document.getElementById('clock');
        const formContent = document.querySelector('#formContent');
        cardCodeInput.focus();

        var healthCenterCode = localStorage.getItem('healthCenterCode');
        console.log(healthCenterCode);

        form.addEventListener('submit', function(event) {
            event.preventDefault();
            $.ajax({
                url: "{{ $requestRoute }}",
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    uid: cardCodeInput.value.trim(),
                    healthCenterCode: healthCenterCode
                },
                success: function(response) {
                    Swal.fire({
                        title: capitalizeFirstLetter(response.message),
                        text: response.patientName,
                        icon: 'success',
                        type: 'success',
                        timer: 6000,
                        showConfirmButton: false,
                        footer: ' ',

                    });
                    console.log(response);
                    if (response.success == true) {
                        $('#patientCardLabel').text(response.patientName);
                        $('#patientLabel').show();
                        playNotificationSound('/assets/sounds/success.mp3');
                        cardCodeInput.focus();

                    } else {
                        Swal.fire({
                            title: capitalizeFirstLetter(response.message),
                            text: response.patientName,
                            icon: 'error',
                            type: 'error',
                            timer: 6000,
                            showConfirmButton: false,
                            footer: ' ',

                        });
                        console.log(error);
                        playNotificationSound('/assets/sounds/error.mp3');
                        cardCodeInput.focus();
                    }
                },
                error: function(error) {
                    Swal.fire({
                        title: capitalizeFirstLetter(error.responseJSON.message) ,
                        text: error.responseJSON.patientName,
                        icon: 'error',
                        type: 'error',
                        timer: 6000,
                        showConfirmButton: false,
                        footer: ' ',
                    });
                    console.log(error);
                    if (error.responseJSON.code != '001') {
                        $('#patientCardLabel').text(error.responseJSON.patientName);
                        $('#patientLabel').show();
                    }
                    playNotificationSound('/assets/sounds/error.mp3');
                    cardCodeInput.focus();
                },
                complete: function() {
                    setTimeout(clearPatientCardLabel, 10000);
                    cardCodeInput.focus();
                }
            });
        });
    });

    function
    timeOutAlert($alert, $message) {
        $alert.text($message);
        $alert.show().delay(10000).slideUp(300);
    }

    function updateClock() {
        const now = new Date();
        const hours = now.getHours().toString().padStart(2, '0');
        const minutes = now.getMinutes().toString().padStart(2, '0');
        const seconds = now.getSeconds().toString().padStart(2, '0');
        const timeString = `${hours}:${minutes}:${seconds}`;
        clock.innerHTML = timeString;
    }

    function startClock() {
        updateClock();
        setInterval(updateClock, 1000);
    }

    function playNotificationSound($sound) {
        const audio = new Audio($sound);
        audio.play();
    }

    function clearPatientCardLabel() {
        $('#patientCardLabel').text('');
        $('#uid').val('');
    }

    function capitalizeFirstLetter(str) {
        return str.replace(/\b\w/g, match => match.toUpperCase());
    }
</script>
{{-- <script src="{{ asset('js/welcome.js') }}"></script> --}}
