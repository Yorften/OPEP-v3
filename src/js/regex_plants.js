function printError(Id, Msg) {
  document.getElementById(Id).innerHTML = Msg;
}

function validateForm() {
  let plant = document.getElementById("plant").value;
  let plantdesc = document.getElementById("plantdesc").value;
  let plantprice = document.getElementById("plantprice").value;
  let plantimg = document.getElementById("plantimg").value;
  let category = document.getElementById("category").value;

  let plantErr = validatePlant(plant);
  let plantdescErr = validateDesc(plantdesc);
  let plantpriceErr = validatePrice(plantprice);
  let plantimgErr = validateImg(plantimg);
  let categoryErr = validateCategory(category);

  if (plantErr && plantdescErr && plantpriceErr && plantimgErr && categoryErr) {
    console.log("true");
    return true;
  } else return false;
}

function validateFormEdit() {
  let plant = document.getElementById("plant2").value;
  let plantdesc = document.getElementById("plantdesc2").value;
  let plantprice = document.getElementById("plantprice2").value;
  let category = document.getElementById("category2").value;


  let plantErr = validatePlantEdit(plant);
  let plantdescErr = validateDescEdit(plantdesc);
  let plantpriceErr = validatePriceEdit(plantprice);
  let categoryErr = validateCategoryEdit(category);

  if (plantErr && plantdescErr && plantpriceErr && categoryErr) {
    console.log("true");
    return true;
  } else return false;
}

function validatePlant(arg) {
  if (arg == "" || arg == null) {
    document.getElementById("plantInput").classList.add("border-red-500");
    printError("plantErr", "Please enter a plant name");
    return false;
  } else {
    var regex = /^(?!\s)[\w\sé]+$/;
    if (!regex.test(arg)) {
      document.getElementById("plantInput").classList.add("border-red-500");
      printError("plantErr", "Please enter a valid name (special characters)");
      return false;
    } else {
      document.getElementById("plantInput").classList.remove("border-red-500");
      printError("plantErr", "");
      return true;
    }
  }
}

function validatePlantEdit(arg) {
  if (arg == "" || arg == null) {
    document.getElementById("plantInput2").classList.add("border-red-500");
    printError("plantErr2", "Please enter a plant name");
    return false;
  } else {
    var regex = /^(?!\s)[\w\sé]+$/;
    if (!regex.test(arg)) {
      document.getElementById("plantInput2").classList.add("border-red-500");
      printError("plantErr2", "Please enter a valid name (special characters)");
      return false;
    } else {
      document.getElementById("plantInput2").classList.remove("border-red-500");
      printError("plantErr2", "");
      return true;
    }
  }
}

function validateDesc(arg) {
  if (arg == "" || arg == null) {
    document.getElementById("plantdescInput").classList.add("border-red-500");
    printError("plantdescErr", "Please enter a plant name");
    return false;
  } else {
    var regex = /^(?!\s)[\w\sé!.,-_]+$/;
    if (!regex.test(arg)) {
      document.getElementById("plantdescInput").classList.add("border-red-500");
      printError(
        "plantdescErr",
        "Please enter a valid name (special characters)"
      );
      return false;
    } else {
      document
        .getElementById("plantdescInput")
        .classList.remove("border-red-500");
      printError("plantdescErr", "");
      return true;
    }
  }
}

function validateDescEdit(arg) {
  if (arg == "" || arg == null) {
    document.getElementById("plantdescInput2").classList.add("border-red-500");
    printError("plantdescErr2", "Please enter a plant name");
    return false;
  } else {
    var regex = /^(?!\s)[\w\sé!.,-_]+$/;
    if (!regex.test(arg)) {
      document.getElementById("plantdescInput2").classList.add("border-red-500");
      printError(
        "plantdescErr2",
        "Please enter a valid name (special characters)"
      );
      return false;
    } else {
      document
        .getElementById("plantdescInput2")
        .classList.remove("border-red-500");
      printError("plantdescErr2", "");
      return true;
    }
  }
}

function validatePrice(arg) {
  if (arg == "" || arg == null) {
    document.getElementById("plantpriceInput").classList.add("border-red-500");
    printError("plantpriceErr", "Please enter the plant price");
    return false;
  } else {
    var regex = /^\d+$/;
    if (!regex.test(arg)) {
      document
        .getElementById("plantpriceInput")
        .classList.add("border-red-500");
      printError("plantpriceErr", "Please enter a number");
      return false;
    } else {
      document
        .getElementById("plantpriceInput")
        .classList.remove("border-red-500");
      printError("plantpriceErr", "");
      return true;
    }
  }
}

