function addIngredient() {
  const ingredientsContainer = document.getElementById("ingredientsContainer");
  const ingredientCountInput = document.getElementById("ingredientCount");

  const ingredientRow = document.createElement("div");
  ingredientRow.classList.add("ingredientRow");

  const ingredientNameInput = document.createElement("input");
  ingredientNameInput.type = "text";
  ingredientNameInput.classList.add("ingredientName");
  ingredientNameInput.name = "ingredientName" + ingredientCountInput.value;
  ingredientNameInput.placeholder = "Name der Zutaten";
  ingredientNameInput.required = true;

  const ingredientSizeInput = document.createElement("input");
  ingredientSizeInput.type = "text";
  ingredientSizeInput.classList.add("ingredientSize");
  ingredientSizeInput.name = "ingredientSize" + ingredientCountInput.value;
  ingredientSizeInput.placeholder = "Größe";
  ingredientSizeInput.required = true;

  const deleteButton = document.createElement("button");
  deleteButton.type = "button";
  deleteButton.classList.add("deleteButton");
  deleteButton.innerHTML = '<ion-icon name="trash-outline"></ion-icon>';
  deleteButton.onclick = function() {
    deleteIngredient(deleteButton);
  };

  ingredientRow.appendChild(ingredientNameInput);
  ingredientRow.appendChild(ingredientSizeInput);
  ingredientRow.appendChild(deleteButton);

  ingredientsContainer.appendChild(ingredientRow);

  ingredientCountInput.value = parseInt(ingredientCountInput.value) + 1;
}

function deleteIngredient(button) {
  const ingredientRow = button.parentNode;
  const ingredientsContainer = document.getElementById("ingredientsContainer");
  ingredientsContainer.removeChild(ingredientRow);
}

document.getElementById("recipeForm").addEventListener("submit", function(event) {
  event.preventDefault();

  const ingredientNames = document.getElementsByClassName("ingredientName");
  const ingredientSizes = document.getElementsByClassName("ingredientSize");

  for (let i = 0; i < ingredientNames.length; i++) {
    console.log("Ingredient Name:", ingredientNames[i].value);
    console.log("Ingredient Size:", ingredientSizes[i].value);
  }
});
