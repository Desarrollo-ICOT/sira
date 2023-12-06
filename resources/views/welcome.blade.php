@extends('layouts.app')

@php
    // $healthCenterCodePath = env('HEALTH_CENTER_CODE_PATH');
    // $code = file_get_contents($healthCenterCodePath);
    // $healthCenterCode= trim($code);
    // $url = asset("assets/img/{$healthCenterCode}.jpg");
    $requestRoute = route('request');
    $imageUrl = ''; // Initialize the variable

@endphp

@section('content')
    <div class="wrapper fadeInDown">
        <style>
             body {
                            background-image: url("{{ $imageUrl }}");
                            background-size: 800px 600px;
                            background-repeat: no-repeat;
                            background-size: cover;
                        } 
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
                        ¡BIENVENIDO!</p>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    // Set global variable to hold the image URL
    window.imageUrl = "{{ $imageUrl }}";
</script>

<!-- Include preload-images.js -->
<script src="{{ asset('js/preload-images.js') }}"></script>

<script type="text/javascript">
    // const requestRoute = "{{ $requestRoute }}";
    // const token = "{{ csrf_token() }}";
    $(document).ready(function() {
        startClock();
        $('#messageAlert').hide();
        const form = document.getElementById('readCardForm');
        const cardCodeInput = document.getElementById('uid');
        const messageAlert = document.getElementById('messageAlert');
        const clock = document.getElementById('clock');
        // const formContent = document.getElementById('formContent');
        const formContent = document.querySelector('#formContent');

        form.addEventListener('submit', function(event) {
            event.preventDefault();
            $.ajax({
                url: "{{ $requestRoute }}",
                type: 'POST',
                data: {
                    // _token: tokenInput.value.trim(),
                    _token: "{{ csrf_token() }}",
                    uid: cardCodeInput.value.trim()
                },
                success: function(response) {
                    console.log(response);
                    console.log(cardCodeInput.value);
                    if (response.success) {
                        timeOutAlert($('#messageAlert'), response.message,
                            `alert-${response.led_color}`)
                        $('#patientCardLabel').text(response.data.patient.name);
                        playNotificationSound('/assets/sounds/success.mp3');

                    } else {
                        timeOutAlert($('#messageAlert'), response.message,
                            `alert-${response.led_color}`)
                        // messageAlert.classList.add(`alert-${response.led_color}`);
                        $('#sessionMessage').text(response.message);
                        playNotificationSound('/assets/sounds/error.mp3');
                    }
                },
                error: function(error) {
                    console.log(error);
                    timeOutAlert($('#messageAlert'), error.responseJSON.message,
                        `alert-${error.responseJSON.led_color}`);
                    playNotificationSound('/assets/sounds/error.mp3')

                },
                complete: function() {
                    // Code to be executed regardless of success or error
                    console.log('Ajax request completed');
                    setTimeout(clearPatientCardLabel, 10000);
                }
            });
        });
    });

    function timeOutAlert($alert, $message, $class) {
        $alert.text($message);
        $alert.addClass($class);
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
        setInterval(updateClock, 1000); // Update the clock every second
    }

    function playNotificationSound($sound) {
        const audio = new Audio($sound);
        audio.play();
    }

    function clearPatientCardLabel() {
        $('#patientCardLabel').text('');
        $('#uid').val('');
    }

    // Function to toggle the flip animation
    function toggleFlip() {
        if (cardElement.style.transform === "rotateY(180deg)") {
            formContent.style.transform = "rotateY(0deg)";
        } else {
            formContent.style.transform = "rotateY(180deg)";
        }
    }
</script>
{{-- <script src="{{ asset('js/welcome.js') }}"></script> --}}
