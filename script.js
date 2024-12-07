//button top
window.onscroll = function() {
  showBackToTopButton();
};

function showBackToTopButton() {
  var topButton = document.getElementById("topbTN");
  var bannerHeight = document.querySelector('.slideshow-container').offsetHeight;

  if (document.body.scrollTop > bannerHeight || document.documentElement.scrollTop > bannerHeight) {
      topButton.style.display = "block";
  } else {
      topButton.style.display = "none";
  }
}

function topFunction() {
  window.scrollTo({
      top: 0,
      behavior: 'smooth'
  });
}

