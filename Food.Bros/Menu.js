function toggleFoodList(foodType) {
  const foodList = document.getElementById(`${foodType}-list`);

  if (activeFoodList && activeFoodList !== foodList) {
      activeFoodList.classList.remove("show");
  }

  foodList.classList.toggle("show");
  activeFoodList = foodList;
}
  
  let activeFoodList = null;
  
  function toggleFoodList(foodType) {
      const foodList = document.getElementById(`${foodType}-list`);
  
      if (activeFoodList && activeFoodList !== foodList) {
          activeFoodList.classList.remove("show");
      }
  
      foodList.classList.toggle("show");
      activeFoodList = foodList;
  }
  
  function handleFoodSelection(foodName) {
    // Do something with the selected food, such as triggering an action or storing it in a variable
    console.log(`Selected food: ${foodName}`);
  }
  
  
  