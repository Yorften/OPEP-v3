<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../includes/pages.php';
require_once '../includes/CategoryDAO.php';
require_once '../includes/PlantDAO.php';


$allPages = new Pages();
$category = new CategoryDAO();
$plant = new PlantDAO();

if (isset($_POST['submit']) && isset($_FILES['plantimg'])) {
    $name = $_FILES['plantimg']['name'];
    $size = $_FILES['plantimg']['size'];
    $tmp_name = $_FILES['plantimg']['tmp_name'];
    $error = $_FILES['plantimg']['error'];

    $plantName = trim($_POST['plant']);
    $plantDesc = $_POST['plantdesc'];
    $plantPrice = $_POST['plantprice'];
    $categoryId = $_POST['category'];


    if ($error === 0) {
        if ($size > 4200000) {
            $msg[] = 'Sorry your file is too large. (max 4mb)';
        } else {
            $img_ext = pathinfo($name, PATHINFO_EXTENSION);
            $img_ext_lc = strtolower($img_ext);

            $allowed_ext = array("jpg", "jpeg", "png", "webp", "avif");

            if (in_array($img_ext_lc, $allowed_ext)) {
                $new_img_name = uniqid("IMG-", true) . '.' . $img_ext_lc;
                $img_upload_path = '../images/Plants/' . $new_img_name;
                move_uploaded_file($tmp_name, $img_upload_path);

                $plant->getObject()->setName($plantName);
                $plant->getObject()->setDesc($plantDesc);
                $plant->getObject()->setPrice($plantPrice);
                $plant->getObject()->setImage($new_img_name);
                $plant->getObject()->setCategory($categoryId);

                $result = $plant->plantExists();
                echo $result;
            } else {
                $msg[] = 'Unsupported format. (jpg, jpeg, png, webp)';
            }
        }
    } else {
        $msg[] = 'Unkown error occured';
    }
    if (isset($result)) {
        if ($result > 0) {
            $msg[] = 'Plant already exists';
        } else {
            $result = $plant->addPlant($plant->getObject());
            if ($result) {
                $msg2[] = 'Plant added succsessfully';
            } else $msg[] = 'Unknown error';
        }
    }
}

if (isset($_POST['edit']) && isset($_FILES['plantimg'])) {
    $plantId = $_POST['plantId'];
    $plantName = trim($_POST['plant']);
    $plantDesc = $_POST['plantdesc'];
    $plantPrice = $_POST['plantprice'];
    $categoryId = $_POST['category'];

    $name = $_FILES['plantimg']['name'];
    $size = $_FILES['plantimg']['size'];
    $tmp_name = $_FILES['plantimg']['tmp_name'];
    $error = $_FILES['plantimg']['error'];


    if ($name == null) {
        $result = $plant->plantExistsModify();
        if ($result > 0) {
            $msg[] = 'Plant already exists';
        } else {
            $plant->getObject()->setId($plantId);
            $plant->getObject()->setName($plantName);
            $plant->getObject()->setDesc($plantDesc);
            $plant->getObject()->setPrice($plantPrice);
            $plant->getObject()->setCategory($categoryId);
            $result = $plant->modifyPlant($plant->getObject());
            if ($result) {
                $msg2[] = 'Plant modified succsessfully';
            } else $msg[] = 'Unknown error';
        }
    } else {
        if ($error === 0) {
            if ($size > 4200000) {
                $msg[] = 'Sorry your file is too large. (max 4mb)';
            } else {
                $img_ext = pathinfo($name, PATHINFO_EXTENSION);
                $img_ext_lc = strtolower($img_ext);

                $allowed_ext = array("jpg", "jpeg", "png", "webp", "avif");

                if (in_array($img_ext_lc, $allowed_ext)) {
                    $new_img_name = uniqid("IMG-", true) . '.' . $img_ext_lc;
                    $img_upload_path = '../images/Plants/' . $new_img_name;
                    move_uploaded_file($tmp_name, $img_upload_path);

                    $plant->getObject()->setId($plantId);
                    $plant->getObject()->setName($plantName);
                    $plant->getObject()->setDesc($plantDesc);
                    $plant->getObject()->setPrice($plantPrice);
                    $plant->getObject()->setCategory($categoryId);
                    $plant->getObject()->setImage($new_img_name);

                    $result = $plant->plantExistsModify();
                } else {
                    $msg[] = 'Unsupported format. (jpg, jpeg, png, webp)';
                }
            }
        } else {
            $msg[] = 'Unkown error occured';
        }
        if (isset($result)) {
            if ($result > 0) {
                $msg[] = 'Plant already exists';
            } else {
                $result = $plant->modifyPlantImage($plant->getObject());
                if ($result) {
                    $msg2[] = 'Plant modified succsessfully';
                } else $msg[] = 'Unknown error';
            }
        }
    }
}

