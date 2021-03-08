
        document.querySelector('form').addEventListener('submit',function(evt) {
            evt.preventDefault();
            document.querySelector('input').value = '';
        }, true)



        console.log('run searchBar...');
        //example
        //stretched-link

        function createCardSuggestionCity(cityName, countryName, urlCity) {
            //cible le template
            let tplElt = document.getElementById('template__elt');
            //fait un clone où je vais insérer du contenu
            let tpl = tplElt.content.cloneNode(true);

            //author.startListenerKeyUp();

            //remplissage des données
            console.log(tpl.querySelector(".card-body"));
            tpl.querySelector(".card-body").innerHTML = '<a class="stretched-link" href="' + urlCity + '"><b>' + cityName + '</b>, ' + countryName + '</a>';
            //tpl.querySelector('a').addEventListener("click",function() { console.log("ok") });
            //insertion dans le DOM
            document.getElementById("search-results").appendChild(tpl);
        }

        // Clear the result div when clicking somewhere else, except on listed element in the stackoverflow resource
        document.getElementById('search').onblur = function (evt)
        { 
            let searchError = document.getElementById('search-error');
            let target = evt.relatedTarget; // https://stackoverflow.com/questions/42764494/blur-event-relatedtarget-returns-null
            
            if(target != null) {
                target.click();
            }

            document.getElementById('search').value = '';
            document.querySelector('#search-results').innerHTML = '';
            document.getElementById('search').style.boxShadow = 'none';
            searchError.classList.remove('search-error-show');
            searchError.classList.add('search-error-hidden');
        }  

        // Clear the result div when clicking on 'x' to erase search
        document.getElementById('search').onsearch = function (evt)
        { 
            let searchError = document.getElementById('search-error');
            document.querySelector('#search-results').innerHTML = '';
            document.getElementById('search').style.boxShadow = 'none';
            searchError.classList.remove('search-error-show');
            searchError.classList.add('search-error-hidden');
        }

        function loop(data) {
            console.log(data);
            for (let i = 0; i < data.length; i++) {

                let inputValue = '';

                if(data[i].cityName)
                {
                    console.log(data[i].cityName);
                    createCardSuggestionCity(data[i].cityName, data[i].countryName, data[i].urlCity);
                    console.log(data[i].cityName);
                }
                else
                {
                    let searchError = document.getElementById('search-error');
                    searchError.classList.add('search-error-show');
                    searchError.classList.remove('search-error-hidden');
                    searchError.style.fontSize = "0.9em";
                    searchError.style.position = "absolute";
                    searchError.style.left = "50%";
                    searchError.style.transform = "translateX(-50%)";
                    searchError.style.color = "red";

                    inputValue = document.getElementById('search').value;
                    console.log(inputValue);
                    document.getElementById('search').style.boxShadow = "0px 0px 3px 0px rgba(207, 16, 16, 1)";

                    document.getElementById('search').onfocus = function ()
                    {
                        document.getElementById('search').value = '';
                        document.getElementById('search').style.boxShadow = "0px 0px 3px 0px rgba(87, 130, 78, 1)";
                    } 
                }

                
            }

        }



        const inputElt = document.getElementById('search');

        // Function used to add delay on ajax request. 
        const debounce = (func, delay) => { 
            let debounceTimer 
            return function() { 
                const context = this
                const args = arguments 
                    clearTimeout(debounceTimer) 
                        debounceTimer 
                    = setTimeout(() => func.apply(context, args), delay) 
            } 
        }  

        inputElt.addEventListener('keyup', debounce(handleKeyUp, 500));
        let city;

        function handleKeyUp(evt)
        {
            city = evt.target.value;

            if(!city)
            {   
                let searchError = document.getElementById('search-error');
                document.getElementById('search').style.boxShadow = "0px 0px 3px 0px rgba(87, 130, 78, 1)";
                searchError.classList.remove('search-error-show');
                searchError.classList.add('search-error-hidden');
            }

            if (city.length > 2) {
                query(city);
            }

            document.getElementById("search-results").innerHTML = '';

            function query(city) {
                fetch('/api/city?city_name=' + city)
                    .then(
                        (response) => {
                            return response.status == 200 ?
                                (
                                    console.log(response.status + ' - opération effectuée' + ' ' + city),
                                    response.json()
                                )
               
                                :
                                (response.status === 204) ? response.status + ' - pas de resultats'

                                    :
                                    console.log('L\'opération a échoué')
                        })
                    .then(
                        (data) => {
                            console.log(data);
                            
                            if (data !== 204) {
                                loop(data); 
                            }
                        }
                    );
            }


        }