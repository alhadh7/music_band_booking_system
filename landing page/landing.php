<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="landing.css">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@100&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<style>
   @font-face {
  font-family:"medusa";
  src: url("medusa.woff") format('woff');
}
body {
            background:black;
            margin: 0px;
            padding: 0px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            font-family: kanit;
        }

        h1 {
            font-size: 36px;
            color:white;
        }

        .options {
            display: flex;
            flex-direction: row;
            margin-top: 20px;
            text-align: center;
        }

        .options a {
            display: block;
            padding: 15px 20px;
            margin: 10px 0;
            text-decoration: none;
            background-color: #1a5594;
            color: #fff;
            border-radius: 5px;
            transition: background-color 0.3s, transform 0.3s;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
        }

        .options a:hover {
            background-color: cyan;
            transform: scale(1.05);
        }

        .pic{
            margin:20px;
        }

</style>
<body>
    <br><h1 style="margin-top: 40px; margin-bottom: -10px;">Band booking system</h1><br>
    <div class="options">  
    <a href="./uls/ls.html" style="margin:20px"><img src="user2.jpg" alt="" style=" height: 371px;  width: 350px; border-radius: 100px;
"><h1>User</h1></a><br>
    <a href="./bls/ls.html" style="margin:20px"><img src="band3.jpg" alt="" style="height: 371px;   width: 350px;  border-radius: 100px;
"><h1>Band</h1></a><br>
    <a href="./als/ls.html" style="margin:20px"><img src="admin99.jpg" style=" height: 371px; width: 350px;      border-radius: 100px;
" alt=""><h1>Admin   </h1></a><br>
</div>
</body>
</html>