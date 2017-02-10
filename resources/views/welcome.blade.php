<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Roster</title>

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
                    <a href="{{ url('/login') }}">Login</a>
                    <!--a href="{{ url('/register') }}">Register</a-->
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    Roster 
                </div>

                <div class="links">
                    <div id="ct"></div>
                    
                </div>
            </div>
        </div>
        <script type="text/javascript">
    
function display_c(){
    setTimeout('display_ct()',1000);
}

function display_ct() {

    var x = new Date();
    var d = x.toString().split(' ').slice(0, 4).join(' ');
    var d1 = x.toString().split(' ').slice(4).join(' ');
    document.getElementById('ct').innerHTML = d+"<br>"+d1;
    tt=display_c();
}
window.onload=display_ct();
    
</script>
    </body>
</html>
