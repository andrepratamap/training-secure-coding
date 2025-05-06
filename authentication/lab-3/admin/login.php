<?php session_start(); 
$host = "http://127.0.0.1:8003";?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Coding</title>
    <link rel="stylesheet" href="../../../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../../../assets/css/style.css" rel="stylesheet" type="text/css">
    <style>
        button {
            background-color: #006699 !important;
            color: white !important;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>

</head>
<body>

<div class="container">
    <aside class="sidebar">
        <p>Hanya form login biasa tanpa ada action</p>

    </aside>

    <div class="main-content">
        <div class="filter">
            <a href="<?php echo $host;?>/authentication/" ><button type="button" class="btn btn-outline-primary">Back</button></a>
        </div>

        <div class="login-container">
            <h2>Login Admin</h2>
            <form>
                <div class="form-group">
                    <label for="username">Email</label>
                    <input type="email" class="form-control" id="email" name="email">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>
                <br>
                <button type="submit" class="btn btn-primary btn-block">Login</button>
            </form>

        </div>
    </div>
</div>

</body>
</html>
