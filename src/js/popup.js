function openPopup() {
  document.getElementById("popup").classList.remove("hidden");
}

function closePopup() {
  document.getElementById("popup").classList.add("hidden");
  document.getElementById("popupEdit").classList.add("hidden");
}

window.onclick = function (event) {
  var popup = document.getElementById("popup");
  var popup2 = document.getElementById("popupEdit");
  if (event.target == popup) {
    popup.classList.add("hidden");
  } else if (event.target == popup2) {
    popup2.classList.add("hidden");
  }
};

function showDetails(itemId) {
  document.getElementById("popupEdit").classList.remove("hidden");
  var categoryName = document.getElementById("category" + itemId).textContent;
  document.getElementById("categoryname2").value = categoryName;
  document.getElementById("categoryId").value = itemId;
}

function showPlantDetails(itemId) {
  document.getElementById("popupEdit").classList.remove("hidden");
  var plantCategory = document.getElementById("plantCategory" + itemId).textContent;
  var plantName = document.getElementById("plantName" + itemId).textContent;
  var plantDesc = document.getElementById("plantDesc" + itemId).textContent;
  var plantPrice = document.getElementById("plantPrice" + itemId).textContent;

  var select = document.getElementById("category2");
  var options = select.options;

  document.getElementById("plantId").value = itemId;
  document.getElementById("plant2").value = plantName;
  document.getElementById("plantdesc2").value = plantDesc;
  document.getElementById("plantprice2").value = plantPrice;

  for (let i = 0; i < options.length; i++) {
    if (options[i].textContent === plantCategory) {
      options[i].selected = true;
      break;
    }
  }
}
