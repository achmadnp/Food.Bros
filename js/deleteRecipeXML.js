document.getElementById("delete_recipe").addEventListener("click", function () {
  const param = this.getAttribute("data-rid");

  const xhr = new XMLHttpRequest();
  xhr.open("POST", "includes/recipe_delete.inc.php", true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      console.log(xhr.responseText);
      location.reload();
    }
  };
  xhr.send("delete_recipeId=" + encodeURIComponent(param));
});
