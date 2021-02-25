/* Script pour afficher une map */

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
    accessToken: 'pk.eyJ1Ijoid2VseXdlbG9vIiwiYSI6ImNrYmFmYXdyYjBubGwycW84ZWJxYWk1MXAifQ.0HxMbJuY3rmSYfS2hmhcVw'
  }).addTo(mymap);

  let marker = L.marker([latitude, longitude]).addTo(mymap);

