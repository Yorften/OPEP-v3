 <?php
    $Cart = new CartDAO();

    if (isset($_SESSION['client_name'])) {
        if (isset($_SESSION['client_name'])) {
            $cartId = $_SESSION['client_cart'];
            $notselected = 0;
            $commanded = 0;
            $selected = 1;
            $totalPrice = 0;
            $totalPrice2 = 0;

            $Cart->getCart()->setId($cartId);
            $Cart->getCart()->setIsCommanded($commanded);
            $Cart->getCart()->setIsSelected($notselected);

            $rows = $Cart->getCartRows($Cart->getCart());
            $Items = $Cart->getCartItems($Cart->getCart());

            if (isset($_POST['removeItem'])) {
                $Cart->getCart()->getPlant()->setId($_POST['plantId']);
                $Cart->getCart()->setId($cartId);

                $Cart->removeItem($Cart->getCart());
            }
            if (isset($_POST['removeItems'])) {
                $Cart->getCart()->setId($cartId);

                $Cart->removeItems($Cart->getCart());
            }
        }
    }
    ?>

 <nav class="bg-[#bdff72] h-[7.5vh] flex justify-between items-center px-2 md:px-4">
     <div class="block w-1/3 sm:w-1/4 md:w-1/12">
         <a href="../../index.php">
             <p class="text-black text-3xl">OPEP</p>
         </a>
     </div>
     <ul class="font-poppins text-black text-sm list-none [&>*]:inline-block [&>*]:mr-3 hidden md:block">
         <?php if (isset($_SESSION['admin_name'])) : ?>
             <li>
                 <a href="dashboard.php" class="p-2 bg-neutral-600/30 rounded-xl">
                     <span>DASHBOARD</span>
                 </a>
             </li>
             <li>
                 <a href="../blog/themes.php">
                     <span>BLOG</span>
                 </a>
             </li>
         <?php elseif (isset($_SESSION['administrator_name'])) : ?>
             <li>
                 <a href="controlpanel.php" class="p-2 bg-neutral-600/30 rounded-xl">
                     <span>CONTROL PANEL</span>
                 </a>
             </li>
             <li>
                 <a href="../blog/themes.php">
                     <span>BLOG</span>
                 </a>
             </li>
         <?php else : ?>
             <li>
                 <a href="../../index.php">
                     <span>HOME</span>
                 </a>
             </li>
             <li>
                 <a href="catalog.php">
                     <span>CATALOG</span>
                 </a>
             </li>
             <li>
                 <a href="about.php">
                     <span>ABOUT US</span>
                 </a>
             </li>
             <li>
                 <a href="../blog/themes.php">
                     <span>BLOG</span>
                 </a>
             </li>
         <?php endif  ?>
     </ul>


     <div class="flex items-center justify-end gap-2">

         <div class="flex items-center">
             <div class="dropdown">

                 <div class="flex items-center justify-center gap-6">
                     <?php if (!isset($_SESSION['client_name']) && !isset($_SESSION['admin_name']) && !isset($_SESSION['administrator_name'])) : ?>
                         <div class="child:text-black hidden md:block">
                             <a href="login.php" class="border-r border-black pr-2 mr-1"> Log in</a>
                             <a href="signup.php"> Sign up</a>
                         </div>
                     <?php else : ?>
                         <?php if (isset($_SESSION['client_name'])) : ?>
                             <div class="child:text-black hidden md:block">
                                 <a class="border-r border-black pr-[3px] mr-1"><?= $_SESSION['client_name']; ?> </a>
                                 <a href="../includes/logout.php">Log out</a>
                             </div>
                         <?php elseif (isset($_SESSION['admin_name'])) : ?>
                             <div class="child:text-black hidden md:block">
                                 <a class="border-r border-black pr-[3px] mr-1"><?= $_SESSION['client_name']; ?> </a>
                                 <a href="../includes/logout.php">Log out</a>
                             </div>
                         <?php else : ?>
                             <div class="child:text-black hidden md:block">
                                 <a class="border-r border-black pr-[3px] mr-1"><?= $_SESSION['administrator_name']; ?> </a>
                                 <a href="../includes/logout.php">Log out</a>
                             </div>
                         <?php endif ?>
                     <?php endif ?>
                     <?php if (!isset($_SESSION['client_name'])) { ?>
                     <?php } else { ?>
                         <p id="basket-rows" class="bg-amber-400 rounded-3xl w-5 h-5 text-center absolute top-2 right-[55px] sm:block sm:right-[55px] md:right-[17px] md:block">
                             <?= $rows ?>
                         </p>
                         <img onclick="openPopup()" class="open-btn dropbtn color-black cursor-pointer w-9  h-9 object-contain sm:block sm:mr-1  " src="../images/cart.png" alt="" />
                     <?php } ?>
                 </div>
             </div>
             <div id="burgermenu" onclick="toggleBurgerMenu()" class="md:hidden md:mx-2 cursor-pointer mr-3 ml-3">
                 <span class="block w-6 h-1 my-1 mx-auto bg-white transition-all ease-in-out"></span>
                 <span class="block w-6 h-1 my-1 mx-auto bg-white transition-all ease-in-out"></span>
                 <span class="block w-6 h-1 my-1 mx-auto bg-white transition-all ease-in-out"></span>
             </div>

         </div>
     </div>
 </nav>
 <div id="popup" class="popup w-full md:w-[30%] overflow-y-auto">
     <!-- Content -->
     <div class="flex flex-col gap-1">
         <div class="fixed w-full md:w-7/12 h-8 bg-[#19911D]">
             <div class="flex justify-between h-3 pl-5 pt-2 ">
                 <div onclick="closePopup()" class="text-2xl font-bold cursor-pointer mr-3">
                     <img class="h-12 object-contain" src="../images/next button.svg" alt="">
                 </div>
             </div>
         </div>
         <div class="p-3 mt-6">
             <?php
                if ($rows > 0) {
                ?>
                 <p class="text-center text-lg font-medium mb-3">Your Items</p>
                 <?php
                    foreach ($Items as $item1) {
                        $plantId = $item1->getPlant()->getId();
                        $plantName = $item1->getPlant()->getName();
                        $plantImage = $item1->getPlant()->getImage();
                        $plantPrice = $item1->getPlant()->getPrice();
                        $quantity = $item1->getQuantity();
                    ?>
                     <div class="flex flex-col relative border-2 border-gray-400 w-full h-[140px] rounded-md mb-2">
                         <div class="flex items-center justify-end w-full bg-[#19911D] h-4 rounded-tl-[4px] rounded-tr-[4px]">
                         </div>
                         <div class="flex flex-col gap-2 md:flex-row items-center justify-between">
                             <img class="object-contain h-[124px]" src="../images/Plants/<?= $plantImage ?>" alt="">
                             <div class="flex flex-col justify-center items-start gap-2">
                                 <p><?= $plantName ?></p>
                                 <p>Quantity: <?= $quantity ?></p>
                                 <div class="flex gap-1 items-center">
                                     <p>Price: <?= $plantPrice ?> DH</p>
                                     <p class=" text-xs">per unit</p>
                                 </div>
                             </div>
                             <div class="flex flex-col justify-end h-full gap-2 pr-2 pb-2">
                                 <form method="POST">
                                     <input type="hidden" name="plantId" value="<?= $plantId ?>">
                                     <input type="submit" name="removeItem" class="p-1 bg-red-500 border border-black rounded-lg cursor-pointer hover:bg-red-400" value="Remove">
                                 </form>
                             </div>
                         </div>
                     </div>
                 <?php
                    }
                } else {
                    ?>
                 <div class="flex flex-col items-center justify-center h-[90vh] text-xl font-medium">
                     <p>No items in your cart</p>

                 </div>
             <?php
                }

                ?>

         </div>
         <div class="fixed w-full md:w-[30%] h-14 bottom-0 p-1 bg-white">
             <div class="flex justify-evenly">
                 <?php if ($rows > 0) { ?>
                     <a class="border border-black bg-[#19911D] font-semibold p-1 hover:bg-[#5edb64] rounded-md" href="../pages/checkout.php">Checkout</a>
                     <form method="POST">
                         <input type="submit" name="removeItems" class="border border-black bg-[#19911D] font-semibold p-1 hover:bg-[#5edb64] rounded-md cursor-pointer" value="Empty cart">
                     </form>
                 <?php } else { ?>
                     <a class="border border-black bg-[#19911D] font-semibold py-1 px-4 hover:bg-[#5edb64] rounded-md" href="../pages/checkout.php">Checkout</a>
                 <?php  } ?>
             </div>
         </div>
     </div>
 </div>
 <div id="displaymenu" class="flex flex-col border-2 border-t-0 shadow-xl items-center justify-center burger-content w-full py-6 hidden md:hidden z-50">
     <div class="flex flex-col items-center divide-y-2 gap-6 w-full divide-black">
         <?php if (!isset($_SESSION['client_name']) && !isset($_SESSION['admin_name']) && !isset($_SESSION['administrator_name'])) : ?>
             <div class="w-full flex justify-evenly items-center child:text-black child:text-xl child:font-semibold">
                 <a href="login.php"> Log in</a>
                 <a href="signup.php"> Sign up</a>
             </div>
         <?php else : ?>
             <?php if (isset($_SESSION['client_name'])) : ?>
                 <div class="flex justify-around items-center w-full child:text-black child:text-xl">
                     <p><?= $_SESSION['client_name']; ?> </p>
                     <a href="../includes/logout.php">Log out</a>
                 </div>

             <?php elseif (isset($_SESSION['admin_name'])) : ?>
                 <div class="flex justify-around items-center w-full child:text-black child:text-lg">
                     <p><?= $_SESSION['admin_name']; ?> </p>
                     <a href="../includes/logout.php">Log out</a>
                 </div>
             <?php else : ?>
                 <div class="flex justify-around items-center w-full child:text-black child:text-lg">
                     <p><?= $_SESSION['administrator_name']; ?> </p>
                     <a href="../includes/logout.php">Log out</a>
                 </div>
             <?php endif ?>
         <?php endif ?>
         <?php if (isset($_SESSION['administrator_name'])) : ?>
             <div class="pt-6 text-xl font-semibold w-[90%] flex justify-center">
                 <a href="../pages/controlpanel.php">
                     <span>CONTROLPANEL</span>
                 </a>
             </div>
             <div class="pt-6 text-xl font-semibold w-[90%] flex justify-center">
                 <a href="../blog/themes.php">
                     <span>BLOG</span>
                 </a>
             </div>
         <?php elseif (isset($_SESSION['admin_name'])) : ?>
             <div class="pt-6 text-xl font-semibold w-[90%] flex justify-center">
                 <a href="../pages/dashboard.php">
                     <span>DASHBOARD</span>
                 </a>
             </div>
             <div class="pt-6 text-xl font-semibold w-[90%] flex justify-center">
                 <a href="../blog/themes.php">
                     <span>BLOG</span>
                 </a>
             </div>
         <?php else : ?>
             <div class="pt-6 text-xl font-semibold w-[90%] flex justify-center">
                 <a href="../../index.php">
                     <span>HOME</span>
                 </a>
             </div>
             <div class="pt-6 text-xl font-semibold w-[90%] flex justify-center">
                 <a href="catalog.php">
                     <span>CATALOG</span>
                 </a>
             </div>
             <div class="pt-6 text-xl font-semibold w-[90%] flex justify-center">
                 <a href="about.php">
                     <span>ABOUT US</span>
                 </a>
             </div>
             <div class="pt-6 text-xl font-semibold w-[90%] flex justify-center">
                 <a href="../blog/themes.php">
                     <span>BLOG</span>
                 </a>
             </div>
         <?php endif  ?>
     </div>
 </div>