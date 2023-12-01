$(document).ready(function() {
    startClock();
    $('#messageAlert').hide();
    const form = document.getElementById('readCardForm');
    const cardCodeInput = document.getElementById('uid');
    const messageAlert = document.getElementById('messageAlert');
    // const formContent = document.getElementById('formContent');
    const formContent = document.querySelector('#formContent');

    form.addEventListener('submit', function(event) {
        event.preventDefault();
        $.ajax({
            url: requestRoute,
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

                } else {
                    timeOutAlert($('#messageAlert'), response.message,
                        `alert-${response.led_color}`)
                    // messageAlert.classList.add(`alert-${response.led_color}`);
                    $('#sessionMessage').text(response.message);
                    playNotificationSound('/assets/sounds/error.mp3');
                }
            },
            error: function(error) {
                console.error(error);
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

// Function to toggle the flip animation
function toggleFlip() {
    if (cardElement.style.transform === "rotateY(180deg)") {
        formContent.style.transform = "rotateY(0deg)";
    } else {
        formContent.style.transform = "rotateY(180deg)";
    }
}