function validatePriceEdit(arg) {
  if (arg == "" || arg == null) {
    document.getElementById("plantpriceInput2").classList.add("border-red-500");
    printError("plantpriceErr2", "Please enter the plant price");
    return false;
  } else {
    var regex = /^\d+$/;
    if (!regex.test(arg)) {
      document
        .getElementById("plantpriceInput2")
        .classList.add("border-red-500");
      printError("plantpriceErr2", "Please enter a number");
      return false;
    } else {
      document
        .getElementById("plantpriceInput2")
        .classList.remove("border-red-500");
      printError("plantpriceErr2", "");
      return true;
    }
  }
}

function validateImg(arg) {
  if (arg == "" || arg == null) {
    document.getElementById("plantimgInput").classList.add("border-red-500");
    printError("plantimgErr", "Please enter a plant name");
    return false;
  } else {
    document.getElementById("plantimgInput").classList.remove("border-red-500");
    printError("plantimgErr", "");
    return true;
  }
}

function validateCategory(arg) {
  if (arg == "" || arg == null) {
    document.getElementById("categoryInput").classList.add("border-red-500");
    printError("categoryErr", "Please select a category");
    return false;
  } else {
    document.getElementById("categoryInput").classList.remove("border-red-500");
    printError("categoryErr", "");
    return true;
  }
}

function validateCategoryEdit(arg) {
  if (arg == "" || arg == null) {
    document.getElementById("categoryInput2").classList.add("border-red-500");
    printError("categoryErr2", "Please select a category");
    return false;
  } else {
    document.getElementById("categoryInput2").classList.remove("border-red-500");
    printError("categoryErr2", "");
    return true;
  }
}

// ----------------------------------------------------------

function keydownValidation() {
  let plant = document.getElementById("plant");
  let plantdesc = document.getElementById("plantdesc");
  let plantprice = document.getElementById("plantprice");
  let plantimg = document.getElementById("plantimg");
  let category = document.getElementById("category");

  let plant2 = document.getElementById("plant2");
  let plantdesc2 = document.getElementById("plantdesc2");
  let plantprice2 = document.getElementById("plantprice2");
  let category2 = document.getElementById("category2");

  plant.addEventListener("input", function () {
    validatePlant(plant.value);
  });
  plantdesc.addEventListener("input", function () {
    validateDesc(plantdesc.value);
  });
  plantprice.addEventListener("input", function () {
    validatePrice(plantprice.value);
  });
  plantimg.addEventListener("input", function () {
    validateImg(plantimg.value);
  });
  category.addEventListener("input", function () {
    validateCategory(category.value);
  });

  plant2.addEventListener("input", function () {
    validatePlantEdit(plant2.value);
  });
  plantdesc2.addEventListener("input", function () {
    validateDescEdit(plantdesc2.value);
  });
  plantprice2.addEventListener("input", function () {
    validatePriceEdit(plantprice2.value);
  });
  category2.addEventListener("input", function () {
    validateCategoryEdit(category2.value);
  });
}

function initValidation() {
  let plant = document.getElementById("plant");
  let plantdesc = document.getElementById("plantdesc");
  let plantprice = document.getElementById("plantprice");
  let plantimg = document.getElementById("plantimg");
  let category = document.getElementById("category");

  let plant2 = document.getElementById("plant2");
  let plantdesc2 = document.getElementById("plantdesc2");
  let plantprice2 = document.getElementById("plantprice2");
  let category2 = document.getElementById("category2");

  plant.addEventListener("blur", function () {
    validatePlant(plant.value);
  });
  plantdesc.addEventListener("blur", function () {
    validateDesc(plantdesc.value);
  });
  plantprice.addEventListener("blur", function () {
    validatePrice(plantprice.value);
  });
  plantimg.addEventListener("blur", function () {
    validateImg(plantimg.value);
  });
  category.addEventListener("blur", function () {
    validateCategory(category.value);
  });

  plant2.addEventListener("blur", function () {
    validatePlantEdit(plant2.value);
  });
  plantdesc2.addEventListener("blur", function () {
    validateDescEdit(plantdesc2.value);
  });
  plantprice2.addEventListener("blur", function () {
    validatePriceEdit(plantprice2.value);
  });
  category2.addEventListener("blur", function () {
    validateCategoryEdit(category2.value);
  });
}

initValidation();
keydownValidation();
