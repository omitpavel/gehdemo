<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @include('Layouts.Common.MasterLayoutMetaData')
    <link rel="stylesheet" href="{{ asset('asset_v2/Generic/bootstrap/css/bootstrap.min.css') }}" crossorigin="anonymous" />
    <link rel="stylesheet" href="{{ asset('asset_v2/Generic/bootstrap/icons/font/bootstrap-icons.css') }}" crossorigin="anonymous" />
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/Style.css') }}" crossorigin="anonymous" />
    <link rel="stylesheet" href="{{ asset('asset_v2/Ibox/Css/IboxCommonStyles.css') }}" crossorigin="anonymous" />
    <link rel="stylesheet" href="{{ asset('asset_v2/Generic/Css/toastr.min.css') }}" crossorigin="anonymous">
    <title>Login</title>
</head>

<body>
    <div class="loader-bg">
        <span class="screen-center"></span>
    </div>



    <div class="bg-login vh-100">
        <div class="container h-100">
            <div class="row align-items-center h-100">

                <div class="col-xl-4 col-lg-6 offset-lg-3 offset-xl-4 ps-lg-0 pe-lg-0">
                    <div class="d-md-none text-center mb-3 pt-5">
                        <img src="{{ asset('asset_v2/Template/images/iBox-Logo.svg') }}" alt="" class="img-fluid">
                    </div>

                    <div class="card-login">
                        <div class="card-body pt-0">
                            <div class="d-none d-md-block logo-section">
                                <img src="{{ asset('asset_v2/Template/images/iBox-Logo_Name.svg') }}" alt="" class="img-logo">
                            </div>
                            <div class="d-md-flex align-items-center justify-content-between">
                                <h6 class="fw-bold fs-6 pt-3">LOGIN</h6>
                                <span>(Windows Credentials)</span>
                            </div>

                            <span class="login-logo p-b-49 d-none login_message" style="color: red;"></span>


                            <div class="mt-4">
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">USERNAME</label>
                                    @if (count($errors) > 0 || Session::has('login_error'))
                                        {!! Form::text('username', old('username', ''), ['placeholder' => '', 'class' => 'form-control is-invalid', 'required' => 'required', 'autocomplete' => 'off', 'id' => 'username']) !!}
                                    @else
                                        {!! Form::text('usernames', old('username', ''), ['placeholder' => '', 'class' => 'form-control ', 'required' => 'required', 'autocomplete' => 'off', 'id' => 'username']) !!}
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">PASSWORD</label>
                                    @if (count($errors) > 0 || Session::has('login_error'))
                                        {!! Form::password('password', ['placeholder' => '', 'autocomplete' => 'new-password', 'class' => 'form-control is-invalid', 'required' => 'required', 'autocomplete' => 'new-password', 'id' => 'password']) !!}
                                    @else
                                        {!! Form::password('password', ['placeholder' => '', 'autocomplete' => 'new-password', 'class' => 'form-control ', 'required' => 'required', 'autocomplete' => 'new-password', 'id' => 'password']) !!}
                                    @endif
                                </div>
                                <div class="text-center d-none d-lg-block">
                                    <button class="btn btn-login w-100 windows_to_show_load_prim_button_main"  onclick="ValidateLoginCredForm();">LOGIN</button>
                                </div>
                                <div class="text-center d-none d-lg-block">
                                    {{-- <button class="btn btn-guest-login w-100 ">GUEST LOGIN</button> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center d-lg-none">
                        <button class="btn btn-login windows_to_show_load_prim_button_main" onclick="ValidateLoginCredForm();">LOGIN</button>
                    </div>
                    <div class="text-center d-lg-none">
                        {{-- <button class="btn btn-guest-login ">GUEST LOGIN</button> --}}
                    </div>
                </div>

            </div>
        </div>
    </div>















    <script src="{{ asset('asset_v2/Generic/Js/Popper.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('asset_v2/Generic/bootstrap/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('asset_v2/Generic/Js/Jquery.js') }}"></script>
    <script type="text/javascript" src="{{ asset('asset_v2/Generic/Js/crypto-js.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('asset_v2/Generic/Js/toastr.min.js') }}"></script>
    <script type='text/javascript'>
        jQuery(document).ready(function($) {
            $('.loader-bg').hide();
        });

        function refresh_handler() {
            function refresh() {
                location.reload();
            }
            setInterval(refresh, 900 * 1000);
        }
        $(document).ready(refresh_handler);
        $(document).on('click', '.windows_to_show_load_prim_button_main', function(e) {
            var username = $('#username').val();
            var password = $('#password').val();
            if ((username !== null && username !== '') && (password !== null && password !== '')) {
                $('.loader-bg').show();
                window.setTimeout(function() {
                    $("#windows_to_show_load_prim_main").submit();
                }, 2000);
            }
        });
        $(document).on('keypress', function(e) {
            if (e.which == 13) {
                $('.loader-bg').show();
                window.setTimeout(function() {
                    ValidateLoginCredForm() ;
                }, 2000);
            }
        });
        setInterval(function() {
            window.location.reload();
        }, 540000);




        function ValidateLoginCredForm() {

            $('.loader-bg').show();

            $.get('/csrf-token', function(data) {
                var token = data.token;

                PerformLogin(token);
            }).fail(function() {
                $('.loader-bg').hide();
                $('.login_message').css('color', 'red');
                $('.login_message').removeClass('d-none').html('Failed to retrieve CSRF token.');
            });
        }

        function PerformLogin(token) {
            var usernameElement = document.getElementById('username');
            var passwordElement = document.getElementById('password');

            var username = usernameElement.value;
            var password = passwordElement.value;

            var key = CryptoJS.enc.Hex.parse(CryptoJS.SHA256('iboxv4').toString(CryptoJS.enc.Hex));

            var ivUsername = CryptoJS.lib.WordArray.random(16);
            var ivPassword = CryptoJS.lib.WordArray.random(16);

            var encryptedUsername = CryptoJS.AES.encrypt(username, key, {
                iv: ivUsername,
                mode: CryptoJS.mode.CBC,
                padding: CryptoJS.pad.Pkcs7
            }).toString();

            var encryptedPassword = CryptoJS.AES.encrypt(password, key, {
                iv: ivPassword,
                mode: CryptoJS.mode.CBC,
                padding: CryptoJS.pad.Pkcs7
            }).toString();

            var ivUsernameHex = ivUsername.toString(CryptoJS.enc.Hex);
            var ivPasswordHex = ivPassword.toString(CryptoJS.enc.Hex);

            if (ivUsernameHex && encryptedUsername && ivPasswordHex && encryptedPassword) {
                var ec_username = ivUsernameHex + ':' + encryptedUsername;
                var ec_password = ivPasswordHex + ':' + encryptedPassword;

                if (!$('.login_message').hasClass('d-none')) {
                    $('.login_message').addClass('d-none');
                }

                $.ajax({
                    url: '{{ url('users/login') }}',
                    type: 'POST',
                    data: {
                        "_token": token,
                        "username": ec_username,
                        "password": ec_password
                    },
                    success: function(result) {
                        if (result.status == 1) {
                            window.location.replace(result.redirect_url);
                        } else {
                            $('.login_message').css('color', 'red');
                            $('.login_message').html(result.message);
                            if ($('.login_message').hasClass('d-none')) {
                                $('.login_message').removeClass('d-none');
                            }
                            $('.loader-bg').hide();
                        }
                    },
                    error: function(xhr, status, error) {
                        $('.loader-bg').hide();
                        $('.login_message').css('color', 'red');
                        if ($('.login_message').hasClass('d-none')) {
                            $('.login_message').removeClass('d-none');
                        }


                        try {
                            var response = JSON.parse(xhr.responseText);

                            $('.login_message').html(response.message);
                        } catch (e) {
                            $('.login_message').html('An error occurred: " + error');
                        }


                    }
                });
            } else {
                $('.loader-bg').hide();
                toastr.warning('Something Went Wrong.');
            }
        }






    </script>
</body>

</html>
