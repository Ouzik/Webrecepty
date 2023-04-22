
// Nájde prvok s id "menu-bar" a priradí ho do premennej "menu"
let menu = document.querySelector('#menu-bar');
// Nájde prvok s triedou "navbar" a priradí ho do premennej "navbar"
let navbar = document.querySelector('.navbar');

// Po kliknutí na prvok s id "menu-bar" pridá alebo odoberie triedu "fa-times" prvku "menu" a triedu "active" prvku "navbar"
menu.onclick = () =>{

  menu.classList.toggle('fa-times');
  navbar.classList.toggle('active');

}


/*Pri skrolovaní stránky odstráni triedy "fa-times" z prvku "menu" a "active" z prvku "navbar", 
a ak sa pozícia skrollovania dostane vyššie ako 60px, pridá triedu "active" prvku s id "scroll-top", inak ju odstráni*/
window.onscroll = () =>{

  menu.classList.remove('fa-times');
  navbar.classList.remove('active');

  if(window.scrollY > 60){
    document.querySelector('#scroll-top').classList.add('active');
  }else{
    document.querySelector('#scroll-top').classList.remove('active');
  }
}

//Funkcia na skrytie prvku s triedou "loader-container" pridaním triedy "fade-out"

function loader(){
  document.querySelector('.loader-container').classList.add('fade-out');
}

// Funkcia, ktorá každé tri sekundy spustí funkciu "loader"
function fadeOut(){
  setInterval(loader, 3000);
}
// Spustí funkciu "fadeOut" pri načítaní stránky
window.onload = fadeOut();