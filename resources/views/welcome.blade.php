@extends('layouts.app')

@php

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

        <div id="formContent" class="container">
            <div class="insideCard">

                <div class="img1">
                    <img src="{{ asset('assets/img/logo_icot_sombra.png') }}" id="logo" alt="icot logo" />
                </div>
                <div class="img2">
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
<script type="text/javascript">
    $(document).ready(function() {
        startClock();
        updateNetworkStatus();
        $('#patientLabel').hide();
        const form = document.getElementById('readCardForm');
        const cardCodeInput = document.getElementById('uid');
        const clock = document.getElementById('clock');
        const formContent = document.querySelector('#formContent');
        cardCodeInput.focus();

        window.addEventListener('online', () => {
            updateNetworkStatus();
        });

        window.addEventListener('offline', () => {
            updateNetworkStatus();
        });

        function updateNetworkStatus() {
            console.log(navigator);
            const status = navigator.onLine ? 'Online' : 'Offline';
            console.log(`Network status: ${status}`);
            if (!navigator.onLine) {
                handleOffline();
            }
        }

        form.addEventListener('submit', function(event) {
            event.preventDefault();
            $('#uid').prop('disabled', true);

            $.ajax({
                url: "{{ $requestRoute }}",
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                data: {
                    uid: cardCodeInput.value.trim()
                },
                success: function(response) {
                    handleResponse(response);
                    cardCodeInput.focus();
                },
                error: function(error) {
                    console.log(error);
                    if (error.status === 419) {
                        // CSRF token mismatch error
                        refreshCsrfTokenAndRetry(form);
                    } else {
                        handleErrorResponse(error.responseJSON);
                        cardCodeInput.focus();
                    }
                },
                complete: function() {
                    setTimeout(function() {
                        clearPatientCardLabel();
                        $('#uid').prop('disabled',
                            false); 
                        cardCodeInput.focus();
                    }, 4000);
                    cardCodeInput.focus();
                }
            });
        });

        cardCodeInput.addEventListener('focus', updateNetworkStatus);
        document.addEventListener('click', function(event) {
            console.log('click on screen');
            if (event.target !== cardCodeInput) {
                updateNetworkStatus();
                cardCodeInput.focus();
            }
        });

        cardCodeInput.addEventListener('click', function(event) {
            // Prevent default focus loss when clicking inside the input
            console.log('click on input')
            event.stopPropagation();

        });

    });

    function handleResponse(response) {
        Swal.fire({
            title: response.message,
            text: response.patientName,
            icon: 'success',
            type: 'success',
            timer: 3000,
            showConfirmButton: false,
            footer: ' ',
        });
        if (response.success == true) {
            $('#patientCardLabel').text(response.patientName);
            $('#patientLabel').show();
            playNotificationSound('/assets/sounds/notification.mp3');
        } else {
            handleErrorResponse(response);
        }
    }

    function handleErrorResponse(response) {
        Swal.fire({
            title: response.message,
            text: response.cardCode,
            icon: 'error',
            type: 'error',
            timer: 3000,
            showConfirmButton: false,
            footer: ' ',
        });
        playNotificationSound('/assets/sounds/error.mp3');
        if (response.code && response.code != '001') {
            $('#patientCardLabel').text(response.patientName);
            $('#patientLabel').show();
        }
    }

    // Function to handle offline status
    function handleOffline() {
        Swal.fire({
            title: 'Sin Conexión',
            text: 'El dispositivio no está conectado a una red',
            icon: 'warning',
            timer: 3000,
            showConfirmButton: false
        });
        playNotificationSound('/assets/sounds/error.mp3');
        window.addEventListener('online', function() {
            console.log('You are back online!');
            location.reload();

        });
    }

    function refreshCsrfTokenAndRetry(form) {
        refreshCsrfToken()
            .then(function() {
                $.ajax(form.submit());
            })
            .catch(function(error) {
                console.error('Failed to refresh CSRF token:');
                Swal.fire({
                    title: 'Error',
                    text: 'Failed to refresh CSRF token',
                    icon: 'error',
                    timer: 3000,
                    showConfirmButton: false,
                    footer: ' ',
                });
            });
    }

    function refreshCsrfToken() {
        return new Promise((resolve, reject) => {
            $.get('/refresh-csrf-token')
                .done(function(response) {
                    const newCsrfToken = response.csrf_token;
                    // Update CSRF token in the headers of future requests
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': newCsrfToken
                        }
                    });
                    resolve();
                })
                .fail(function(error) {
                    reject(error);
                });
        });
    }

    function simulateCsrfTokenMismatch() {
        $.get('/simulate-csrf-token-mismatch')
            .fail(function(error) {
                console.error('Failed to simulate CSRF token mismatch:');
            });
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
