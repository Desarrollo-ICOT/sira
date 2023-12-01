<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        li {
            width: 300px;
            height: 260px;
            position: relative;
            perspective: 800px;
            list-style-type: none;
        }

        .container {
            -webkit-perspective: 1000;
            -moz-perspective: 1000;
            perspective: 1000;
        }

        #flip-toggle.flip .card {
            -webkit-transform: rotateY(180deg);
            -moz-transform: rotateY(180deg);
            transform: rotateY(180deg);
            filter: FlipH;
            -ms-filter: "FlipH";
        }

        .container,
        .front,
        .back {
            width: 300px;
            height: 260px;
        }

        .card {
            -webkit-transition: 0.6s;
            -webkit-transform-style: preserve-3d;
            -moz-transition: 0.6s;
            -moz-transform-style: preserve-3d;
            transition: 0.6s;
            transform-style: preserve-3d;
            position: relative;
            width: 100%;
            height: 100%;
        }

        .front,
        .back {
            -webkit-backface-visibility: hidden;
            -moz-backface-visibility: hidden;
            backface-visibility: hidden;
            position: absolute;
            top: 0;
            left: 0;
        }

        .card:hover .card-inner {
            transform: rotateY(180deg);
        }

        .front {
            z-index: 2;
            background-color: transparent;
            box-shadow: 0 0 20px rgba(0, 0, 0, 1.3);
            position: absolute;
            opacity: 1;
        }

        .back {
            background: blue;
            -webkit-transform: rotateY(180deg);
            -moz-transform: rotateY(180deg);
            transform: rotateY(180deg);
        }
    </style>
</head>

<body>

    <ul>
        <li>
            <div class="container" id="flip-toggle">
                <div class="card">
                    <div class="front" style="background-color: transparent;box-shadow: 0 0 20px rgba(0, 0, 0, 1.3);">
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
                        back
                    </div>
                </div>
            </div>
        </li>
    </ul>

</body>

</html>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    // $(document.body).on('click', '.card', function() {
    //     console.log("CLICK");
    //     document.querySelector('#flip-toggle').classList.toggle('flip');
    // });

    $(document).ready(function() {
        startClock();
        $('#messageAlert').hide();
        const form = document.getElementById('readCardForm');
        const cardCodeInput = document.getElementById('uid');
        const messageAlert = document.getElementById('messageAlert');
        const card = document.querySelector('card');

        form.addEventListener('submit', function(event) {
            event.preventDefault();
            $.ajax({
                url: '{{ route('request') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    uid: cardCodeInput.value.trim()
                },
                success: function(response) {
                    console.log(response);
                    if (response.success) {
                        timeOutAlert($('#messageAlert'), response.message,
                            `alert-${response.led_color}`)
                        $('#patientCardLabel').text(response.data.patient.name);
                        playNotificationSound('/assets/sounds/success.mp3');
                        toggleFlip(card);

                    } else {
                        timeOutAlert($('#messageAlert'), response.message,
                            `alert-${response.led_color}`)
                        // messageAlert.classList.add(`alert-${response.led_color}`);
                        $('#sessionMessage').text(response.message);
                        playNotificationSound('/assets/sounds/error.mp3');
                        toggleFlip(card);
                    }
                },
                error: function(error) {
                    console.error(error);
                    timeOutAlert($('#messageAlert'), error.responseJSON.message,
                        `alert-${error.responseJSON.led_color}`);
                    playNotificationSound('/assets/sounds/error.mp3');
                    toggleFlip(card);
                },
                complete: function() {
                    // Code to be executed regardless of success or error
                    console.log('Ajax request completed');
                    setTimeout(clearPatientCardLabel, 10000);
                    toggleFlip(card);
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
        document.getElementById('clock').innerHTML = timeString;
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

    function toggleFlip(element) {
        element.classList.toggle('flip');
    }
</script>
