<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Ticktock</title>


    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script defer src="https://use.fontawesome.com/releases/v5.0.9/js/all.js"
            integrity="sha384-8iPTk2s/jMVj81dnzb/iFR2sdA7u06vHJyyLlAd4snFpCl/SnyUjRrbdJsw1pGIl"
            crossorigin="anonymous"></script>

</head>
<body>
<div id="app">


    <div class="loader-wrap">
        <div class="loader"><span class="loader-item"></span><span class="loader-item"></span><span
                    class="loader-item"></span><span class="loader-item"></span><span class="loader-item"></span><span
                    class="loader-item"></span><span class="loader-item"></span><span class="loader-item"></span><span
                    class="loader-item"></span><span class="loader-item"></span></div>
    </div>

</div>
<script src="/js/app.js"></script>
</body>


<style>
    .loader-wrap {
        position: absolute;
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
        margin: auto;
        background-color: #ff9328;
    }

    .loader {
        position: absolute;
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
        margin: auto;
        height: 40px;
        width: 80px;
        box-sizing: border-box;
    }

    .loader .loader-item {
        position: relative;
        float: left;
        height: 40px;
        width: 4px;
        margin: 0 2px;
        background-color: #ffffff;
    }

    .loader .loader-item:nth-child(1) {
        -webkit-animation: loader-item-1 2s linear infinite;
        animation: loader-item-1 2s linear infinite;
    }

    .loader .loader-item:nth-child(2) {
        -webkit-animation: loader-item-2 2s linear infinite;
        animation: loader-item-2 2s linear infinite;
    }

    .loader .loader-item:nth-child(3) {
        -webkit-animation: loader-item-3 2s linear infinite;
        animation: loader-item-3 2s linear infinite;
    }

    .loader .loader-item:nth-child(4) {
        -webkit-animation: loader-item-4 2s linear infinite;
        animation: loader-item-4 2s linear infinite;
    }

    .loader .loader-item:nth-child(5) {
        -webkit-animation: loader-item-5 2s linear infinite;
        animation: loader-item-5 2s linear infinite;
    }

    .loader .loader-item:nth-child(6) {
        -webkit-animation: loader-item-6 2s linear infinite;
        animation: loader-item-6 2s linear infinite;
    }

    .loader .loader-item:nth-child(7) {
        -webkit-animation: loader-item-7 2s linear infinite;
        animation: loader-item-7 2s linear infinite;
    }

    .loader .loader-item:nth-child(8) {
        -webkit-animation: loader-item-8 2s linear infinite;
        animation: loader-item-8 2s linear infinite;
    }

    .loader .loader-item:nth-child(9) {
        -webkit-animation: loader-item-9 2s linear infinite;
        animation: loader-item-9 2s linear infinite;
    }

    .loader .loader-item:nth-child(10) {
        -webkit-animation: loader-item-10 2s linear infinite;
        animation: loader-item-10 2s linear infinite;
    }

    .loader:after {
        content: 'Loading...';
        font-size: 16px;
        font-family: "Arial";
        color: #ffffff;
        text-align: center;
        position: absolute;
        left: 0;
        right: 0;
        bottom: -32px;
        margin: auto;
    }

    @-webkit-keyframes loader-item-1 {
        1% {
            -webkit-transform: scaleY(1);
            transform: scaleY(1);
        }
        11% {
            -webkit-transform: scaleY(1.4);
            transform: scaleY(1.4);
        }
        21% {
            -webkit-transform: scaleY(1);
            transform: scaleY(1);
        }
        100% {
            -webkit-transform: scaleY(1);
            transform: scaleY(1);
        }
    }

    @keyframes loader-item-1 {
        1% {
            -webkit-transform: scaleY(1);
            transform: scaleY(1);
        }
        11% {
            -webkit-transform: scaleY(1.4);
            transform: scaleY(1.4);
        }
        21% {
            -webkit-transform: scaleY(1);
            transform: scaleY(1);
        }
        100% {
            -webkit-transform: scaleY(1);
            transform: scaleY(1);
        }
    }

    @-webkit-keyframes loader-item-2 {
        7% {
            -webkit-transform: scaleY(1);
            transform: scaleY(1);
        }
        17% {
            -webkit-transform: scaleY(1.4);
            transform: scaleY(1.4);
        }
        27% {
            -webkit-transform: scaleY(1);
            transform: scaleY(1);
        }
        100% {
            -webkit-transform: scaleY(1);
            transform: scaleY(1);
        }
    }

    @keyframes loader-item-2 {
        7% {
            -webkit-transform: scaleY(1);
            transform: scaleY(1);
        }
        17% {
            -webkit-transform: scaleY(1.4);
            transform: scaleY(1.4);
        }
        27% {
            -webkit-transform: scaleY(1);
            transform: scaleY(1);
        }
        100% {
            -webkit-transform: scaleY(1);
            transform: scaleY(1);
        }
    }

    @-webkit-keyframes loader-item-3 {
        13% {
            -webkit-transform: scaleY(1);
            transform: scaleY(1);
        }
        23% {
            -webkit-transform: scaleY(1.4);
            transform: scaleY(1.4);
        }
        33% {
            -webkit-transform: scaleY(1);
            transform: scaleY(1);
        }
        100% {
            -webkit-transform: scaleY(1);
            transform: scaleY(1);
        }
    }

    @keyframes loader-item-3 {
        13% {
            -webkit-transform: scaleY(1);
            transform: scaleY(1);
        }
        23% {
            -webkit-transform: scaleY(1.4);
            transform: scaleY(1.4);
        }
        33% {
            -webkit-transform: scaleY(1);
            transform: scaleY(1);
        }
        100% {
            -webkit-transform: scaleY(1);
            transform: scaleY(1);
        }
    }

    @-webkit-keyframes loader-item-4 {
        19% {
            -webkit-transform: scaleY(1);
            transform: scaleY(1);
        }
        29% {
            -webkit-transform: scaleY(1.4);
            transform: scaleY(1.4);
        }
        39% {
            -webkit-transform: scaleY(1);
            transform: scaleY(1);
        }
        100% {
            -webkit-transform: scaleY(1);
            transform: scaleY(1);
        }
    }

    @keyframes loader-item-4 {
        19% {
            -webkit-transform: scaleY(1);
            transform: scaleY(1);
        }
        29% {
            -webkit-transform: scaleY(1.4);
            transform: scaleY(1.4);
        }
        39% {
            -webkit-transform: scaleY(1);
            transform: scaleY(1);
        }
        100% {
            -webkit-transform: scaleY(1);
            transform: scaleY(1);
        }
    }

    @-webkit-keyframes loader-item-5 {
        25% {
            -webkit-transform: scaleY(1);
            transform: scaleY(1);
        }
        35% {
            -webkit-transform: scaleY(1.4);
            transform: scaleY(1.4);
        }
        45% {
            -webkit-transform: scaleY(1);
            transform: scaleY(1);
        }
        100% {
            -webkit-transform: scaleY(1);
            transform: scaleY(1);
        }
    }

    @keyframes loader-item-5 {
        25% {
            -webkit-transform: scaleY(1);
            transform: scaleY(1);
        }
        35% {
            -webkit-transform: scaleY(1.4);
            transform: scaleY(1.4);
        }
        45% {
            -webkit-transform: scaleY(1);
            transform: scaleY(1);
        }
        100% {
            -webkit-transform: scaleY(1);
            transform: scaleY(1);
        }
    }

    @-webkit-keyframes loader-item-6 {
        31% {
            -webkit-transform: scaleY(1);
            transform: scaleY(1);
        }
        41% {
            -webkit-transform: scaleY(1.4);
            transform: scaleY(1.4);
        }
        51% {
            -webkit-transform: scaleY(1);
            transform: scaleY(1);
        }
        100% {
            -webkit-transform: scaleY(1);
            transform: scaleY(1);
        }
    }

    @keyframes loader-item-6 {
        31% {
            -webkit-transform: scaleY(1);
            transform: scaleY(1);
        }
        41% {
            -webkit-transform: scaleY(1.4);
            transform: scaleY(1.4);
        }
        51% {
            -webkit-transform: scaleY(1);
            transform: scaleY(1);
        }
        100% {
            -webkit-transform: scaleY(1);
            transform: scaleY(1);
        }
    }

    @-webkit-keyframes loader-item-7 {
        37% {
            -webkit-transform: scaleY(1);
            transform: scaleY(1);
        }
        47% {
            -webkit-transform: scaleY(1.4);
            transform: scaleY(1.4);
        }
        57% {
            -webkit-transform: scaleY(1);
            transform: scaleY(1);
        }
        100% {
            -webkit-transform: scaleY(1);
            transform: scaleY(1);
        }
    }

    @keyframes loader-item-7 {
        37% {
            -webkit-transform: scaleY(1);
            transform: scaleY(1);
        }
        47% {
            -webkit-transform: scaleY(1.4);
            transform: scaleY(1.4);
        }
        57% {
            -webkit-transform: scaleY(1);
            transform: scaleY(1);
        }
        100% {
            -webkit-transform: scaleY(1);
            transform: scaleY(1);
        }
    }

    @-webkit-keyframes loader-item-8 {
        43% {
            -webkit-transform: scaleY(1);
            transform: scaleY(1);
        }
        53% {
            -webkit-transform: scaleY(1.4);
            transform: scaleY(1.4);
        }
        63% {
            -webkit-transform: scaleY(1);
            transform: scaleY(1);
        }
        100% {
            -webkit-transform: scaleY(1);
            transform: scaleY(1);
        }
    }

    @keyframes loader-item-8 {
        43% {
            -webkit-transform: scaleY(1);
            transform: scaleY(1);
        }
        53% {
            -webkit-transform: scaleY(1.4);
            transform: scaleY(1.4);
        }
        63% {
            -webkit-transform: scaleY(1);
            transform: scaleY(1);
        }
        100% {
            -webkit-transform: scaleY(1);
            transform: scaleY(1);
        }
    }

    @-webkit-keyframes loader-item-9 {
        49% {
            -webkit-transform: scaleY(1);
            transform: scaleY(1);
        }
        59% {
            -webkit-transform: scaleY(1.4);
            transform: scaleY(1.4);
        }
        69% {
            -webkit-transform: scaleY(1);
            transform: scaleY(1);
        }
        100% {
            -webkit-transform: scaleY(1);
            transform: scaleY(1);
        }
    }

    @keyframes loader-item-9 {
        49% {
            -webkit-transform: scaleY(1);
            transform: scaleY(1);
        }
        59% {
            -webkit-transform: scaleY(1.4);
            transform: scaleY(1.4);
        }
        69% {
            -webkit-transform: scaleY(1);
            transform: scaleY(1);
        }
        100% {
            -webkit-transform: scaleY(1);
            transform: scaleY(1);
        }
    }

    @-webkit-keyframes loader-item-10 {
        55% {
            -webkit-transform: scaleY(1);
            transform: scaleY(1);
        }
        65% {
            -webkit-transform: scaleY(1.4);
            transform: scaleY(1.4);
        }
        75% {
            -webkit-transform: scaleY(1);
            transform: scaleY(1);
        }
        100% {
            -webkit-transform: scaleY(1);
            transform: scaleY(1);
        }
    }

    @keyframes loader-item-10 {
        55% {
            -webkit-transform: scaleY(1);
            transform: scaleY(1);
        }
        65% {
            -webkit-transform: scaleY(1.4);
            transform: scaleY(1.4);
        }
        75% {
            -webkit-transform: scaleY(1);
            transform: scaleY(1);
        }
        100% {
            -webkit-transform: scaleY(1);
            transform: scaleY(1);
        }
    }


</style>
</html>
