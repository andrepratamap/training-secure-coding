<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Coding</title>
    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../../assets/css/style.css" rel="stylesheet" type="text/css">
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
    <script>
        function submitLogin(event) {
            event.preventDefault(); // Mencegah form dari pengiriman default

            // Mengambil nilai dari form
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            // Membuat objek untuk JSON
            const data = {
                email: email,
                password: password
            };

            // Mengirim data menggunakan fetch
            fetch('actLogin.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data) // Mengonversi objek ke JSON
            })
                .then(response => response.json()) // Mengonversi respons menjadi JSON
                .then(data => {
                    // Menangani respons dari server
                    alert(data.message);
                })
                .catch((error) => {
                    console.error('Error:', error);
                });
        }
    </script>
</head>
<body>

<div class="container">
    <aside class="sidebar">
        <b>Parameter Hidden</b>
        <p>Pada studi kasus berikut terdapat kerentanan NoSQL Injection</p>
        <p>Adapun payload yang digunakan adalah:</p>
         {
            "email":"user@example.com",
            "password": {"$ne": null}
        }

    </aside>

    <div class="main-content">
        <div class="filter">
            <a href="<?php echo $host;?>/nosql-injection" ><button type="button" class="btn btn-outline-primary">Back</button></a>
        </div>

        <div class="login-container">
            <h2>Login</h2>
            <form onsubmit="submitLogin(event)">
                <div class="form-group">
                    <label for="username">Email</label>
                    <input type="email" class="form-control" id="email" value="user@example.com">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" placeholder="Enter your password" required>
                </div>
                <br>
                <button type="submit" class="btn btn-primary btn-block">Login</button>
            </form>

        </div>
    </div>
</div>

</body>
</html>
