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



// Script to like an user 


let spanLike = document.querySelector('.user-like');
let connectedUserId = spanLike.dataset.connecteduser;
let targetedUserId = spanLike.dataset.targeteduser;

let heart = spanLike.querySelector('i');
heart.addEventListener('click', changeHeart);

function changeHeart(evt) 
{
    evt.preventDefault();
    let url = '/api/v1/user/'+ targetedUserId;

      fetch(url, {
        method: 'POST',
        headers : { 
          'Content-Type': 'application/json',
          'Accept': 'application/json'
        }
        })
        .then(
        (response) => {

            if(response.status == 200) 
            {
              console.log(response.status + ' - opération effectuée');
              return response.json();
            }
            else 
            {
              console.log(response.status + 'L\'opération a échoué');
            }
        })
        .then(
          (data) => {

                let icone = evt.target;

                if (icone.classList.contains('fa-heart-o'))
                {
                  icone.setAttribute("class", "em em-heart");
                }
                else 
                {
                  icone.setAttribute("class", "fa fa-heart-o");
                }

          }
        );

}

