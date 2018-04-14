<!DOCTYPE html>
<html lang="en">
<head>

    <!-- Html Page Specific -->
    <title>Tick-Tock Todo</title>
    <meta name="description" content="">
    <meta name="author" content="">
    <meta charset="utf-8">


    <!-- Mobile Specific -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">


    <!-- CSS -->
    <link rel="stylesheet" href="/social//css/bootstrap.min.css"/>
    <link rel="stylesheet" href="/social//css/font-awesome.min.css"/>
    <link rel="stylesheet" href="/social/css/style.css"/>


    <!--[if lt IE 9]>
    <script type="text/javascript" src="/social/scripts/respond.min.js"></script>
    <script type="text/javascript" src="/social/scripts/html5shiv.js"></script>
    <![endif]-->

    <!-- Favicons -->
    {{--<link rel="shortcut icon" href="/social/images/favicon.ico">--}}
    {{--<link rel="apple-touch-icon" href="/social/images/apple-touch-icon.png">--}}
    {{--<link rel="apple-touch-icon" sizes="72x72" href="/social/images/apple-touch-icon-72x72.png">--}}
    {{--<link rel="apple-touch-icon" sizes="114x114" href="/social/images/apple-touch-icon-114x114.png">--}}

</head>
<body>

<div id="wrap">

    <!-- CLOUDS SECTION BEGIN -->
    <section id="clouds">
        <div class="cloud1"></div>
        <div class="cloud2"></div>
        <div class="cloud3"></div>
        <div class="cloud4"></div>
    </section>
    <!-- CLOUDS SECTION END -->


    <!-- INTRO SECTION BEGIN -->
    <section id="intro">
        <div class="container">
            <div class="row">
                <div class="col-md-12">

                    {{--<div class="logo"></div>--}}

                    <p class="slogan">Start your Todo, Work, Timer by today. <br>
                        Be organised. Be timed. Be prepared. </p>


                    <div>
                        <a href="{{route('app')}}" class="btn btn-warning btn-lg btn-round">START NOW! </a>
                    </div>


                    <ul class="soc_nav">
                        <li class="mail"><a href="mailto:me@ryandeng.com" target="_blank"><i class="fa fa-envelope"></i></a>
                        </li>
                        {{--<li class="twitter"><a href="https://twitter.com/" target="_blank"><i class="fa fa-twitter"></i></a></li>--}}
                        {{--<li class="fb"><a href="https://www.facebook.com/" target="_blank"><i class="fa fa-facebook"></i></a></li>--}}
                        {{--<li class="dribbble"><a href="https://dribbble.com/" target="_blank"><i class="fa fa-dribbble"></i></a></li>--}}
                        {{--<li class="gplus"><a href="https://plus.google.com/" target="_blank"><i class="fa fa-google-plus"></i></a></li>--}}
                        <li class="linkedin"><a href="//www.linkedin.com/in/ryandeng/" target="_blank"><i
                                        class="fa fa-linkedin-square"></i></a></li>
                    </ul>



                    <div class="tower">
                        <div class="body"></div>
                        <div class="clock">
                            <div class="arrow_min"></div>
                            <div class="arrow_sec"></div>
                        </div>
                        <div class="window">
                            <div class="left_blind"></div>
                            <div class="right_blind"></div>
                        </div>
                        <div class="bubble">Time <br>now!</div>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <!-- INTRO SECTION END -->


    <!-- CONTENT SECTION BEGIN -->
    <section id="content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>About Me</h2>
                    <p>Hello, my name is ryan.</p>
                </div>
            </div>
        </div>
    </section>
    <!-- CONTENT SECTION END -->


    <!-- FOOTER BEGIN -->
    <footer id="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="copyright">
                        &copy; 2018 RyanDeng.com
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- FOOTER END -->


</div>


<!-- JavaScript -->
<script src="/social/scripts/jquery-1.8.2.min.js"></script>
{{--<script src="/social/scripts/bootstrap.min.js"></script>--}}
{{--<script src="/social/scripts/jquery.validate.min.js"></script>--}}
{{--<script src="/social/scripts/custom.js"></script>--}}

<style>


    section .btn {
        margin: 20px 0px 0px 0px;
    }

    .btn {
        font-weight: bold;
        font-size: 12px;
        letter-spacing: 2px;
        padding: 13px 17px;
        border: none;
        -webkit-border-radius: 2px;
        -webkit-background-clip: padding-box;
        -moz-border-radius: 2px;
        -moz-background-clip: padding;
        border-radius: 2px;
        background-clip: padding-box;
        -webkit-transition: color 0.2s linear, background-color 0.2s linear;
        transition: color 0.2s linear, background-color 0.2s linear;
    }

    .btn.btn-default {
        color: #000;
        background-color: #ffffff;
        border: 1px solid #e6e6e6;
    }

    .btn.btn-default.btn-border {
        border-color: #ffffff;
        color: #fff;
    }

    .btn.btn-default.btn-3d {
        box-shadow: inset 0 -2px 0 #cccccc;
    }

    .btn.btn-default:hover {
        background-color: #e6e6e6;
        color: #000;
    }

    .btn.btn-primary {
        background-color: #3498db;
    }

    .btn.btn-primary.btn-border {
        border-color: #3498db;
        color: #3498db;
    }

    .btn.btn-primary.btn-3d {
        box-shadow: inset 0 -2px 0 #196090;
    }

    .btn.btn-primary:hover {
        background-color: #217dbb;
        color: #fff;
    }

    .btn.btn-success {
        background-color: #2ecc71;
    }

    .btn.btn-success.btn-border {
        border-color: #2ecc71;
        color: #2ecc71;
    }

    .btn.btn-success.btn-3d {
        box-shadow: inset 0 -2px 0 #1b7943;
    }

    .btn.btn-success:hover {
        background-color: #25a25a;
        color: #fff;
    }

    .btn.btn-info {
        background-color: #81cfe0;
    }

    .btn.btn-info.btn-border {
        border-color: #81cfe0;
        color: #81cfe0;
    }

    .btn.btn-info.btn-3d {
        box-shadow: inset 0 -2px 0 #32aec9;
    }

    .btn.btn-info:hover {
        background-color: #58bfd6;
        color: #fff;
    }

    .btn.btn-warning {
        background-color: #f39c12;
    }

    .btn.btn-warning.btn-border {
        border-color: #f39c12;
        color: #f39c12;
    }

    .btn.btn-warning.btn-3d {
        box-shadow: inset 0 -2px 0 #976008;
    }

    .btn.btn-warning:hover {
        background-color: #c87f0a;
        color: #fff;
    }

    .btn.btn-danger {
        background-color: #c0392b;
    }

    .btn.btn-danger.btn-border {
        border-color: #c0392b;
        color: #c0392b;
    }

    .btn.btn-danger.btn-3d {
        box-shadow: inset 0 -2px 0 #6d2018;
    }

    .btn.btn-danger:hover {
        background-color: #962d22;
        color: #fff;
    }

    .btn.btn-lg {
        font-size: 14px;
        padding: 17px 24px;
    }

    .btn.btn-round {
        -webkit-border-radius: 40px;
        -webkit-background-clip: padding-box;
        -moz-border-radius: 40px;
        -moz-background-clip: padding;
        border-radius: 40px;
        background-clip: padding-box;
    }

</style>
</body>
</html>


