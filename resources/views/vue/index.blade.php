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

    <style>
        .container {
            position: absolute;
            width: 200px;
            height: 200px;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            margin: auto;
        }

        .item {
            width: 100px;
            height: 100px;
            position: absolute;
        }

        .item-1 {
            background-color: #FA5667;
            top: 0;
            left: 0;
            z-index: 1;
            animation: item-1_move 1.8s cubic-bezier(.6,.01,.4,1) infinite;
        }

        .item-2 {
            background-color: #7A45E5;
            top: 0;
            right: 0;
            animation: item-2_move 1.8s cubic-bezier(.6,.01,.4,1) infinite;
        }

        .item-3 {
            background-color: #1B91F7;
            bottom: 0;
            right: 0;
            z-index: 1;
            animation: item-3_move 1.8s cubic-bezier(.6,.01,.4,1) infinite;
        }

        .item-4 {
            background-color: #FAC24C;
            bottom: 0;
            left: 0;
            animation: item-4_move 1.8s cubic-bezier(.6,.01,.4,1) infinite;
        }

        @keyframes item-1_move {
            0%, 100% {transform: translate(0, 0)}
            25% {transform: translate(0, 100px)}
            50% {transform: translate(100px, 100px)}
            75% {transform: translate(100px, 0)}
        }

        @keyframes item-2_move {
            0%, 100% {transform: translate(0, 0)}
            25% {transform: translate(-100px, 0)}
            50% {transform: translate(-100px, 100px)}
            75% {transform: translate(0, 100px)}
        }

        @keyframes item-3_move {
            0%, 100% {transform: translate(0, 0)}
            25% {transform: translate(0, -100px)}
            50% {transform: translate(-100px, -100px)}
            75% {transform: translate(-100px, 0)}
        }

        @keyframes item-4_move {
            0%, 100% {transform: translate(0, 0)}
            25% {transform: translate(100px, 0)}
            50% {transform: translate(100px, -100px)}
            75% {transform: translate(0, -100px)}
        }
    </style>


</head>
<body>
<div id="app">

    <div class="container">
        <div class="item item-1"></div>
        <div class="item item-2"></div>
        <div class="item item-3"></div>
        <div class="item item-4"></div>
    </div>
</div>

</body>



<script src="/js/app.js"></script>
</html>
