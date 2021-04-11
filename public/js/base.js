// Script for l'overlay navigation 
            
            function openNav() {
                document.getElementById("myNav").style.width = "100%";
            }

            function closeNav() {
                document.getElementById("myNav").style.width = "0%";
            }
            

            // Script for collapsed menu 
         
            if(document.querySelector('.overlay-content').dataset.userlogged == "true")
            {
                            let profileButton = document.getElementById("profileButton");
            profileButton.setAttribute('class', 'undeployed')
            
            profileButton.addEventListener('click', displayElements);
            
            let allDisabledMenus = document.querySelectorAll(".disabled-menu");
            allDisabledMenus.forEach(
                function(disabledMenu)
                {
                    disabledMenu.style.display = "none";
                }
            )

            function displayElements()
            {
                let rightChevron = document.querySelector('.fa-chevron-right');
                
                if(profileButton.matches('.undeployed'))
                {
                    rightChevron.style.display = "none";
                    allDisabledMenus.forEach(
                    function(disabledMenu)
                    {
                        disabledMenu.style.display = "inline-block";
                        profileButton.classList.remove('undeployed');
                        profileButton.classList.add('deployed');

                    })
                }
                else
                {
                    profileButton.classList.remove('deployed');
                    profileButton.classList.add('undeployed');

                    let downChevron = document.querySelector('.fa-chevron-down');

                    downChevron.style.display = "none";
                    rightChevron.style.display = "inline-block";

                    allDisabledMenus.forEach(
                    function(disabledMenu)
                    {
                        disabledMenu.style.display = "none";

                    })

                }

            }
            }
            