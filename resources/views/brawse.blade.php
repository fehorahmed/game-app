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
            height: 50px;
            width: 100%;
            background-color: #547874;
        }

        .iframe-style {
            border: 1px solid blue;
            height: 100vh;
        }
    </style>
    <script>
        // $.ajaxSetup({
        //     headers: {
        //         "Authorization": "Bearer " + "4|52f92d0277045b1e0f25e020413845009c310591338a41b2105631daedb3f844"
        //     }
        // });
    </script>
</head>

<body>
    <div class="topbar">
        <div style="display: flex; justify-content:space-between;">
            <h4 class="p-3">Time count</h4>
            <h4 class="p-3" id="time_count"></h4>
        </div>
    </div>
    <iframe class="iframe-style" width="100%" src="{{ request()->url }}" frameborder="0"></iframe>

    <script src="{{ asset('assets/jquery.min.js') }}"></script>
    <script>
        var time_count = '{{ request()->time }}'
        setInterval(() => {
            $('#time_count').html(time_count);
            time_count = time_count - 1;
            if (time_count == 0) {
                location.reload()
            }
            console.log(time_count);
        }, 1000);
    </script>
</body>

</html>