if (isset($_POST['delete'])) {
    $plantId = $_POST['plantId'];
    $plant->getObject()->setId($plantId);
    $result = $plant->deletePlant();
    if ($result) {
        $msg2[] = 'Plant deleted succsessfully';
    } else $msg[] = 'Unknown error';
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
            <form method="post" onsubmit="return validateForm()" enctype="multipart/form-data" class="flex flex-col justify-between items-center w-full h-full mt-[10vh]">
                <div class="flex flex-col mb-3 w-11/12 md:w-4/6">
                    <div id="plantInput" class="flex flex-col border-2 border-[#A1A1A1] p-2 rounded-md">
                        <p class="text-xs">Plant name</p>
                        <input class="placeholder:font-light placeholder:text-xs focus:outline-none" id="plant" type="text" name="plant" placeholder="Name" autocomplete="off">
                    </div>
                    <div id="plantErr" class="text-red-600 text-center md:text-left text-xs pl-3"></div>
                </div>
                <div class="flex flex-col mb-3 w-11/12 md:w-4/6">
                    <div id="plantdescInput" class="flex flex-col border-2 border-[#A1A1A1] p-2 rounded-md">
                        <p class="text-xs">Plant description</p>
                        <textarea name="plantdesc" id="plantdesc" cols="10" rows="3" class=" resize-none p-1"></textarea>
                    </div>
                    <div id="plantdescErr" class="text-red-600 text-center md:text-left text-xs pl-3"></div>
                </div>
                <div class="flex flex-col mb-3 w-11/12 md:w-4/6">
                    <div id="plantpriceInput" class="flex flex-col border-2 border-[#A1A1A1] p-2 rounded-md">
                        <p class="text-xs">Plant price</p>
                        <input class="placeholder:font-light placeholder:text-xs focus:outline-none" id="plantprice" type="text" name="plantprice" placeholder="Price" autocomplete="off" title="Please enter numbers only">
                    </div>
                    <div id="plantpriceErr" class="text-red-600 text-center md:text-left text-xs pl-3"></div>
                </div>
                <div class="flex flex-col gap-3 mb-3 w-11/12 md:w-4/6 md:flex-row">
                    <div class="flex flex-col md:w-1/2">
                        <div id="plantimgInput" class="flex flex-col border-2 border-[#A1A1A1] p-2 rounded-md">
                            <p class="text-xs">Plant image</p>
                            <input class="placeholder:font-light placeholder:text-xs focus:outline-none" id="plantimg" type="file" name="plantimg" autocomplete="off">
                        </div>
                        <div id="plantimgErr" class="text-red-600 text-xs text-center md:text-left pl-3"></div>
                    </div>
                    <div class="flex flex-col md:w-1/2">
                        <div id="categoryInput" class="flex flex-col border-2 border-[#A1A1A1] p-2 rounded-md md:h-[63.9px]">
                            <p class="text-xs">Plant category</p>
                            <select class="block leading-5 text-gray-700 bg-white border-transparent rounded-md focus:outline-none focus:ring focus:ring-blue-300 focus:border-blue-300" id="category" name="category" autocomplete="off">
                                <option value="" hidden disabled selected>Select...</option>
                                <?php
                                $result = $category->getCategories();
                                if (count($result) > 0) {
                                    foreach ($result as $category1) {

                                ?>
                                        <option value="<?= $category1->getId() ?>"><?= $category1->getName()  ?></option>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <option value="">No category exists</option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div id="categoryErr" class="text-red-600 text-xs text-center md:text-left pl-3"></div>
                    </div>
                </div>

                <div class="flex justify-end mb-4">
                    <input type="submit" name="submit" class="cursor-pointer px-8 py-2 bg-[#9fff30] font-semibold rounded-lg border-2 border-[#6da22f]" value="Add plant">
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
            <form method="post" onsubmit="return validateFormEdit()" enctype="multipart/form-data" class="flex flex-col justify-between items-center w-full h-full mt-[10vh]">
                <div class="flex flex-col mb-3 w-11/12 md:w-4/6">
                    <div id="plantInput2" class="flex flex-col border-2 border-[#A1A1A1] p-2 rounded-md">
                        <p class="text-xs">Plant name</p>
                        <input class="placeholder:font-light placeholder:text-xs focus:outline-none" id="plant2" type="text" name="plant" placeholder="Name" autocomplete="off">
                    </div>
                    <div id="plantErr2" class="text-red-600 text-xs text-center md:text-left pl-3"></div>
                </div>
                <div class="flex flex-col mb-3 w-11/12 md:w-4/6">
                    <div id="plantdescInput2" class="flex flex-col border-2 border-[#A1A1A1] p-2 rounded-md">
                        <p class="text-xs">Plant description</p>
                        <textarea name="plantdesc" id="plantdesc2" cols="10" rows="3" class=" resize-none p-1"></textarea>

                    </div>
                    <div id="plantdescErr2" class="text-red-600 text-xs text-center md:text-left pl-3"></div>
                </div>
                <div class="flex flex-col mb-3 w-11/12 md:w-4/6">
                    <div id="plantpriceInput2" class="flex flex-col border-2 border-[#A1A1A1] p-2 rounded-md">
                        <p class="text-xs">Plant price</p>
                        <input class="placeholder:font-light placeholder:text-xs focus:outline-none" id="plantprice2" type="text" name="plantprice" placeholder="Price" autocomplete="off" title="Please enter numbers only">
                    </div>
                    <div id="plantpriceErr2" class="text-red-600 text-xs text-center md:text-left pl-3"></div>
                </div>
                <div class="flex flex-col gap-3 mb-3 w-11/12 md:w-4/6 md:flex-row">
                    <div class="flex flex-col md:w-1/2">
                        <div class="flex flex-col border-2 border-[#A1A1A1] p-2 rounded-md">
                            <p class="text-xs">Plant image</p>
                            <input class="placeholder:font-light placeholder:text-xs focus:outline-none" id="plantimg2" type="file" name="plantimg" autocomplete="off">
                        </div>
                    </div>
                    <div class="flex flex-col md:w-1/2">
                        <div id="categoryInput2" class="flex flex-col border-2 border-[#A1A1A1] p-2 rounded-md md:h-[63.9px]">
                            <p class="text-xs">Plant category</p>
                            <select class="block leading-5 text-gray-700 bg-white border-transparent rounded-md focus:outline-none focus:ring focus:ring-blue-300 focus:border-blue-300" id="category2" name="category" autocomplete="off">
                                <option value="" hidden disabled selected>Select...</option>
                                <?php
                                $result = $category->getCategories();
                                if (count($result) > 0) {
                                    foreach ($result as $category1) {
                                ?>
                                        <option value="<?= $category1->getId() ?>"><?= $category1->getName()  ?></option>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <option value="">No category exists</option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div id="categoryErr2" class="text-red-600 text-xs text-center md:text-left pl-3"></div>
                    </div>
                </div>
                <input type="hidden" value="" id="plantId" name="plantId">
                <div class="flex justify-end mb-4">
                    <input type="submit" name="edit" class="cursor-pointer px-8 py-2 bg-[#9fff30] font-semibold rounded-lg border-2 border-[#6da22f]" value="Apply changes">
                </div>
            </form>
        </div>
    </div>
    <!-- End of Popup -->
    <div class="flex flex-col justify-end items-start h-[100vh]">
        <div class="flex justify-between items-center w-full md:px-8">
            <p class="border-gray-300 rounded-t-lg p-2 pb-1 text-xl">Plants</p>
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
            <button onclick="openPopup()" class="p-2 pb-1 bg-green-700 mb-2 rounded-md">Add Plant +</button>
        </div>
        <div class="border-2 border-gray-300 rounded-xl h-[90vh] flex">
            <div id="clients" class="flex flex-col justify-between w-full p-4 overflow-x-scroll">
                <?php
                $start = 0;
                $rows_per_page = 5;
                $result = $allPages->getPagesDetails($start, $rows_per_page, 'plants', '');
                $start = $allPages->getStart();
                $rows = $allPages->getRows();
                $pages = $allPages->getPages();

                if ($rows > 0) {
                    $plants = $plant->getPlantsPage($start, $rows_per_page);
                    echo ' 
        <table class="table-auto md:table-fixed w-full ">
            <thead class="border">
                <tr class="border-2">
                    <th class="w-[20%] p-1 md:px-4 md:py-2 border-2 border-[#A3A3A3] text-xs md:text-base">Plant</th>
                    <th class="w-[14%] p-1 md:px-4 md:py-2 border-2 border-[#A3A3A3] text-xs md:text-base">Category</th>
                    <th class="w-[40%] p-1 md:px-4 md:py-2 border-2 border-[#A3A3A3] text-xs md:text-base">Description</th>
                    <th class="w-[8%] p-1 md:px-4 md:py-2 border-2 border-[#A3A3A3] text-xs md:text-base">Price</th>
                    <th class="w-[20%] p-1 md:px-4 md:py-2 border-2 border-[#A3A3A3] text-xs md:text-base">Action</th>
                </tr>
            </thead>
            <tbody>';
                    foreach ($plants as $plant1) {
                ?>
                        <tr>
                            <td id="plantName<?= $plant1->getId() ?>" class="p-1 md:px-4 md:py-2 border-2 border-[#A3A3A3] text-xs md:text-base text-center"><?= $plant1->getName() ?></td>
                            <td id="plantCategory<?= $plant1->getId() ?>" class="p-1 md:px-4 md:py-2 border-2 border-[#A3A3A3] text-xs md:text-base text-center"><?= $plant1->getCategory() ?></td>
                            <td id="plantDesc<?= $plant1->getId() ?>" class="p-1 md:px-4 md:py-2 border-2 border-[#A3A3A3] text-xs md:text-base text-center"><?= $plant1->getDesc() ?></td>
                            <td id="plantPrice<?= $plant1->getId() ?>" class="p-1 md:px-4 md:py-2 border-2 border-[#A3A3A3] text-xs md:text-base text-center"><?= $plant1->getPrice() ?></td>
                            <td class="p-1 md:px-4 md:py-2 border-2 border-[#A3A3A3] text-xs md:text-base text-center">
                                <button onclick="showPlantDetails(<?= $plant1->getId() ?>)" class="px-2 mb-2 rounded-md bg-amber-500 md:mb-0"> Modify </button>
                                <form method="post" class="inline">
                                    <input type="hidden" name="plantId" value="<?= $plant1->getId() ?>">
                                    <input type="submit" name="delete" class="px-2 cursor-pointer rounded-md bg-red-500" value="Delete">
                                </form>
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
    <script src="../js/regex_plants.js"></script>
</body>

</html>