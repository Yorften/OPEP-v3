<?php
require_once '../includes/pages.php';
require_once '../includes/UserDAO.php';

if (isset($_SESSION['administrator_name']) || isset($_SESSION['admin_name'])) {

    $allPages = new Pages();
    $user = new UserDAO();

    if (isset($_POST['changeStatus'])) {
        $user->getObject()->setId($_POST['userId']);
        $user->getObject()->setIsVerified($_POST['isVerified']);
        $result = $user->toggleAccount($user->getObject());
        if ($result) {
            $msg2[] = 'Status changed successfully';
        } else $msg[] = 'Database Error';
    }
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <?php include("../components/head.html") ?>
    </head>

    <body>
        <div class="flex flex-col justify-end items-start h-[100vh]">
            <div class="flex justify-between items-center w-full md:px-8">
                <p class="border-gray-300 rounded-t-lg p-2 pb-1 text-xl">Clients</p>
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
            </div>
            <div class="border-2 border-gray-300 rounded-xl h-[90vh] flex">
                <div id="clients" class="flex flex-col justify-between w-full p-4">
                    <?php
                    $start = 0;
                    $rows_per_page = 8;
                    $result = $allPages->getPagesDetails($start, $rows_per_page, 'users', 'WHERE roleId = 1');
                    $start = $allPages->getStart();
                    $rows = $allPages->getRows();
                    $pages = $allPages->getPages();

                    if ($rows > 0) {
                        $users = $user->getClientsPage($start, $rows_per_page);
                        echo ' 
        <table class="table-auto md:table-fixed w-full ">
            <thead class="border">
                <tr class="border-2">
                    <th class="w-1/5 p-1 md:px-4 md:py-2 border-2 border-[#A3A3A3] text-xs md:text-base">Client Id</th>
                    <th class="w-1/5 p-1 md:px-4 md:py-2 border-2 border-[#A3A3A3] text-xs md:text-base">Name</th>
                    <th class="w-2/5 p-1 md:px-4 md:py-2 border-2 border-[#A3A3A3] text-xs md:text-base">Email</th>
                    <th class="w-1/5 p-1 md:px-4 md:py-2 border-2 border-[#A3A3A3] text-xs md:text-base">Status</th>
                </tr>
            </thead>
            <tbody>';
                        foreach ($users as $user1) {
                            echo '
                <tr>
                    <td class="p-1 md:px-4 md:py-2 border-2 border-[#A3A3A3] text-xs md:text-base">' . $user1->getId() . '</td>
                    <td class="p-1 md:px-4 md:py-2 border-2 border-[#A3A3A3] text-xs md:text-base">' . $user1->getName() . '</td>
                    <td class="p-1 md:px-4 md:py-2 border-2 border-[#A3A3A3] text-xs md:text-base">' . $user1->getEmail() . '</td>
            ';
                            if ($user1->getIsVerified() == 1) { ?>
                                <td class="p-1 md:px-4 md:py-2 border-2 border-[#A3A3A3] text-xs md:text-base text-center">
                                    <form method="post" class="inline">
                                        <input type="hidden" name="isVerified" value="<?= $user1->getIsVerified() ?>">
                                        <input type="hidden" name="userId" value="<?= $user1->getId() ?>">
                                        <input type="submit" name="changeStatus" class="px-2 cursor-pointer rounded-md bg-green-500" value="Active">
                                    </form>
                                </td>
                            <?php  } else { ?>

                                <td class="p-1 md:px-4 md:py-2 border-2 border-[#A3A3A3] text-xs md:text-base text-center">
                                    <form method="post" class="inline">
                                        <input type="hidden" name="isVerified" value="<?= $user1->getIsVerified() ?>">
                                        <input type="hidden" name="userId" value="<?= $user1->getId() ?>">
                                        <input type="submit" name="changeStatus" class="px-2 cursor-pointer rounded-md bg-red-500" value="Disabled">
                                    </form>
                                </td>
                    <?php  }
                            echo '</tr>';
                        }
                        echo '
            </tbody>
        </table>
        
        ';
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

                                <a href="?page=<?php echo $_GET['page'] - 1 ?>">Previous</a>

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

<?php } else echo "You don't have permission";
exit;

?>