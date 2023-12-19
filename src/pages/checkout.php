<?php

require_once '../includes/CartDAO.php';
require_once '../includes/CommandDAO.php';

if (!isset($_SESSION['client_name'])) {
    echo "You don't have permission";
    exit;
}

$Cart = new CartDAO();
$Command = new CommandDAO();
$cartId = $_SESSION['client_cart'];

if (isset($_POST['increaseItem'])) {
    $Cart->getCart()->getPlant()->setId($_POST['plantId']);
    $Cart->getCart()->setCartId($cartId);
    $Cart->getCart()->setQuantity($_POST['quantity']);

    $Cart->incrementQuantity($Cart->getCart());
}

if (isset($_POST['reduceItem'])) {
    $Cart->getCart()->getPlant()->setId($_POST['plantId']);
    $Cart->getCart()->setCartId($cartId);
    $Cart->getCart()->setQuantity($_POST['quantity']);

    $Cart->reduceQuantity($Cart->getCart());
}

if (isset($_POST['selected'])) {

    $Cart->getCart()->getPlant()->setId($_POST['plantId']);
    $Cart->getCart()->setCartId($cartId);
    $Cart->getCart()->setIsSelected($_POST['isSelected']);

    $Cart->toggleSelected($Cart->getCart());
}

if (isset($_POST['checkoutAll'])) {
    $isSelected = 0;
    $date = date("Y-m-d H:i:s");
    $totalPrice = $_POST['totalPrice'];
    $Command->getCommand()->getCart()->setId($cartId);
    $Command->getCommand()->setDate($date);
    $Command->getCommand()->setTotal($totalPrice);

    $result = $Command->checkoutItems($Command->getCommand());


    $Cart->getCart()->setIsSelected($isSelected);
    $Cart->getCart()->setIsCommanded($result);
    $Cart->getCart()->setId($cartId);

    $Cart->updateCheckedItems($Cart->getCart());
}

