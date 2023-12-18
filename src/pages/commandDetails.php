<?php
require_once '../includes/pages.php';
require_once '../includes/commands.php';

if (isset($_SESSION['client_name'])) {
    echo "You don't have permission";
    exit;
}
$allPages = new Pages();
$commandDetails = new Commands();

$commandId = isset($_GET['commandId']) ? intval($_GET['commandId']) : 0;
$cartId = isset($_GET['cartId']) ? intval($_GET['cartId']) : 0;
$total = isset($_GET['total']) ? intval($_GET['total']) : 0;

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <?php include("../components/head.html") ?>
</head>

<body>
    <div class="flex flex-col justify-end items-start h-[100vh]">
        <div class="flex justify-between items-center w-full md:px-8">
            <p class="border-gray-300 rounded-t-lg p-2 pb-1 text-xl">Command N°: <?php echo $commandId ?></p>
            <p>Total price: <?php echo $total ?> DH</p>
        </div>
        <div class="border-2 border-gray-300 rounded-xl h-[90vh] w-full flex">
            <div class="flex flex-col justify-between w-full p-4">
                <?php
                $start = 0;
                $rows_per_page = 8;
                $result = $allPages->getPagesDetails($start, $rows_per_page, 'plants_carts', ' WHERE cartId = ' . $cartId . ' AND isCommanded = ' . $commandId);
                $start = $allPages->getStart();
                $rows = $allPages->getRows();
                $pages = $allPages->getPages();
                ?>
                <table class="table-auto md:table-fixed w-full ">
                    <thead class="border">
                        <tr class="border-2">
                            <th class="w-[30%] p-1 md:px-4 md:py-2 border-2 border-[#A3A3A3] text-xs md:text-base">Plant</th>
                            <th class="w-[20%] p-1 md:px-4 md:py-2 border-2 border-[#A3A3A3] text-xs md:text-base">Category</th>
                            <th class="w-[10%] p-1 md:px-4 md:py-2 border-2 border-[#A3A3A3] text-xs md:text-base">Quantity</th>
                            <th class="w-[20%] p-1 md:px-4 md:py-2 border-2 border-[#A3A3A3] text-xs md:text-base">Price /unit</th>
                            <th class="w-[20%] p-1 md:px-4 md:py-2 border-2 border-[#A3A3A3] text-xs md:text-base">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $result = $commandDetails->getCommandedItems($cartId, $commandId, $start, $rows_per_page);
                        foreach ($result as $row) {
                            $plantName = $row['plantName'];
                            $categoryName = $row['categoryName'];
                            $quantity = $row['quantity'];
                            $plantPrice = $row['plantPrice'];
                            $totalPrice = $plantPrice * $quantity;

                        ?>
                            <tr>
                                <td class="p-1 md:px-4 md:py-2 border-2 border-[#A3A3A3] text-xs md:text-base text-center"><?php echo $plantName ?></td>
                                <td class="p-1 md:px-4 md:py-2 border-2 border-[#A3A3A3] text-xs md:text-base text-center"><?php echo $categoryName ?></td>
                                <td class="p-1 md:px-4 md:py-2 border-2 border-[#A3A3A3] text-xs md:text-base text-center"><?php echo $quantity ?></td>
                                <td class="p-1 md:px-4 md:py-2 border-2 border-[#A3A3A3] text-xs md:text-base text-center"><?php echo $plantPrice ?></td>
                                <td class="p-1 md:px-4 md:py-2 border-2 border-[#A3A3A3] text-xs md:text-base text-center"><?php echo $totalPrice ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <div>
                    <div class="pl-6">
                        <?php
                        if (!isset($_GET['page'])) {
                            $page = 1;
                        } else {
                            $page = $_GET['page'];
                        }
                        ?>
                        Showing <?php echo $page ?> of <?php echo $pages ?>
                    </div>
                    <div class="flex flex-row justify-center items-center gap-3">

                        <a href="?page=1">First</a>
                        <?php if (isset($_GET['page']) && $_GET['page'] > 1) { ?>

                            <a href="?page=<?php echo $_GET['page'] - 1 ?>&commandId=<?php echo $commandId ?>&cartId=<?php echo $cartId ?>&total=<?php echo $total ?>">Previous</a>

                        <?php } else { ?>
                            <a class="cursor-pointer">Previous</a>
                        <?php } ?>

                        <?php
                        for ($i = 1; $i <= $pages; $i++) {
                        ?>
                            <a href="?page=<?php echo $i ?>&commandId=<?php echo $commandId ?>&cartId=<?php echo $cartId ?>&total=<?php echo $total ?>" class=""><?php echo $i ?></a>
                        <?php
                        }
                        ?>
                        <?php
                        if (!isset($_GET['page'])) {
                            if ($pages == 1) {
                        ?>
                                <a class="cursor-pointer">Next</a>
                            <?php } else { ?>
                                <a href="?page=2&commandId=<?php echo $commandId ?>&cartId=<?php echo $cartId ?>&total=<?php echo $total ?>">Next</a>
                            <?php } ?>

                        <?php } elseif ($_GET['page'] >= $pages) { ?>
                            <a class="cursor-pointer">Next</a>
                        <?php } else { ?>
                            <a href="?page=<?php echo $_GET['page'] + 1 ?>&commandId=<?php echo $commandId ?>&cartId=<?php echo $cartId ?>&total=<?php echo $total ?>">Next</a>
                        <?php }
                        ?>
                        <a href="?page=<?php echo $pages ?>&commandId=<?php echo $commandId ?>&cartId=<?php echo $cartId ?>&total=<?php echo $total ?>">Last</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>