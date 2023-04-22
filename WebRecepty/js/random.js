const search_input = document.querySelector('.search-input');
const search_icon = document.querySelector('.search-icon');
const mealEl_container = document.querySelector('.meal');

const popup_container = document.querySelector('.pop-up-container');
const close_popup_btn = document.querySelector('.pop-up > i');
const popup = document.querySelector('.pop-up-inner');

const random = document.getElementById('random');
random.addEventListener('click', replaceRandomMeal);



async function getRandomMeal() { // definuje funkciu s názvom "getRandomMeal", ktorá bude asynchrónna
  const resp = await fetch(
    'https://www.themealdb.com/api/json/v1/1/random.php' //vytvorí HTTP požiadavku na API server, ktorá vráti náhodné jedlo v JSON formáte
  );
  const respData = await resp.json(); //dekóduje odpoveď z API servera z JSON formátu na JavaScript objekt
  const random_meal = respData.meals[0]; // získa náhodné jedlo z dekódovaných dát
  addMeal(random_meal); //pridá náhodné jedlo na stránku pomocou funkcie "addMeal"
}



/*Funkcia addMeal prijíma parameter meal, ktorý predstavuje objekt jedla.
Vytvorí sa nový element div s triedou meal-card.
Do div sa vložia ďalšie elementy div a img, ktoré zobrazujú obrázok jedla a jeho názov.
Vytvorí sa premenná btn, ktorá získa prvok s triedou fa-heart z meal_card.
Pridá sa event listener na tlačidlo btn, ktorý pridá alebo odstráni jedlo z localStorage v závislosti od toho, či užívateľ klikol na ikonu srdca alebo nie.
Vytvorený element sa pridá do kontajnera jedál (mealEl_container).
Pridá sa event listener na prvý element div v meal_card, ktorý zobrazí vyskakovacie okno s podrobnosťami o jedle. */

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




/*Vytvorenie premennej "random_meal_card", ktorá získava prvý prvok "mealEl_container".
Odstránenie prvku "random_meal_card" z "mealEl_container".
Spustenie funkcie "getRandomMeal()", ktorá náhodne vyberie ďalšie jedlo a zobrazí ho v "mealEl_container". */

function replaceRandomMeal() {
  const random_meal_card = mealEl_container.firstChild;
  mealEl_container.removeChild(random_meal_card);
  getRandomMeal();
}



function getMealLS() {
  const mealIds = JSON.parse(localStorage.getItem('mealIds')); //Vytvorenie premennej mealIds.Získanie hodnoty s kľúčom mealIds z localStorage a prevedenie jej z reťazca JSON do objektu.

  return mealIds === null ? [] : mealIds; //Ak je mealIds null, vráti sa prázdne pole, inak sa vráti zoznam identifikátorov jedál.
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
      <i class="fa-regular fa-heart"></i>
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

