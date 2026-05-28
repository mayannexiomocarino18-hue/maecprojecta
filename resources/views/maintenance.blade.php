<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance Mode</title>

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family: Arial, sans-serif;
        }

        body{
            height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
            background: repeating-linear-gradient(
                45deg,
                #59c3e6,
                #59c3e6 20px,
                #48b7dc 20px,
                #48b7dc 40px
            );
        }

        .container{
            text-align:center;
        }

        .monitor{
            width:350px;
            background:#c8f1ff;
            border:12px solid #2f3b52;
            border-radius:12px;
            padding:40px 20px;
            box-shadow:0 8px 15px rgba(0,0,0,0.25);
            position:relative;
        }

        .monitor::before{
            content:'';
            position:absolute;
            width:70px;
            height:15px;
            background:#2f3b52;
            bottom:-28px;
            left:50%;
            transform:translateX(-50%);
            border-radius:4px;
        }

        .monitor::after{
            content:'';
            position:absolute;
            width:120px;
            height:12px;
            background:#2f3b52;
            bottom:-45px;
            left:50%;
            transform:translateX(-50%);
            border-radius:4px;
        }

        h1{
            font-size:38px;
            font-weight:bold;
            color:#1e2d44;
            line-height:1.2;
        }

        p{
            margin-top:20px;
            font-size:16px;
            color:#1e2d44;
        }

        .dot{
            position:absolute;
            width:10px;
            height:10px;
            background:#2f3b52;
            border-radius:50%;
            right:15px;
            bottom:15px;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="monitor">
            <h1>MAINTENANCE<br>REPAIR AND<br>OPERATIONS!</h1>
            <p>System is temporarily unavailable.</p>
            <div class="dot"></div>
        </div>
    </div>

</body>
</html>