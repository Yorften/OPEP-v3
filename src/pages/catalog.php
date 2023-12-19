<?php

require_once '../includes/pages.php';
require_once '../includes/CartDAO.php';
require_once '../includes/CategoryDAO.php';
require_once '../includes/PlantDAO.php';

if (!isset($_SESSION['client_name'])) {
    echo "You don't have permission";
    exit;
}

$allPages = new Pages();
$Plants = new PlantDAO();
$Categories = new CategoryDAO();
$Cart = new CartDAO();


if (isset($_POST['addCart'])) {
    $plantId = $_POST['plantId'];
    $cartId = $_SESSION['client_cart'];
    $Cart->getCart()->getPlant()->setId($plantId);
    $Cart->getCart()->setId($cartId);

    $result = $Cart->PlantExistsInCart($Cart->getCart());
    if ($result !== NULL) {
        $isSelected = $result->getIsSelected();
        if ($isSelected !== 0) {
            $msg[] = "The product you're trying to add is already selected for a checkout";
        } else {
            $qunatity = $result->getQuantity();
            $Cart->getCart()->getPlant()->setId($plantId);
            $Cart->getCart()->setId($cartId);
            $Cart->getCart()->setQuantity($qunatity);
            $result = $Cart->incrementQuantity($Cart->getCart());
            if ($result) {
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                exit;
            } else {
                $msg2[] = "Database Error";
                exit;
            }
        }
    } else {

        $result = $Cart->addToCart($Cart->getCart());
        if ($result) {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        } else {
            $msg2[] = "Database Error";
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include("../components/head.html") ?>
    <title>Catalog | O'PEP</title>
</head>

<body>

    <?php include("../components/nav.php") ?>
    <div class="w-full text-center my-4">
        <a class="p-2 border-2 filters" href="catalog.php">All</a>
        <?php
        $categories = $Categories->getCategories();
        if (count($categories) > 0) {
            foreach ($categories as $category1) {
                $id = $category1->getId();
                $name = $category1->getName();
        ?>
                <a class="p-2 border-2 filters" href="?categoryId=<?= $id ?>"><?= $name ?></a>
        <?php
            }
            echo   '</div>';
        } else {
            echo 'No categories in database';
        } ?>
        <div class="flex flex-col justify-between items-center border-2 border-amber-600 rounded-xl m-2 md:h-fit">
            <?php
            if (isset($msg)) {
                foreach ($msg as $error) {
                    echo '<div class="bg-red-500 mb-3 px-2 rounded-lg">';
                    echo '<p class="text-white text-lg text-center">' . $error . '</p>';
                    echo '</div>';
                }
            }
            if (isset($msg2)) {
                foreach ($msg2 as $error) {
                    echo '<div class="bg-green-500 mb-3 px-2 rounded-lg">';
                    echo '<p class="text-white text-lg text-center">' . $error . '</p>';
                    echo '</div>';
                }
            }
            ?>
            <div class="grid gap-4 w-[90%] mt-6 rounded-lg mx-auto text-center grid-cols-2 md:w-[95%] md:grid-cols-3">
                <!-- content -->
                <?php

                if (isset($_GET['categoryId'])) {
                    $categoryId = $_GET['categoryId'];

                    $start = 0;
                    $rows_per_page = 6;
                    $result = $allPages->getPagesDetails($start, $rows_per_page, 'plants INNER JOIN categories on plants.categoryId = categories.categoryId', 'WHERE plants.categoryId = ' . $categoryId);
                    $start = $allPages->getStart();
                    $rows = $allPages->getRows();
                    $pages = $allPages->getPages();

                    $Plants->getObject()->setCategory($categoryId);
                    $result = $Plants->getPlantsCategoryPage($start, $rows_per_page);
                } else {
                    $start = 0;
                    $rows_per_page = 6;
                    $result = $allPages->getPagesDetails($start, $rows_per_page, 'plants INNER JOIN categories ON plants.categoryId = categories.categoryId', '');
                    $start = $allPages->getStart();
                    $rows = $allPages->getRows();
                    $pages = $allPages->getPages();

                    $result = $Plants->getPlantsPage($start, $rows_per_page);
                }
                if ($rows > 0) {
                    foreach ($result as $plant1) {
                        $id = $plant1->getId();
                        $name = $plant1->getName();
                        $categorie = $plant1->getCategory();
                        $desc = $plant1->getDesc();
                        $image = $plant1->getImage();
                        $price = $plant1->getPrice();
                ?>
                        <div class="flex flex-col justify-center items-center gap-4 w-full md:w-[80%] mx-auto">
                            <div class="relative object-contain">
                                <img id="image" src="../images/Plants/<?= $image ?>" alt="">
                                <div id="hover" class="absolute bottom-0 left-0 w-full bg-white transition-all duration-500 transform translate-y-full opacity-0">
                                    <p class="p-4"><?= $desc ?></p>
                                </div>
                            </div>
                            <div class="flex flex-col justify-between w-full items-center md:flex-row">
                                <div class="flex flex-col child:text-left">
                                    <p><?= $name ?></p>
                                    <p class="font-medium"><?= $categorie ?></p>
                                </div>
                                <form method="post" class="flex flex-col items-center justify-center gap-1">
                                    <input type="text" name="plantId" value="<?= $id ?>" hidden>
                                    <button type="submit" name="addCart" class="z-10 p-2 bg-amber-400 border border-black rounded-lg">Add to cart</button>
                                    <p class="font-bold"><?= $price ?>DH</p>
                                </form>
                            </div>
                        </div>
                <?php
                    }
                    echo '</div>';
                } else {
                    echo 'No client accounts in database';
                }
                ?>
                <?php if (!isset($_GET['categoryId'])) { ?>
                    <div class="w-full mt-4 md:mt-8">
                        <div class="pl-2 md:pl-8">
                            <?php
                            if (!isset($_GET['page'])) {
                                $page = 1;
                            } else {
                                $page = $_GET['page'];
                            }
                            ?>
                            Showing <?= $page ?> of <?= $pages ?>
                        </div>
                        <div class="flex flex-row justify-center items-center gap-3">

                            <a href="?page=1">First</a>
                            <?php if (isset($_GET['page']) && $_GET['page'] > 1) { ?>

                                <a href="?page=<?= $_GET['page'] - 1 ?>">Previous</a>

                            <?php } else { ?>
                                <a class="cursor-pointer">Previous</a>
                            <?php } ?>

                            <?php
                            for ($i = 1; $i <= $pages; $i++) {
                            ?>
                                <a href="?page=<?= $i ?>" class=""><?= $i ?></a>
                            <?php
                            }
                            ?>
                            <?php
                            if (!isset($_GET['page'])) {
                                if ($pages == 1) {
                            ?>
                                    <a class="cursor-pointer">Next</a>
                                <?php } else { ?>
                                    <a href="?page=2">Next</a>
                                <?php } ?>

                            <?php } elseif ($_GET['page'] >= $pages) { ?>
                                <a class="cursor-pointer">Next</a>
                            <?php } else { ?>
                                <a href="?page=<?= $_GET['page'] + 1 ?>">Next</a>
                            <?php }
                            ?>
                            <a href="?page=<?= $pages ?>">Last</a>
                        </div>
                    </div>
                <?php } else {
                ?>
                    <div class="w-full mt-4 md:mt-8">
                        <div class="pl-2 md:pl-8">
                            <?php
                            if (!isset($_GET['page'])) {
                                $page = 1;
                            } else {
                                $page = $_GET['page'];
                            }
                            ?>
                            Showing <?= $page ?> of <?= $pages ?>
                        </div>
                        <div class="flex flex-row justify-center items-center gap-3">

                            <a href="?page=1&categoryId=<?= $_GET['categoryId'] ?>">First</a>
                            <?php if (isset($_GET['page']) && $_GET['page'] > 1) { ?>

                                <a href="?page=<?= $_GET['page'] - 1 ?>&categoryId=<?= $_GET['categoryId'] ?>">Previous</a>

                            <?php } else { ?>
                                <a class="cursor-pointer">Previous</a>
                            <?php } ?>

                            <?php
                            for ($i = 1; $i <= $pages; $i++) {
                            ?>
                                <a href="?page=<?= $i ?>&categoryId=<?= $_GET['categoryId'] ?>" class=""><?= $i ?></a>
                            <?php
                            }
                            ?>
                            <?php
                            if (!isset($_GET['page'])) {
                                if ($pages == 1) {
                            ?>
                                    <a class="cursor-pointer">Next</a>
                                <?php } else { ?>
                                    <a href="?page=2&categoryId=<?= $_GET['categoryId'] ?>">Next</a>
                                <?php } ?>

                            <?php } elseif ($_GET['page'] >= $pages) { ?>
                                <a class="cursor-pointer">Next</a>
                            <?php } else { ?>
                                <a href="?page=<?= $_GET['page'] + 1 ?>&categoryId=<?= $_GET['categoryId'] ?>">Next</a>
                            <?php }
                            ?>
                            <a href="?page=<?= $pages ?>&categoryId=<?= $_GET['categoryId'] ?>">Last</a>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <?php include("../components/footer.html") ?>

    <script src="../js/burger.js"></script>
    <script src="../js/filter.js"></script>
    <script src="../js/cartmenu.js"></script>
</body>

</html>