document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.sidenav');
    var instances = M.Sidenav.init(elems);
  });

  const card = document.querySelector('.card');

card.addEventListener('mouseenter', function() {
  card.style.boxShadow = '0 8px 16px 0 rgba(1, 1, 1, 1.2)';
});

card.addEventListener('mouseleave', function() {
  card.style.boxShadow = '0 4px 8px 0 rgba(0, 0, 0, 0.2)';
});

var instance = M.Carousel.init({
  fullWidth: true
});

document.addEventListener('DOMContentLoaded', function() {
  var elems = document.querySelectorAll('.carousel');
  var instances = M.Carousel.init(elems);
});
