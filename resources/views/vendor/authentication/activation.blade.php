<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
    </script>

    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Account Verification</title>

    <style>
        body {
            background: #eee;
        }

        .card {
            box-shadow: 0 20px 27px 0 rgb(0 0 0 / 5%);
        }

        .card {
            position: relative;
            display: flex;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 0 solid rgba(0, 0, 0, .125);
            border-radius: 1rem;
        }

        .img-thumbnail {
            padding: .25rem;
            background-color: #ecf2f5;
            border: 1px solid #dee2e6;
            border-radius: .25rem;
            max-width: 100%;
            height: auto;
        }

        .avatar-lg {
            height: 150px;
            width: 150px;
        }
    </style>
</head>

<body>
    <div class="container">
        <br>
        <div class="row">
            <div class="col-lg-5 col-md-7 mx-auto my-auto">
                <div class="card">
                    <div class="card-body px-lg-5 py-lg-5 text-center">
                        <img src="{{ asset('images/default/varification.jpg') }}"
                            class="rounded-circle avatar-lg img-thumbnail mb-4" alt="profile-image">
                        <h2 class="text-info">Account Varification</h2>
                        <p class="mb-4">Enter 6-digits code sent to your email address.</p>
                        @if (Session::has('error'))
                            <p class="mb-4 text-danger">{{ Session::get('error') }}</p>
                        @endif

                        <form action="{{ route('activate', ['id' => $vendor->id]) }}" method="post">
                            @csrf
                            <div class="row mb-4">
                                <div class="col-lg-2 col-md-2 col-2 ps-0 ps-md-2">
                                    <input type="text" class="form-control text-lg text-center" placeholder="_"
                                        aria-label="2fa" maxlength="1" id="digit1"
                                        onkeyup="moveToNext(this, 'digit2')" name="d1">
                                </div>
                                <div class="col-lg-2 col-md-2 col-2 ps-0 ps-md-2">
                                    <input type="text" class="form-control text-lg text-center" placeholder="_"
                                        aria-label="2fa" maxlength="1" id="digit2"
                                        onkeyup="moveToNext(this, 'digit3')" name="d2">
                                </div>
                                <div class="col-lg-2 col-md-2 col-2 ps-0 ps-md-2">
                                    <input type="text" class="form-control text-lg text-center" placeholder="_"
                                        aria-label="2fa" maxlength="1" id="digit3"
                                        onkeyup="moveToNext(this, 'digit4')" name="d3">
                                </div>
                                <div class="col-lg-2 col-md-2 col-2 pe-0 pe-md-2">
                                    <input type="text" class="form-control text-lg text-center" placeholder="_"
                                        aria-label="2fa" maxlength="1" id="digit4"
                                        onkeyup="moveToNext(this, 'digit5')" name="d4">
                                </div>
                                <div class="col-lg-2 col-md-2 col-2 pe-0 pe-md-2">
                                    <input type="text" class="form-control text-lg text-center" placeholder="_"
                                        aria-label="2fa" maxlength="1" id="digit5"
                                        onkeyup="moveToNext(this, 'digit6')" name="d5">
                                </div>
                                <div
                                    class="col-lg-2
                                        col-md-2 col-2 pe-0 pe-md-2">
                                    <input type="text" class="form-control text-lg text-center" placeholder="_"
                                        aria-label="2fa" maxlength="1" id="digit6" name="d6">
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn bg-primary my-4 text-light">Activate</button>
                            </div>
                        </form>
                        <div class="text-center">
                            <a id="myLink" href="#" class="my-4" disabled>Resend code
                                (30)</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        // var allowReload = false;

        // // Set a timeout to allow reload after 30 seconds
        // setTimeout(function() {
        //     allowReload = true;
        // }, 30000); // 30 seconds in milliseconds

        // // Event listener for beforeunload event
        // window.onbeforeunload = function(event) {
        //     if (!allowReload) {
        //         // Cancel the reload
        //         event.preventDefault();
        //         // Set a message (optional)
        //         event.returnValue = 'Are you sure you want to leave?';
        //     }
        // };


        document.addEventListener("DOMContentLoaded", function() {
            // Get a reference to the link
            var link = document.getElementById("myLink");
            var secondsLeft = 30; // Initial seconds left

            // Update the link text every second
            var countdownInterval = setInterval(function() {
                secondsLeft--;
                link.textContent = "Resend code (" + secondsLeft + ")";

                if (secondsLeft <= 0) {
                    clearInterval(countdownInterval);
                    link.removeAttribute("disabled");
                    link.textContent = "Resend code!";
                    link.setAttribute("href",
                        "{{ route('activation', ['id' => $vendor->id]) }}"
                    ); // Ensure href is set to "#" to prevent default action
                }
            }, 1000); // Update every 1 second
        });



        function moveToNext(currentInput, nextInputId) {
            var digit = currentInput.value;
            if (digit.length === 1) {
                document.getElementById(nextInputId).focus();
            }
        }
    </script>
</body>

</html>
