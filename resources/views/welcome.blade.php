<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>
                        <a href="{{ route('register') }}">Register</a>
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title">
                    Ryan Deng
                </div>

                <div class="links">
                    <h2></h2>


                    <ul>
                        <li>Vue.js Basic CRUD</li>
                        <li>HTML/JS/JQuery/Ajax CRUD</li>
                        <li>Swagger API Documentation</li>
                        <li>Websocket</li>
                        <li>Cron Jobs</li>
                        <li>Redis Server</li>
                        <li>Microservices - Spring Boot (Java)</li>
                        <li>Microservices - Django (Python)</li>
                        <li>REST APIs</li>
                        <li>Ajax/JQuery/JavaScript</li>
                        <li>MVC</li>
                        <li>Repository-Service Pattern</li>
                        <li>Design Patterns</li>
                        <li>AWS EC2/DNS/VPN/VPC</li>
                        <li>oAuth</li>
                        <li>MySQL</li>
                        <li>MongoDB</li>
                        <li>DevOps - Git Flow</li>
                        <li>Integration/Regression/Unit Testing</li>
                        <li>Auto Deployment - pipeline</li>
                        <li>Algorithms</li>
                        <li>AI</li>
                        <li>Bitbucket/JIRA</li>
                        <li>Docker</li>
                        <li>HCI - Human Computer Interaction</li>
                    </ul>
                    {{--<a href="https://laravel.com/docs">Documentation</a>--}}
                    {{--<a href="https://laracasts.com">Laracasts</a>--}}
                    {{--<a href="https://laravel-news.com">News</a>--}}
                    {{--<a href="https://forge.laravel.com">Forge</a>--}}
                    {{--<a href="https://github.com/laravel/laravel">GitHub</a>--}}
                </div>
            </div>
        </div>
    </body>
</html>
