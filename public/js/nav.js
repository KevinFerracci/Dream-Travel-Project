window.onscroll = function () {
  if (this.document.documentElement.scrollTop > window.innerHeight) {
    this.document.querySelector("nav").style.background = "#4682B4";
  }
  else {
    this.document.querySelector("nav").style.background = "none";
  }
} 