/* Script to get a map for Leaflet */

let latitude = document.getElementById('mapid').dataset.latitude;
let longitude = document.getElementById('mapid').dataset.longitude;
console.log(latitude + ' ' + longitude);
//https://leafletjs.com/examples/quick-start/
let mymap = L.map('mapid').setView([latitude, longitude], 10);
console.log(mymap)


// Token here : https://account.mapbox.com/

L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1Ijoic2V2ZW5rbGltIiwiYSI6ImNrbGtpbG41NzEwY2kyb3FpNTk4dWdyZXUifQ.d0rOMY386bVHvvljhh3OyA', {
  attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
  maxZoom: 18,
  id: 'mapbox/streets-v11',
  tileSize: 512,
  zoomOffset: -1,
  accessToken: 'pk.eyJ1Ijoic2V2ZW5rbGltIiwiYSI6ImNrbGtpbG41NzEwY2kyb3FpNTk4dWdyZXUifQ.d0rOMY386bVHvvljhh3OyA'
}).addTo(mymap);

let marker = L.marker([latitude, longitude]).addTo(mymap);

// Get the modal
var modal = document.getElementById("myModal");

var modalImg = document.getElementById("img01");


// Get the image and insert it inside the modal - use its "alt" text as a caption
var galleryImages = document.querySelectorAll(".img-gallery img");

galleryImages.forEach((image) => {
  image.addEventListener("click", handleClick);
});

function handleClick(evt) {
  modal.style.display = "block";
  modalImg.src = this.src;
  //captionText.innerHTML = this.alt;
  evt.currentTarget
}

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
modal.onclick = function () {
  modal.style.display = "none";
}

/* Script to indicate the name of the image in the form input*/

  if (document.querySelector('form')) {
  document.getElementById('review_text').setAttribute('placeholder', 'C\'était génial, best trip ever!');


  if (document.querySelector('form')) {
    document.getElementById('review_text').setAttribute('placeholder', 'C\'était génial, best trip ever!');

    document.getElementById('review_title').setAttribute('placeholder', 'Un été à Paris');

    let input = document.getElementById('review_imageFile');

    document.querySelector('.custom-file-label').textContent = 'la_tour_eiffel.jpg';

    let fileName = '';
    input.onchange = function () {
      let name = document.querySelector('.custom-file-label').textContent = this.value.slice(12, this.value.length);
      if (name.length > 20) {
        fileName = name.slice(12, 20) + '...' + name.slice(name.length - 8, name.length);
        document.querySelector('.custom-file-label').textContent = fileName;
      }
    }
  }

}   

  /* Set place holder in review form */

  if (document.querySelector('form')) {
    document.getElementById('review_text').setAttribute('placeholder', 'C\'était génial, best trip ever!');


    document.getElementById('review_title').setAttribute('placeholder', 'Un été à Paris');

    let input = document.getElementById('review_imageFile');

    document.querySelector('.custom-file-label').textContent = 'la_tour_eiffel.jpg';

    let fileName = '';
    input.onchange = function () {
      let name = document.querySelector('.custom-file-label').textContent = this.value.slice(12, this.value.length);
      if (name.length > 20) {
        fileName = name.slice(12, 20) + '...' + name.slice(name.length - 8, name.length);
        document.querySelector('.custom-file-label').textContent = fileName;
      }
    };
  }

  let reviewButtons = document.querySelectorAll('.report-review-button');
reviewButtons.forEach(
  function (reviewButton) {
    reviewButton.addEventListener('click', handleReportReview);
  }
)

// Script to report a comment 
function handleReportReview(evt) {
  evt.preventDefault();
  const url = this.href;
  let span = evt.target.closest('.span-review');

  fetch(url, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'Accept': 'application/json'
    }
  }).then(
    (response) => {
      if (response.status == 202) {
        console.log(response.status + ' - opération effectuée')
      }
      else if (response.status === 204) {
        console.log(response.status + ' - pas de resultats')
      }
      else {
        console.log(response.status + 'L\'opération a échoué')
      }
    })
    .then(
      (data) => {

        span.textContent = 'L\'avis est signalé. Merci !';

      }
    );
}

let reviewVoteSpans = document.querySelectorAll('.review-vote');
let reviewId = '';
let spanRate = '';

reviewVoteSpans.forEach(
  function (reviewVoteSpan) {

    let heart = reviewVoteSpan.querySelector('i');

    heart.addEventListener('click', changeHeart);

    spanRate = document.querySelector('.span-rate');
    spanRate.textContent = parseInt(document.querySelector('.span-rate').dataset.likescount);

  }
); 

// Script to like a review

function changeHeart(evt) {
  reviewId = evt.target.dataset.reviewid;
  evt.preventDefault();
  let url = '/api/v1/review/' + reviewId + '/like'

  fetch(url, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'Accept': 'application/json'
    }
  })
    .then(
      (response) => {

        if (response.status == 200) {
          console.log(response.status + ' - opération effectuée');
          return response.json();
        }
        else {
          console.log(response.status + 'L\'opération a échoué');
        }
      })
    .then(
      (data) => {

        let icone = evt.target;
        parentSpan = evt.target.parentNode.parentNode;
        parentSpan.querySelector('.span-rate').innerText = data.likes;

        if (icone.classList.contains('fa-heart-o')) {
          icone.setAttribute("class", "em em-heart");
        }
        else {
          icone.setAttribute("class", "fa fa-heart-o");
        }

      }
    );

}

// Script to like a city

let divCityLike = document.querySelector('.city-likes');
let cityId = divCityLike.dataset.cityid;

let heart = divCityLike.querySelector('i');
heart.addEventListener('click', changeHeart);

function changeHeart(evt) {
  evt.preventDefault();
  let url = '/api/v1/city/' + cityId + '/like'

  fetch(url, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'Accept': 'application/json'
    }
  })
    .then(
      (response) => {

        if (response.status == 200) {
          console.log(response.status + ' - opération effectuée');
          return response.json();
        }
        else {
          console.log(response.status + 'L\'opération a échoué');
        }
      })
    .then(
      (data) => {

        let icone = evt.target;

        if (icone.classList.contains('fa-heart-o')) {
          icone.setAttribute("class", "em em-heart");
        }
        else {
          icone.setAttribute("class", "fa fa-heart-o");
        }

      }
    );

}

// Translatation of the summary

let summary = document.querySelector('.city-description').dataset.summary;

fetch('/translate/', {
  method: 'POST',
  body: JSON.stringify(summary),
  headers: {
    'Content-type': 'application/json',
  }
}).then(function (response) {
  if (response.ok) {
    return response.json();
  }
  return Promise.reject(response);
}).then(function (text) {
  //console.log(text);
  //console.log(text.Translation);
  document.querySelector('.city-description').innerHTML = text.Translation;
}).catch(function (error) {
  console.warn('Something went wrong.', error);
});

