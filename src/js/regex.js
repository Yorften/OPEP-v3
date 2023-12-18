function printError(Id, Msg) {
  document.getElementById(Id).innerHTML = Msg;
}

function validateForm() {
  var username = document.getElementById("username").value;
  var email = document.getElementById("email").value;
  var password = document.getElementById("password").value;
  var repeat = document.getElementById("repeat").value;

  var userErr = validateName(username);
  var emailErr = validateEmail(email);
  var passwordErr = validatePassword(password);
  var repeatErr = validateRepeat(password, repeat);

  if (userErr && emailErr && passwordErr && repeatErr) {
    console.log("true");
    return true;
  } else return false;
}

function validateLogin() {
  var email = document.getElementById("email").value;
  var password = document.getElementById("password").value;

  var emailErr = validateEmail(email);
  var passwordErr = validatePassword(password);

  if (emailErr && passwordErr) {
    console.log("true");
    return true;
  } else return false;
}

function validateName(username) {
  if (username == "" || username == null) {
    document.getElementById("userInput").classList.add("border-red-500");
    printError("userErr", "Please enter your username");
    return false;
  } else {
    var regex = /^[a-zA-Z0-9]+$/;
    if (!regex.test(username)) {
      document.getElementById("userInput").classList.add("border-red-500");
      printError(
        "userErr",
        "Please enter a valid username (no spaces/special characters)"
      );
      return false;
    } else {
      document.getElementById("userInput").classList.remove("border-red-500");
      printError("userErr", "");
      return true;
    }
  }
}

function validateEmail(email) {
  if (email == "" || email == null) {
    document.getElementById("emailInput").classList.add("border-red-500");
    printError("emailErr", "Please enter your email.");
    return false;
  } else {
    var regex = /^[a-zA-Z0-9]+@[a-z]+\.[a-zA-Z]{2,3}$/;
    if (!regex.test(email)) {
      document.getElementById("emailInput").classList.add("border-red-500");
      printError("emailErr", "Please enter a valid email (example@gmail.com)");
      return false;
    } else {
      document.getElementById("emailInput").classList.remove("border-red-500");
      printError("emailErr", "");
      return true;
    }
  }
}

function validatePassword(password) {
  if (password == "" || password == null) {
    document.getElementById("passwordInput").classList.add("border-red-500");
    printError("passwordErr", "Please enter your password");
    return false;
  } else {
    var regex = /^.{8,}$/;
    if (!regex.test(password)) {
      document.getElementById("passwordInput").classList.add("border-red-500");
      printError("passwordErr", "Password must contain atleast 8 characters");
      return false;
    } else {
      document
        .getElementById("passwordInput")
        .classList.remove("border-red-500");
      printError("passwordErr", "");
      return true;
    }
  }
}
// message
function validateRepeat(password, repeat) {
  if (repeat == "" || repeat == null) {
    document.getElementById("repeatInput").classList.add("border-red-500");
    printError("repeatErr", "Please repeat the password");
    return false;
  } else {
    if (password != repeat) {
      document.getElementById("repeatInput").classList.add("border-red-500");
      printError("repeatErr", "Passwords do not match");
      return false;
    } else {
      document.getElementById("repeatInput").classList.remove("border-red-500");
      printError("repeatErr", "");
      return true;
    }
  }
}

function keydownValidation() {
  var username = document.getElementById("username");
  var email = document.getElementById("email");
  var password = document.getElementById("password");
  var repeat = document.getElementById("repeat");

  username.addEventListener("input", function () {
    validateName(username.value);
  });
  email.addEventListener("input", function () {
    validateEmail(email.value);
  });
  password.addEventListener("input", function () {
    validatePassword(password.value);
  });
  repeat.addEventListener("input", function () {
    validateRepeat(password.value, repeat.value);
  });
}

function initValidation() {
  var username = document.getElementById("username");
  var email = document.getElementById("email");
  var password = document.getElementById("password");
  var repeat = document.getElementById("repeat");

  username.addEventListener("blur", function () {
    validateName(username.value);
  });
  email.addEventListener("blur", function () {
    validateEmail(email.value);
  });
  password.addEventListener("blur", function () {
    validatePassword(password.value);
  });
  repeat.addEventListener("blur", function () {
    validateRepeat(password.value, repeat.value);
  });
}

initValidation();
keydownValidation();
