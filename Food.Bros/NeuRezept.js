function addFoodType() {
    const foodTypesContainer = document.getElementById("foodTypesContainer");
  
    const foodTypeRow = document.createElement("div");
    foodTypeRow.classList.add("foodTypeRow");
  
    const foodTypeInput = document.createElement("input");
    foodTypeInput.type = "text";
    foodTypeInput.classList.add("foodType");
    foodTypeInput.placeholder = "Typ";
    foodTypeInput.required = true;
  
    const deleteButton = document.createElement("button");
    deleteButton.type = "button";
    deleteButton.classList.add("deleteButton");
    deleteButton.innerHTML = '<ion-icon name="trash-outline"></ion-icon>';
    deleteButton.onclick = function() {
      deleteFoodType(deleteButton);
    };
  
    foodTypeRow.appendChild(foodTypeInput);
    foodTypeRow.appendChild(deleteButton);
  
    foodTypesContainer.appendChild(foodTypeRow);
  }
  
  function deleteFoodType(button) {
    const foodTypeRow = button.parentNode;
    const foodTypesContainer = document.getElementById("foodTypesContainer");
    foodTypesContainer.removeChild(foodTypeRow);
  }
  
  function addIngredient() {
    const ingredientsContainer = document.getElementById("ingredientsContainer");
  
    const ingredientRow = document.createElement("div");
    ingredientRow.classList.add("ingredientRow");
  
    const ingredientNameInput = document.createElement("input");
    ingredientNameInput.type = "text";
    ingredientNameInput.classList.add("ingredientName");
    ingredientNameInput.placeholder = "Name der Zutaten";
    ingredientNameInput.required = true;
  
    const ingredientSizeInput = document.createElement("input");
    ingredientSizeInput.type = "text";
    ingredientSizeInput.classList.add("ingredientSize");
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
  }
  
  function deleteIngredient(button) {
    const ingredientRow = button.parentNode;
    const ingredientsContainer = document.getElementById("ingredientsContainer");
    ingredientsContainer.removeChild(ingredientRow);
  }
  
  document.getElementById("recipeForm").addEventListener("submit", function(event) {
    event.preventDefault();
  
    const recipeName = document.getElementById("recipeName").value;
    const foodTypes = document.getElementsByClassName("foodType");
    const ingredientNames = document.getElementsByClassName("ingredientName");
    const ingredientSizes = document.getElementsByClassName("ingredientSize");
  
    const outputRecipeName = document.getElementById("outputRecipeName");
    const foodTypeList = document.getElementById("foodTypeList");
    const ingredientList = document.getElementById("ingredientList");
  
    outputRecipeName.textContent = recipeName;
  
    // Clear previous food type list
    foodTypeList.innerHTML = "";
  
    for (let i = 0; i < foodTypes.length; i++) {
      const foodType = foodTypes[i].value;
  
      const listItem = document.createElement("li");
      listItem.textContent = foodType;
  
      foodTypeList.appendChild(listItem);
    }
  
    // Clear previous ingredient list
    ingredientList.innerHTML = "";
  
    for (let i = 0; i < ingredientNames.length; i++) {
      const ingredientName = ingredientNames[i].value;
      const ingredientSize = ingredientSizes[i].value;
  
      const listItem = document.createElement("li");
      listItem.textContent = ingredientName + " - " + ingredientSize;
  
      ingredientList.appendChild(listItem);
    }
});
  