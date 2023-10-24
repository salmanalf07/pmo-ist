<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .header {
            text-align: left;
            position: fixed;
            top: 0;
            width: 100%;
            padding: 10px;
        }

        .logo {
            max-width: 80px;
            float: left;
        }

        .title-container {
            display: inline-block;
            margin-left: 20px;
            /* Sesuaikan jarak antara logo dan teks besar */
            vertical-align: top;
        }

        .title {
            font-size: 16pt;
            text-align: center;
            margin-bottom: 0px;
            margin-top: 30px;
        }

        .subtitle {
            font-size: 6pt;
            text-align: center;
            display: block;
            margin-top: 0px;
        }

        .garis {
            margin-top: 100px;
            border-collapse: collapse;
        }

        .content {
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="header">
        <img class="logo" src="{{asset('/assets/images/logo-ist.png')}}" alt="Logo">
        <h1 class="title">MINUTES OF MEETING</h1>
        <h2 class="subtitle">PMO-DOC-MOM-v1.0</h2>
    </div>
    <div class="garis">
        <hr>
    </div>
</body>

</html>