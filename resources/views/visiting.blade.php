<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .topbar {
            /* height: 60px; */
            /* width: 100%; */
            background-color: #547874;
        }

        .iframe-style {
            border: 1px solid blue;
            height: 100vh;
        }
    </style>
    <style>
        #next_button {
            display: none;
            /* Initially hide the button */
            /* margin-top: 20px; */
        }
    </style>
    <script></script>
</head>

<body>
    <div class="topbar">
        <div class="row">

            <div class="col-md-4 col-12 text-center">
                <h4 class="p-3">Time count</h4>
            </div>
            <div class="col-md-4 col-12 text-center">
                <h4 class="p-3" id="time_count"></h4>
            </div>
            <div class="col-md-4 col-12 text-center d-flex">
                <button id="next_button" class="btn btn-primary ">Click for Next</button>
            </div>
        </div>

    </div>
    <iframe class="iframe-style" width="100%" src="" frameborder="0"></iframe>

    <script src="{{ asset('assets/jquery.min.js') }}"></script>
    <script>
        var listData = @json($list);
        console.log(listData);

        var iframe = document.querySelector('.iframe-style');
        var currentIndex = 0;
        var intervalId;
        var baseUrl = "{{ route('user.website_visit_count', $website->id) }}"; // Set your base URL
        // Function to load the next URL into the iframe
        function loadNextUrl() {
            if (currentIndex >= listData.length) {
                window.location.href = baseUrl; // Redirect to base URL when all URLs are loaded
                return;
            }

            var currentItem = listData[currentIndex];
            iframe.src = currentItem.url; // Load the current URL into iframe
            console.log(`Loading URL: ${currentItem.url} for ${currentItem.time} seconds`);

            var timeCount = currentItem.time;
            document.getElementById('time_count').innerHTML = timeCount; // Display the initial time

            // Hide "Next" button while countdown is running
            document.getElementById('next_button').style.display = 'none';
            // Clear any previous interval
            if (intervalId) {
                clearInterval(intervalId);
            }

            // Start the countdown timer
            intervalId = setInterval(function() {
                timeCount -= 1;
                document.getElementById('time_count').innerHTML = timeCount; // Update the countdown display

                if (timeCount <= 0) {
                    clearInterval(intervalId); // Stop the interval when time is up
                    document.getElementById('next_button').style.display = 'block'; // Show "Next" button
                }
            }, 1000); // Update every second
        }


        // When the "Next" button is clicked
        document.getElementById('next_button').addEventListener('click', function() {
            currentIndex++; // Move to the next URL
            loadNextUrl(); // Load the next URL
        });

        loadNextUrl();
        // setInterval(() => {
        //     $('#time_count').html(time_count);
        //     time_count = time_count - 1;
        //     if (time_count == 0) {
        //         location.reload()
        //     }
        //     // console.log(time_count);
        // }, 1000);
    </script>
</body>

</html>
