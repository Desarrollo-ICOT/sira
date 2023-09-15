@extends('layouts.app')

@section('content')
    <link href="{{ asset('css/welcome.css') }}" rel="stylesheet">

    <div id="messageAlert" class="alert alert-success" role="alert" style="display: none">
    </div>
    <div id="errorMessageAlert" class="alert alert-danger" role="alert" style="display: none">
    </div>

    <div class="wrapper fadeInDown">
        <style>
            body {
                background-image: linear-gradient(to right, #413E3E, #7B7575);
                background-repeat: no-repeat;
                background-size: cover;
            }
        </style>
        <div class="formContent" style="background-color: transparent;box-shadow: 0 0 20px rgba(0, 0, 0, 1.3);">
            <div class="fadeIn first">
                <br>
                <img src="{{ asset('assets/img/logo_nb.png') }}" width="40px" id="icon" alt="User Icon" /> <br><br>
                <span class="font-weight-bold" style="font-size: 36px;font-family:"> ARES</span>
            </div>

            <form class="mt-2" id="readCardForm" method="POST" action="{{ route('request') }}">
                @csrf
                @method('POST')
                <label for="card_code">Tarjeta de Paciente: </label>
                <input id="uid" type="text" class="fadeIn second" name="uid" required autofocus
                    placeholder="Código Tarjeta">
                <br>
                {{-- <label for="center_code">Código de Centro:</label>
                <input type="text" id="center_code" class="fadeIn second" name="center_code" value="1" required> --}}
            </form>
        </div>
    </div>
@endsection

<script type="text/javascript">
    const form = document.getElementById('readCardForm');
    const cardCodeInput = document.getElementById('uid');

    cardCodeInput.addEventListener('input', () => {
        if (cardCodeInput.value.trim() !== '') {
            form.submit();
        }
    });
    // function timeOutAlert($alert, $message) {
    //     $alert.text($message);
    //     $alert.show().delay(3000).slideUp(300);
    // }
</script>
