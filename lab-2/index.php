<?php include 'getProductWithCookie.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Page</title>
    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../../assets/css/style.css" rel="stylesheet" type="text/css">
</head>

<body>

    <div class="container">
        <aside class="sidebar">
            <b>Parameter Hidden</b>
            <p>Pada studi kasus berikut terdapat kerentanan SQL Injection pada cookie</p>


        </aside>

        <div class="main-content">
            <div>
                <?php


                if ($isLogin == true) {

                    echo "Welcome Back " . $username;
                } else {
                    echo "<a href='#'>Login</a>";
                }
                ?>
            </div>
            <div class="filter mt-10">
                <span>Kategori:</span>
                <a href="<?php echo $host . '/sql-injection/lab-2'; ?>">
                    <button>Semua</button>
                </a>
                <a href="?category=pakaian">
                    <button>Pakaian</button>
                </a>
                <a href="?category=teknologi">
                    <button>Teknologi</button>
                </a>
                <a href="?category=elektronik">
                    <button>Elektronik</button>
                </a>
                |
                <a href="<?php echo $host; ?>/sql-injection">
                    <button>Back</button>
                </a>
            </div>

            <div class="product-grid">
                <?php

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) { ?>
                        <div class="product">
                            <img src="<?php echo $host . '/assets/gallery/lab-1/' . $row['thumbnail']; ?>">
                            <h4><?php echo $row['name']; ?> </h4>
                            <h6>Kategori: <?php echo $row['name']; ?> </h6>
                            <p class="price">Rp.<?php echo $row['price']; ?></p>
                            <button>View details</button>
                        </div>
                <?php }
                } else {
                    echo "Tidak ada produk yang ditemukan.";
                }
                ?>

            </div>
            <hr>
            <div class="right mt-2">
                <?php
                echo '<a href="' . $host . '/sql-injection"><button class="button-primary" >Back</button></a>';
                ?>
            </div>
        </div>
    </div>

</body>

</html>