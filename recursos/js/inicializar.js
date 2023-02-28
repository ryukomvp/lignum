// inicializar Sidenav
document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.sidenav');
    var instances = M.Sidenav.init(elems);
  });

// Efecto hover
card.addEventListener('mouseenter', function() {
  card.style.boxShadow = '0 8px 16px 0 rgba(1, 1, 1, 1.2)';
});

// Efecto hover
card.addEventListener('mouseleave', function() {
  card.style.boxShadow = '0 4px 8px 0 rgba(0, 0, 0, 0.2)';
});

// Inicializar carousel
var instance = M.Carousel.init({
  fullWidth: true
});

// Inicializar carousel
document.addEventListener('DOMContentLoaded', function() {
  var elems = document.querySelectorAll('.carousel');
  var instances = M.Carousel.init(elems);
});
