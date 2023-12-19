function printError(Id, Msg) {
  document.getElementById(Id).innerHTML = Msg;
}

function validateForm() {
  let categoryname = document.getElementById("categoryname").value;

  let userErr = validateName(categoryname);

  if (userErr) {
    console.log("true");
    return true;
  } else return false;
}

function validateFormEdit() {
  let categoryname2 = document.getElementById("categoryname2").value;

  let userErr = validateNameEdit(categoryname2);

  if (userErr) {
    console.log("true");
    return true;
  } else return false;
}

function validateName(username) {
  if (username == "" || username == null) {
    document.getElementById("categoryInput").classList.add("border-red-500");
    printError("categorynameErr", "Please enter a category name");
    return false;
  } else {
    var regex = /^[a-zA-Z]+$/;
    if (!regex.test(username)) {
      document.getElementById("categoryInput").classList.add("border-red-500");
      printError(
        "categorynameErr",
        "Please enter a valid name (no spaces/special characters)"
      );
      return false;
    } else {
      document
        .getElementById("categoryInput")
        .classList.remove("border-red-500");
      printError("categorynameErr", "");
      return true;
    }
  }
}

function validateNameEdit(username) {
  if (username == "" || username == null) {
    document.getElementById("categoryInput2").classList.add("border-red-500");
    printError("categorynameErr2", "Please enter a category name");
    return false;
  } else {
    var regex = /^[a-zA-Z]+$/;
    if (!regex.test(username)) {
      document.getElementById("categoryInput2").classList.add("border-red-500");
      printError(
        "categorynameErr2",
        "Please enter a valid name (no spaces/special characters)"
      );
      return false;
    } else {
      document
        .getElementById("categoryInput2")
        .classList.remove("border-red-500");
      printError("categorynameErr2", "");
      return true;
    }
  }
}

function keydownValidation() {
  let categoryname = document.getElementById("categoryname");
  let categoryname2 = document.getElementById("categoryname2");

  categoryname.addEventListener("input", function () {
    validateName(categoryname.value);
  });
  categoryname2.addEventListener("input", function () {
    validateNameEdit(categoryname2.value);
  });
}

function initValidation() {
  let categoryname = document.getElementById("categoryname");
  let categoryname2 = document.getElementById("categoryname2");

  categoryname.addEventListener("blur", function () {
    validateName(categoryname.value);
  });
  categoryname2.addEventListener("blur", function () {
    validateNameEdit(categoryname2.value);
  });
}

initValidation();
keydownValidation();
