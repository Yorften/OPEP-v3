<?php
require_once '../includes/CartDAO.php';
require_once '../includes/authentification.php';

$register = new Register();


if (isset($_SESSION['client_name'])) {
    header('location:../../index.php');
    exit;
} elseif (isset($_SESSION['admin_name'])) {
    header('location:dashboard.php');
    exit;
} elseif (isset($_SESSION['admin_name'])) {
    header('location:controlpanel.php');
    exit;
}

if (isset($_POST['signup'])) {
    $userName = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $result = $register->register($userName, $email, $password);
    if ($result) {
        $_SESSION['userId'] = $register->userId;
        header('location:role.php?id=' . $_SESSION['userId'].'&name='.$userName);
        exit;
    } else {
        $msg[] = "Username or email already exists";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include("../components/head.html") ?>
    <title>Sign up | O'PEP</title>
</head>

<body>

    <?php include("../components/nav.php") ?>

    <div class="flex justify-center my-12">
        <div class="flex flex-col justify-center w-[90%] bg-white border border-black rounded-xl md:w-1/2">
            <form onsubmit="return validateForm()" class="w-3/4 mx-auto" method="post">
                <div class="flex flex-col mt-8">
                    <div class="capitalize mb-5 font-semibold text-xl">
                        <p>Sign Up</p>
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
                        <div id="userInput" class="flex flex-col border-2 border-[#A1A1A1] p-2 rounded-md">
                            <p class="text-xs">Username</p>
                            <input class="placeholder:font-light placeholder:text-xs focus:outline-none" id="username" type="text" name="username" placeholder="John" autocomplete="off">
                        </div>
                        <div id="userErr" class="text-red-600 text-xs pl-3"></div>
                    </div>
                    <div class="flex flex-col mb-3">
                        <div id="emailInput" class="flex flex-col border-2 border-[#A1A1A1] p-2 rounded-md">
                            <p class="text-xs">Email</p>
                            <input class="placeholder:font-light placeholder:text-xs focus:outline-none" id="email" type="text" name="email" placeholder="example@exm.com" autocomplete="off">
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
                    <div class="flex flex-col mb-3">
                        <div id="repeatInput" class="flex flex-col border-2 border-[#A1A1A1] p-2 rounded-md">
                            <p class="text-xs">Repeat password</p>
                            <input class="placeholder:font-light placeholder:text-xs focus:outline-none" id="repeat" type="password" name="repeat" placeholder="***************">
                        </div>
                        <div id="repeatErr" class="text-red-600 text-xs pl-3"></div>
                    </div>

                    <input type="hidden" class="border-red-500">
                </div>
                <div class="flex justify-start mb-8">
                    <a href="login.php" class="text-sm text-gray-800 underline">Already have an account? Log In</a>
                </div>
                <div class="flex justify-end mb-4">
                    <input id="signbutton" type="submit" name="signup" class="cursor-pointer px-8 py-2 bg-[#9fff30] font-semibold rounded-lg border-2 border-[#6da22f]" value="Continue">
                </div>
            </form>

        </div>
    </div>
 

    <?php include("../components/footer.html") ?>
    <script src="../js/burger.js"></script>
    <script src="../js/regex.js"></script>

</body>

</html>