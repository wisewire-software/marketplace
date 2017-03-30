<?php
$protocol = $_SERVER["SERVER_PROTOCOL"];
if ('HTTP/1.1' != $protocol && 'HTTP/1.0' != $protocol)
    $protocol = 'HTTP/1.0';
header("$protocol 503 Service Unavailable", true, 503);
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Wisewire - maintenance</title>
    <link href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css' rel='stylesheet' type='text/css'>
    <style>
        html {
            font-size: 20px;
            line-height: 1.4;
            color: #737373;
            background: #fff;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }

        .header-logo a {
            margin-top: 0;
            padding: 8px 17px 1px 17px;
            background: #00b4cd;
            border-bottom-right-radius: 8px;
            border-bottom-left-radius: 8px;
            display: inline-block;
            color: #fcfafa;
            text-decoration: none;
        }

        .header-logo .logo {
            background: url("/wp-content/themes/wisewire/img/logo.svg") 0 0 no-repeat;
            width: 160px;
            height: 32px;
            display: block;
            background-size: cover;

        }

        .wrapper-content {
            display: table;
            height: calc(100vh - 61px);
            width: 100%;
        }

        .wrapper-content .content {
            display: table-cell;
            margin: 0;
            color: #5f5f5f;
            vertical-align: middle;
        }

        .wrapper-content .content h1 {
            font-size: 60px;
            color: #ff6900;
        }

        .wrapper-content .content h2 {
            font-size: 24px;
        }

        .wrapper-content .content .text {
            padding-top: 80px;
            font-size: 30px;
        }

        .wrapper-content .content .login-student a {
            font-size: 18px;
            color: #d42a62;
            text-decoration: none;
            font-weight: bold;
        }

    </style>
</head>
<body>
<header>
    <div class="container">
        <div class="header-logo">
            <a href="#"><span class="logo"></span>education marketplace</a>
        </div>
    </div>
</header>
<div class="container">
    <div class="wrapper-content">
        <div class="content">
            <h1><strong>Wisewire.com</strong> is currently down for site enhancements</h1>
            <h2>We expect to be back in a couple of hours. Thanks for your patience</h2>
            <div class="text">Students can still access their Wisewire assessments</div>
            <div class="login-student">
                <a href="https://platform.wisewire.com/login">ENTER HERE</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>