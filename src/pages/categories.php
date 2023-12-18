<?php
require_once '../includes/pages.php';
require_once '../includes/Category.php';
require_once '../includes/CategoryDAO.php';

if (isset($_SESSION['admin_name']) || isset($_SESSION['administrator_name'])) {
} else {
    header('location:' . $_SERVER['HTTP_REFERER']);
    exit;
}

$allPages = new Pages();
$category = new CategoryDAO();



if (isset($_POST['submit'])) {
    $categoryName = trim($_POST['category']);
    $category->getCategory()->setName($categoryName);
    $result = $category->categoryExists();
    if ($result > 0) {
        $msg[] = 'Category already exists';
    } else {
        $result = $category->addCategory();
        if ($result) {
            $msg2[] = 'Category added succsessfully';
        } else $msg[] = 'Unknown error';
    }
}

if (isset($_POST['edit'])) {
    $categoryId = $_POST['categoryId'];
    $categoryName = $_POST['category'];
    $category->getCategory()->setName($categoryName);
    $category->getCategory()->setId($categoryId);
    $result = $category->categoryExists();
    if ($result > 0) {
        $msg[] = 'Category already exists';
    } else {
        $result = $category->modifyCategory();
        if ($result) {
            $msg2[] = 'Category modified successfully';
        } else $msg2[] = 'Error while modifying the category';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include("../components/head.html") ?>
</head>

<body>
    <!-- Popup Structure -->
    <div id="popup" class="fixed w-full h-full top-0 left-0  items-center flex justify-center hidden z-50">
        <div class="bg-white w-full md:w-7/12 h-fit border-2 border-amber-600 flex flex-col justify-start items-center overflow-y-auto rounded-2xl md:h-fit">
            <div class="bg-amber-600 w-full md:w-7/12 h-8 fixed rounded-tr-2xl rounded-tl-2xl">
                <div class="flex justify-end">
                    <span onclick="closePopup()" class="text-2xl font-bold cursor-pointer mr-3">&times;</span>
                </div>
            </div>
            <form method="post" class="flex flex-col justify-between items-center h-full mt-[10vh]">
                <div class="flex flex-col mb-3">
                    <div class="flex flex-col border-2 border-[#A1A1A1] p-2 rounded-md">
                        <p class="text-xs">Category name</p>
                        <input required class="placeholder:font-light placeholder:text-xs focus:outline-none" id="categoryname" type="text" name="category" placeholder="Name" autocomplete="off">
                    </div>
                    <div id="categorynameERR" class="text-red-600 text-xs pl-3"></div>
                </div>
                <div class="flex justify-end mb-4">
                    <input required type="submit" name="submit" class="cursor-pointer px-8 py-2 bg-[#9fff30] font-semibold rounded-lg border-2 border-[#6da22f]" value="Add categorie">
                </div>
            </form>
        </div>
    </div>
    <!-- End of Popup -->
    <!-- Popup Structure -->
    <div id="popupEdit" class="fixed w-full h-full top-0 left-0  items-center flex justify-center hidden z-50">
        <div class="bg-white w-full md:w-7/12 h-fit border-2 border-amber-600 flex flex-col justify-start items-center overflow-y-auto rounded-2xl md:h-fit">
            <div class="bg-amber-600 w-full md:w-7/12 h-8 fixed rounded-tr-2xl rounded-tl-2xl">
                <div class="flex justify-end">
                    <span onclick="closePopup()" class="text-2xl font-bold cursor-pointer mr-3">&times;</span>
                </div>
            </div>
            <form method="post" class="flex flex-col justify-between items-center h-full mt-[10vh]">
                <div class="flex flex-col mb-3">
                    <div class="flex flex-col border-2 border-[#A1A1A1] p-2 rounded-md">
                        <p class="text-xs">Category name</p>
                        <input required class="placeholder:font-light placeholder:text-xs focus:outline-none" id="categoryname2" type="text" name="category" placeholder="Name" autocomplete="off" value="">
                        <input type="hidden" name="categoryId" id="categoryId" value="">
                    </div>
                    <div id="categorynameERR2" class="text-red-600 text-xs pl-3"></div>
                </div>
                <div class="flex justify-end mb-4">
                    <input required type="submit" name="edit" class="cursor-pointer px-8 py-2 bg-[#9fff30] font-semibold rounded-lg border-2 border-[#6da22f]" value="Apply changes">
                </div>
            </form>
        </div>
    </div>
    <!-- End of Popup -->
    <div class="flex flex-col justify-end items-start h-[100vh]">
        <div class="flex justify-between items-center w-full md:px-8">
            <p class="border-gray-300 rounded-t-lg p-2 pb-1 text-xl">Categories</p>
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
            <button onclick="openPopup()" class="p-1 text-sm md:text-base md:p-2 md:pb-1 bg-green-700 md:mb-2 rounded-md">Add Category +</button>
        </div>
        <div class="border-2 border-gray-300 rounded-xl w-full h-[90vh] flex">
            <div id="clients" class="flex flex-col justify-between w-full p-4">
                <?php
                $start = 0;
                $rows_per_page = 7;
                $result = $allPages->getPagesDetails($start, $rows_per_page, 'categories', '');
                $start = $allPages->getStart();
                $rows = $allPages->getRows();
                $pages = $allPages->getPages();
                if ($rows > 0) {
                    $categories = $category->getCategoriesPage($start, $rows_per_page);
                    echo ' 
        <table class="table-auto md:table-fixed w-full ">
            <thead class="border">
                <tr class="border-2">
                    <th class="w-1/5 p-1 md:px-4 md:py-2 border-2 border-[#A3A3A3] text-xs md:text-base">Id</th>
                    <th class="w-3/5 p-1 md:px-4 md:py-2 border-2 border-[#A3A3A3] text-xs md:text-base">Categorie</th>
                    <th class="w-1/5 p-1 md:px-4 md:py-2 border-2 border-[#A3A3A3] text-xs md:text-base">Action</th>
                </tr>
            </thead>
            <tbody>';
                    foreach ($categories as $category1) {
                ?>
                        <tr>
                            <td class="p-1 md:px-4 md:py-2 border-2 border-[#A3A3A3] text-xs md:text-base text-center"><?= $category1->getId() ?></td>
                            <td id="category<?= $category1->getId() ?>" class="p-1 md:px-4 md:py-2 border-2 border-[#A3A3A3] text-xs md:text-base text-center"><?= $category1->getName() ?></td>
                            <td class="p-1 md:px-4 md:py-2 border-2 border-[#A3A3A3] text-xs md:text-base text-center">
                                <button onclick="showDetails(<?= $category1->getId() ?>)" class="px-2 rounded-md bg-amber-500"> Modify </button>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                    </table>

                <?php
                } else {
                    echo 'No categories in database';
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
            </div>
        </div>
    </div>
    <script src="../js/popup.js"></script>
</body>

</html>