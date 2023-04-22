const search_input = document.querySelector('.search-input');
const search_icon = document.querySelector('.search-btn');
const mealEl_container = document.querySelector('.meal');

const popup_container = document.querySelector('.pop-up-container');
const close_popup_btn = document.querySelector('.pop-up > i');
const popup = document.querySelector('.pop-up-inner');



async function getMealsBySearch(term) {
  const resp = await fetch(
    `https://www.themealdb.com/api/json/v1/1/search.php?s=${term}`
  );
  const respData = await resp.json();
  const meals = respData.meals;
  return meals;
}

search_icon.addEventListener('click', async () => {
  mealEl_container.innerHTML = '';
  const searchVal = search_input.value;
  const meals = await getMealsBySearch(searchVal);

  if (meals) {
    meals.forEach((meal) => {
      addMeal(meal);
    });

    document.querySelector('.meals-container > h2').innerText =
      'Search Results';
  } else {
    document.querySelector('.meals-container > h2').innerText =
      'No Meals Found';
    mealEl_container.innerHTML = '';
  }
});

function addMeal(meal) {
  const meal_card = document.createElement('div');
  meal_card.classList.add('meal-card');
  meal_card.innerHTML = `
        <div class="meal-card-img-container">
            <img
            src="${meal.strMealThumb}"
            />
        </div>
        <div class="meal-name">
            <p>${meal.strMeal}</p>
            <i class="fa-regular fa-heart"></i>
        </div>`;

  const btn = meal_card.querySelector('.fa-heart');
  btn.addEventListener('click', () => {
    if (btn.classList.contains('fa-regular')) {
      btn.setAttribute('class', 'fa-solid fa-heart');
      addMealLS(meal.idMeal);
    } else {
      btn.setAttribute('class', 'fa-regular fa-heart');
      removeMealLS(meal.idMeal);
    }
  });

  mealEl_container.appendChild(meal_card);
  meal_card.firstChild.nextSibling.addEventListener('click', () => {
    showMealPopup(meal);
  });
}

function getMealLS() {
  const mealIds = JSON.parse(localStorage.getItem('mealIds'));

  return mealIds === null ? [] : mealIds;
}

function addMealLS(mealID) {
  const mealIds = getMealLS();
  localStorage.setItem('mealIds', JSON.stringify([...mealIds, mealID]));
}

function removeMealLS(mealID) {
  const mealIds = getMealLS();
  localStorage.setItem(
    'mealIds',
    JSON.stringify(mealIds.filter((id) => id !== mealID))
  );
}


function showMealPopup(meal) {
  popup.innerHTML = '';

  const newPopup = document.createElement('div');
  newPopup.classList.add('pop-up-inner');

  const ingredients = [];
  for (let i = 1; i <= 20; i++) {
    if (meal[`strIngredient${i}`]) {
      ingredients.push(
        `${meal[`strIngredient${i}`]} - ${meal[`strMeasure${i}`]}`
      );
    } else {
      break;
    }
  }

  newPopup.innerHTML = `<div class="left">
  <div class ="background"></div>
  <div class="meal-card">
    <div class="meal-card-img-container">
      <img
        src="${meal.strMealThumb}"
      />
    </div>
    <div class="meal-name">
      <p>${meal.strMeal}</p>
    </div>
  </div>
  <div class="recipe-link">
  <a href="${meal.strYoutube}" target="_blank">
  <button type="button" class="btn btn-outline-success">
  Watch Recipe
  </button>
  </a>
  </div>
</div>
<div class="right">
  <div>
    <h2>Instructions</h2>
    <p class="meal-info">
     ${meal.strInstructions}
    </p>
  </div>
  <div>
    <h2>Ingredients / Measures</h2>
    <ul>
      ${ingredients.map((e) => `<li>${e}</li>`).join('')}
    </ul>
  </div>
</div>`;

  popup.appendChild(newPopup);
  popup_container.style.display = 'flex';
}

close_popup_btn.addEventListener('click', () => {
  popup_container.style.display = 'none';
});