<?php
require_once '../includes/CartDAO.php';
require_once '../includes/authentification.php';

$login = new Login();

if (isset($_SESSION['client_name'])) {
    header('location:../../index.php');
    exit;
} elseif (isset($_SESSION['admin_name'])) {
    header('location:dashboard.php');
    exit;
} elseif (isset($_SESSION['administrator_name'])) {
    header('location:controlpanel.php');
    exit;
}

if (isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = trim($_POST['password']);

    $result = $login->login($email, $password);
    switch ($result) {
        case 200:
            if ($login->isVerified == 1) {
                switch ($login->roleId) {
                    case 1:
                        $_SESSION['client_cart'] = $login->cartId;
                        $_SESSION['client_name'] = $login->userName;
                        $_SESSION['userId'] = $login->userId;
                        header('location:../../index.php');
                        exit;
                        break;
                    case 2:
                        $_SESSION['userId'] =  $login->userId;
                        $_SESSION['admin_name'] = $login->userName;
                        header('location:dashboard.php');
                        exit;
                        break;
                    case 3:
                        $_SESSION['userId'] = $userId;
                        $_SESSION['administrator_name'] = $login->userName;
                        header('location:controlpanel.php');
                        exit;
                        break;

                    default:
                        $_SESSION['userId'] = $login->userId;
                        header('location:role.php?id=' . $_SESSION['userId'].'&name='.$login->userName);
                        exit;
                        break;
                }
            } else $msg[] = "Your account is locked, please contact support";
            break;
        case 403:
            $msg[] = 'Incorrect email or password';
            break;
        case 404:
            $msg[] = 'Incorrect email or password';
            break;
        default:
            $msg[] = 'dafault';
            break;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include("../components/head.html") ?>
    <title>Log in | O'PEP</title>
</head>

<body>

    <?php include("../components/nav.php") ?>

    <div class="flex justify-center my-12">
        <div class="flex flex-col justify-center w-[85%] bg-white border border-black rounded-xl md:w-1/2">
            <form onsubmit="return validateLogin()" class="w-3/4 mx-auto" method="post">
                <div class="flex flex-col mt-8">
                    <div class="capitalize mb-5 font-semibold text-xl">
                        <p>Log in</p>
                    </div>
                    <?php
                    if (isset($msg)) {
                        foreach ($msg as $error) {
                            echo '<div class="bg-red-500 mb-3 rounded-lg">';
                            echo '<p class="text-white text-lg text-center">' . $error . '</p>';
                            echo '</div>';
                        }
                    }

                    ?>
                    <!-- Start of input name -->
                    <div class="flex flex-col mb-3">
                        <div id="emailInput" class="flex flex-col border-2 border-[#A1A1A1] p-2 rounded-md">
                            <p class="text-xs">Email</p>
                            <input class="placeholder:font-light placeholder:text-xs focus:outline-none" id="email" type="text" name="email" placeholder="example@exm.com" autocomplete="on">
                        </div>
                        <div id="emailErr" class="text-red-600 text-xs pl-3"></div>
                    </div>
                    <!-- End of input name -->
                    <div class="flex flex-col mb-3">
                        <div id="passwordInput" class="flex flex-col border-2 border-[#A1A1A1] p-2 rounded-md">
                            <p class="text-xs">Password</p>
                            <input class="placeholder:font-light placeholder:text-xs focus:outline-none" id="password" type="password" name="password" placeholder="***************">
                        </div>
                        <div id="passwordErr" class="text-red-600 text-xs pl-3"></div>
                    </div>


                </div>
                <div class="flex justify-start mb-8">
                    <a href="signup.php" class="text-sm text-gray-800 underline">Don't have an account yet? Sign Up</a>
                </div>
                <div class="flex justify-end mb-4">
                    <input type="submit" name="login" class="cursor-pointer px-8 py-2 bg-[#9fff30] font-semibold rounded-lg border-2 border-[#6da22f]" value="Log in">
                </div>
            </form>

        </div>

    </div> <?php include("../components/footer.html") ?>

    <script src="../js/burger.js"></script>
    <script src="../js/cart.js"></script>
</body>

</html>