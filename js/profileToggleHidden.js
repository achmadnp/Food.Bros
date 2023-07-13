document
  .querySelector('button[name="toggle_button"]')
  .addEventListener("click", function () {
    var component = document.getElementById("hidden-component");
    if (component.classList.contains("hidden")) {
      component.classList.remove("hidden");
      component.style.display = "block";
    } else {
      component.classList.add("hidden");
      component.style.display = "none";
    }
  });
