<html>
    <head>
        <title>Certificate of Completion in course {{$course->course_name}}</title>
        <style type='text/css'>
            body, html {
                margin: 0;
                padding: 0;
            }
            body {
                color: black;
                display: table;
                font-family: Georgia, serif;
                font-size: 24px;
                text-align: center;
            }
            .container {
                border: 20px solid #303956;
                width: 760px;
                height: 563px;
                display: table-cell;
                vertical-align: middle;
            }
            .logo {
                color: #303956;
            }

            .marquee {
                color: #303956;
                font-size: 48px;
                margin: 20px;
            }
            .assignment {
                margin: 20px;
            }
            .person {
                border-bottom: 2px solid black;
                font-size: 32px;
                font-style: italic;
                margin: 20px auto;
                width: 400px;
            }
            .reason {
                margin: 20px;
            }
        </style>
    </head>
    <body onload="window.print()">
        <div class="container">
            <div class="logo">
                ScienceCode Course
            </div>

            <div class="marquee">
                Certificate of Completion
            </div>

            <div class="assignment">
                This certificate is presented to
            </div>

            <div class="person">
                {{$user->name}}
            </div>

            <div class="reason">
                <span style="font-size:18px">For completing course</span><br>
                "{{$course->course_name}}"
            </div>
        </div>
    </body>
</html>