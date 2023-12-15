<?php
require_once '../includes/pages.php';
require_once '../includes/commands.php';

if (isset($_SESSION['client_name'])) {
    header('location:' . $_SERVER['HTTP_REFERER']);
    exit;
}

$allPages = new Pages();
$commands = new Commands();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include("../components/head.html") ?>
</head>

<body>
    <div class="flex flex-col justify-end items-start h-[100vh]">
        <div class="flex pl-8">
            <p class="border-gray-300 rounded-t-lg p-2 pb-1 text-xl">Commands</p>
        </div>
        <div class="border-2 border-gray-300 rounded-xl h-[90vh] w-full flex">
            <div class="flex flex-col justify-between w-full p-4 shadow-3xl">
                <?php
                $start = 0;
                $rows_per_page = 6;
                $result = $allPages->getPagesDetails($start, $rows_per_page, 'commands', '');
                $start = $allPages->start;
                $rows = $allPages->rows;
                $pages = $allPages->pages;
                if ($rows > 0) {
                    $result = $commands->getAllCommands($start, $rows_per_page);
                    foreach ($result as $row) {
                        $commandId = $row['commandId'];
                        $cartId = $row['cartId'];
                        $commandDate = $row['commandDate'];
                        $userName = $row['userName'];
                        $total = $row['total'];
                ?>
                        <a href="commandDetails.php?commandId=<?php echo $commandId ?>&cartId=<?php echo $cartId ?>&total=<?php echo $total ?>" class="w-full h-[100px] border-2 rounded-md bg-slate-200 hover:bg-[#bdff72] cursor-pointer">
                            <div class="w-full h-[90%] mx-auto flex items-center justify-around p-3 child:text-xl child:font-medium">
                                <p>N°: <?php echo $commandId ?></p>
                                <p><?php echo $userName ?></p>
                                <p><?php echo $commandDate ?></p>
                                <p><?php echo $total ?> DH</p>
                            </div>
                        </a>
                <?php
                    }
                } else {
                    echo 'No client accounts in database';
                }
                ?>
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

                            <a href="?page=<?php echo $_GET['page'] - 1
                                            ?>">Previous</a>

                        <?php } else { ?>
                            <a class="cursor-pointer">Previous</a>
                        <?php } ?>

                        <?php
                        for ($i = 1; $i <= $pages; $i++) {
                        ?>
                            <a href="?page=<?php echo $i ?>" class=""><?php echo $i ?></a>
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
                            <a href="?page=<?php echo $_GET['page'] + 1 ?>">Next</a>
                        <?php }
                        ?>
                        <a href="?page=<?php echo $pages ?>">Last</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
</body>

</html>