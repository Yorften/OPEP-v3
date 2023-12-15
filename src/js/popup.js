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
  var categoryName = document.getElementById("category"+itemId).textContent;
  document.getElementById("categoryname2").value = categoryName;
  console.log(categoryName);
}

function showPlantDetails(itemId) {
  document.getElementById("popupEdit").classList.remove("hidden");
 
}
