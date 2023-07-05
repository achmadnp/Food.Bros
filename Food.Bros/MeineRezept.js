let isFirstEdit = true;

function addRecipe() {
  var recipeInput = document.getElementById("recipe-input");
  var recipeName = recipeInput.value;
  
  if (recipeName.trim() === "") {
    alert("Please enter a recipe name");
    return;
  }
  
  var recipeList = document.getElementById("recipe-list");
  var listItem = document.createElement("li");
  listItem.className = "recipe-item";
  
  var nameSpan = document.createElement("span");
  nameSpan.textContent = recipeName;
  
  var editButton = document.createElement("button");
  editButton.textContent = "Bearbeiten";
  editButton.addEventListener("click", function() {
    editRecipe(listItem);
  });
  
  var deleteButton = document.createElement("button");
  deleteButton.textContent = "Löschen";
  deleteButton.addEventListener("click", function() {
    deleteRecipe(listItem);
  });
  
  listItem.appendChild(nameSpan);
  listItem.appendChild(editButton);
  listItem.appendChild(deleteButton);
  
  recipeList.appendChild(listItem);
  
  recipeInput.value = "";
}

function editRecipe(listItem) {
  if (isFirstEdit) {
    window.location.href = "NeuRezept.html"; // Redirect to NeuRezept.html
    isFirstEdit = false;
  } else {
    var recipeName = listItem.querySelector("span").textContent;
    var newRecipeName = prompt("Enter the new recipe name", recipeName);
  
    if (newRecipeName.trim() === "") {
      alert("Please enter a recipe name");
      return;
    }
  
    listItem.querySelector("span").textContent = newRecipeName;
  }
}

function deleteRecipe(listItem) {
  listItem.remove();
}