if (isset($_POST['checkoutSelected'])) {
    $isSelected = 1;
    $date = date("Y-m-d H:i:s");
    $totalPrice = $_POST['totalPrice'];
    $Command->getCommand()->getCart()->setId($cartId);
    $Command->getCommand()->setDate($date);
    $Command->getCommand()->setTotal($totalPrice);

    $result = $Command->checkoutItems($Command->getCommand());
   

    $Cart->getCart()->setIsSelected($isSelected);
    $Cart->getCart()->setIsCommanded($result);
    $Cart->getCart()->setId($cartId);

    $Cart->updateCheckedItems($Cart->getCart());
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include("../components/head.html") ?>
    <title>Checkout | O'PEP</title>
</head>

<body>

    <?php include("../components/nav.php");


    ?>
    <div class="flex justify-evenly mx-auto mt-6 mb-[15.5vh]">
        <div class="flex flex-col gap-1 h-full border-2 border-gray-400 rounded-md p-3 w-[40%]">
            <p class="text-center text-lg font-medium">Your Items</p>
            <?php if ($rows === 0) { ?>
                <div class="flex flex-col relative border-2 border-gray-400 md:h-[140px] rounded-md mb-2">
                    <div class="flex gap-2 flex-col items-center justify-center h-full md:flex-row">
                        <p>No items in cart</p>
                    </div>
                </div>
                <?php  } else {
                foreach ($Items as $item1) {
                    $plantId = $item1->getPlant()->getId();
                    $plantName = $item1->getPlant()->getName();
                    $plantImage = $item1->getPlant()->getImage();
                    $plantPrice = $item1->getPlant()->getPrice();
                    $quantity = $item1->getQuantity();
                    $isSelected = $item1->getIsSelected();
                    $plant_cartId = $item1->getPlant_CartId();
                    $plantPrice = $plantPrice * $quantity;
                    $totalPrice = $totalPrice + $plantPrice ?>
                    <div class="flex flex-col relative border-2 border-gray-400 w-full h-[140px] rounded-md mb-2">
                        <div class="flex items-center justify-end w-full bg-[#19911D] h-4 rounded-tl-[4px] rounded-tr-[4px]">
                        </div>
                        <div class="flex gap-2 flex-col items-center justify-between md:flex-row">
                            <img class="object-contain h-[124px]" src="../images/Plants/<?= $plantImage ?>" alt="">
                            <div class="flex flex-col justify-center items-start w-2/5 h-full gap-1 py-4 child:text-lg">
                                <p><?= $plantName ?></p>
                                <p>Price: <?= $plantPrice ?> DH</p>
                            </div>
                            <div class="flex flex-col justify-center items-center">
                                <p>Quantity: <?= $quantity ?></p>
                                <div class="flex justify-between items-center w-full gap-1">
                                    <?php if ($quantity === 1) { ?>
                                        <p class="p-1 text-center font-bold text-xl w-[35px] select-none h-[35px] border-2 border-black rounded-lg">-</p>
                                    <?php } else { ?>
                                        <form method="POST">
                                            <input type="hidden" name="plantId" value="<?= $plantId ?>">
                                            <input type="hidden" name="quantity" value="<?= $quantity ?>">
                                            <button type="submit" name="reduceItem" class="cursor-pointer p-1 text-center font-bold text-xl w-[35px] hover:bg-amber-400 h-[35px] select-none border-2 border-black rounded-lg">-</button>
                                        </form>
                                    <?php } ?>
                                    <form method="POST">
                                        <input type="hidden" name="plantId" value="<?= $plantId ?>">
                                        <input type="hidden" name="quantity" value="<?= $quantity ?>">
                                        <button type="submit" name="increaseItem" class="cursor-pointer p-1 text-center font-bold text-xl w-[35px] hover:bg-amber-400 h-[35px] select-none border-2 border-black rounded-lg">+</button>
                                    </form>
                                </div>
                            </div>
                            <div class="flex flex-col justify-between items-end h-full gap-2 pr-2 py-2">
                                <form method="POST" class="flex flex-col justify-between items-end h-full gap-2 pr-2 py-2">
                                    <input type="hidden" name="isSelected" value="<?= $isSelected ?>">
                                    <input type="hidden" name="plantId" value="<?= $plantId ?>">
                                    <button type="submit" name="selected" class="cursor-pointer p-1 text-center font-bold text-xl w-[40px] border-2 border-black rounded-lg hover:bg-amber-400">></button>
                                    <button type="submit" name="removeItem" class="cursor-pointer p-1 bg-red-500 border border-black rounded-lg hover:bg-red-400">Remove</button>
                                </form>
                            </div>
                        </div>

                    </div>
                <?php }
            }
            if ($totalPrice > 0) { ?>
                <div class="flex items-end justify-between w-full gap-2 pr-1 pt-3">
                    <p class="text-lg">Total: <?= $totalPrice ?> DH</p>
                    <form method="POST">
                        <input type="hidden" name="totalPrice" value="<?= $totalPrice ?>">
                        <button type="submit" name="checkoutAll" class="cursor-pointer p-1 bg-[#bdff72] hover:bg-[#99eb3b] border border-black rounded-lg">Checkout All</button>
                    </form>
                </div>
            <?php } else { ?>
                <div class="flex items-end justify-between w-full gap-2 pr-1 pt-3">
                </div>
            <?php } ?>
        </div>
        <!-- Wanted Items -->
        <div class="flex flex-col gap-1 h-full border-2 border-gray-400 rounded-md p-3">
            <p class="text-center text-lg font-medium">Selected Items</p>
            <?php
            $Cart->getCart()->setIsCommanded($commanded);
            $Cart->getCart()->setCartId($cartId);
            $Cart->getCart()->setIsSelected($selected);

            $rows2 = $Cart->getCartRows($Cart->getCart());
            $Items2 = $Cart->getCartItems($Cart->getCart());

            if ($rows2 === 0) { ?>
                <div class="flex flex-col relative border-2 border-gray-400 md:h-[140px] md:w-[371px] rounded-md mb-2">
                    <div class="flex gap-2 flex-col items-center justify-center h-full md:flex-row">
                        <p>No items to checkout</p>
                    </div>
                </div>
                <?php  } else {
                foreach ($Items2 as $item2) {
                    $plantId = $item2->getPlant()->getId();
                    $plantName = $item2->getPlant()->getName();
                    $plantImage = $item2->getPlant()->getImage();
                    $plantPrice = $item2->getPlant()->getPrice();
                    $quantity = $item2->getQuantity();
                    $isSelected = $item2->getIsSelected();
                    $plant_cartId = $item1->getPlant_CartId();
                    $plantPrice = $plantPrice * $quantity;
                    $totalPrice2 = $totalPrice2 + $plantPrice ?>
                    <div class="flex flex-col relative border-2 border-gray-400 w-full h-[140px] rounded-md mb-2">
                        <div class="flex items-center justify-end w-full bg-[#19911D] h-4 rounded-tl-[4px] rounded-tr-[4px]">
                        </div>
                        <div class="flex gap-2 flex-col items-center justify-between md:flex-row">
                            <img class="object-contain h-[124px]" src="../images/Plants/<?= $plantImage ?>" alt="">
                            <div class="flex flex-col justify-center items-start gap-2">
                                <p><?= $plantName ?></p>
                                <p>Quantity: <?= $quantity ?></p>
                                <p>Price: <?= $plantPrice ?> DH</p>
                                </p>
                            </div>
                            <div class="flex flex-col justify-between items-end h-full gap-2 pr-2 py-2">
                                <form method="POST" class="flex flex-col justify-between items-end h-full gap-2 pr-2 py-2">
                                    <input type="hidden" name="isSelected" value="<?= $isSelected ?>">
                                    <input type="hidden" name="plantId" value="<?= $plantId ?>">
                                    <button type="submit" name="selected" class="cursor-pointer p-1 text-center font-bold text-xl w-[40px] border-2 border-black rounded-lg hover:bg-amber-400">
                                        < </button>
                                            <button type="submit" name="removeItem" class="cursor-pointer p-1 bg-red-500 border border-black rounded-lg hover:bg-red-400">Remove</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php }
            }
            if ($totalPrice2 > 0) { ?>
                <div class="flex items-end justify-between w-full gap-2 pr-1 pt-3">
                    <p class="text-lg">Total: <?= $totalPrice2 ?> DH</p>
                    <form method="POST">
                        <input type="hidden" name="totalPrice" value="<?= $totalPrice2 ?>">
                        <button type="submit" name="checkoutSelected" class="cursor-pointer p-1 bg-[#bdff72] hover:bg-[#99eb3b] border border-black rounded-lg">Checkout Selected</button>
                    </form>
                </div>
            <?php } else { ?>
                <div class="flex items-end justify-end w-full gap-2 pr-1 pt-3">
                </div>
            <?php } ?>
        </div>
    </div>


    <?php include("../components/footer.html") ?>

    <script src="../js/burger.js"></script>
    <script src="../js/filter.js"></script>
    <script src="../js/cartmenu.js"></script>
</body>

</html>