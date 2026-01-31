
function toggleMenu() {
    document.getElementById("dropdown-content").classList.toggle("show");
}

window.onclick = function(event) {
  if (!event.target.matches('.dropbtn')) {
    var dropdowns = document.getElementsByClassName("dropdown-content");
    for (var i = 0; i < dropdowns.length; i++) {
      dropdowns[i].classList.remove('show');
    }
  }
}
window.addEventListener('scroll', function() {
    const header = document.querySelector('header');
    const navbar = document.querySelector('.navbar');

    if (window.scrollY > header.offsetHeight) {
        // scroll passato l'header → header scompare
        header.style.display = 'none';
        navbar.style.top = '0'; // navbar si attacca al top
    } else {
        // siamo in cima → mostra header
        header.style.display = 'flex';
        navbar.style.top = header.offsetHeight + 'px'; // navbar sotto l'header
    }
});