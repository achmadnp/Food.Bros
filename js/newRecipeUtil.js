let ingredientNamesArray = [];
let ingredientAmountArray = [];
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
  deleteButton.onclick = function () {
    deleteIngredient(deleteButton);
  };

  ingredientRow.appendChild(ingredientNameInput);
  ingredientRow.appendChild(ingredientSizeInput);
  ingredientRow.appendChild(deleteButton);

  ingredientsContainer.appendChild(ingredientRow);
  ingredientNamesArray.push(ingredientNameInput.value);
  ingredientAmountArray.push(ingredientSizeInput.value);

  ingredientCountInput.value = parseInt(ingredientCountInput.value) + 1;
}

function deleteIngredient(button) {
  const ingredientRow = button.parentNode;
  const ingredientsContainer = document.getElementById("ingredientsContainer");
  ingredientsContainer.removeChild(ingredientRow);
}

document
  .getElementById("recipeForm")
  .addEventListener("submit", function (event) {
    const ingredientNames = document.getElementsByClassName("ingredientName");
    const ingredientSizes = document.getElementsByClassName("ingredientSize");

    // Store ingredient names in the array
    ingredientNamesArray = Array.from(ingredientNames).map(
      (input) => input.value
    );

    ingredientAmountArray = Array.from(ingredientSizes).map(
      (input) => input.value
    );

    // Add the ingredient names as a hidden field in the form
    const ingredientNamesInput = document.createElement("input");
    ingredientNamesInput.type = "hidden";
    ingredientNamesInput.name = "ingredientName[]";
    ingredientNamesInput.value = ingredientNamesArray.join(",");

    // Add the ingredient names as a hidden field in the form
    const ingredientSizeInput = document.createElement("input");
    ingredientSizeInput.type = "hidden";
    ingredientSizeInput.name = "ingredientSize[]";
    ingredientSizeInput.value = ingredientAmountArray.join(",");

    // Append the hidden field to the form
    this.appendChild(ingredientNamesInput);
    this.appendChild(ingredientSizeInput);
  });
