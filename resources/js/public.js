  // inicializacion para material box
  document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.materialboxed');
    var instances = M.Materialbox.init(elems);
  });

  // inicializacion de carrusel
  document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.carousel');
    var instances = M.Carousel.init(elems, {
      duration: 500,
      indicators: true
    });
  });

  var instance = M.Carousel.init({
    fullWidth: true,
    indicators: true
  })

  // inicializacion para tooltip
  document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.tooltipped');
    var instances = M.Tooltip.init(elems);
  });

  // inicializacion de menu para pantallas pequeñas
  document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.sidenav');
    var instances = M.Sidenav.init(elems);
  });