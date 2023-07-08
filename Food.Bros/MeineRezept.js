//addRecipe hapus aje kalo udh siap
function addRecipe() {
  var recipeName = prompt("Enter the recipe name");
  
  if (recipeName.trim() === "") {
    alert("Please enter a recipe name");
    return;
  }
  
  var recipeType = prompt("Enter the recipe type");
  
  if (recipeType.trim() === "") {
    alert("Please enter a recipe type");
    return;
  }
  
  var recipeList = document.getElementById("recipe-list");
  var listItem = document.createElement("li");
  listItem.className = "recipe-item";
  
  var nameSpan = document.createElement("span");
  nameSpan.textContent = recipeName;
  
  var typeSpan = document.createElement("span");
  typeSpan.textContent = recipeType;
  typeSpan.className = "recipe-type";
  
  var infoContainer = document.createElement("div");
  infoContainer.className = "recipe-info";
  infoContainer.appendChild(nameSpan);
  infoContainer.appendChild(typeSpan);
  
  var editButton = document.createElement("button");
  editButton.textContent = "Bearbeiten";
  editButton.className = "btn";
  editButton.addEventListener("click", function() {
    editRecipe(listItem);
  });
  
  var deleteButton = document.createElement("button");
  deleteButton.textContent = "Löschen";
  deleteButton.className = "btn";
  deleteButton.addEventListener("click", function() {
    deleteRecipe(listItem);
  });
  
  listItem.appendChild(infoContainer);
  listItem.appendChild(editButton);
  listItem.appendChild(deleteButton);
  
  recipeList.appendChild(listItem);
}

function editRecipe(listItem) {
  var nameSpan = listItem.querySelector(".recipe-info span:first-child");
  var recipeName = nameSpan.textContent;
  var newRecipeName = prompt("Enter the new recipe name", recipeName);
  
  if (newRecipeName.trim() === "") {
    alert("Please enter a recipe name");
    return;
  }
  
  nameSpan.textContent = newRecipeName;
  
  var typeSpan = listItem.querySelector(".recipe-type");
  var recipeType = typeSpan.textContent;
  var newRecipeType = prompt("Enter the new recipe type", recipeType);
  
  if (newRecipeType.trim() === "") {
    alert("Please enter a recipe type");
    return;
  }
  
  typeSpan.textContent = newRecipeType;
}

function deleteRecipe(listItem) {
  listItem.remove();
}
