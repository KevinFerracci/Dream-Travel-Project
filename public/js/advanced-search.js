
    const inputElt = document.getElementById('advanced_search_search');
    console.log('run searchBarCountry...');
    //example
    //stretched-link

    function createCardSuggestionCountry(countryName) {
        //cible le template
        let tplElt = document.getElementById('template__elt');
        //fait un clone où je vais insérer du contenu
        let tpl = tplElt.content.cloneNode(true);

        //author.startListenerKeyUp();

        //remplissage des données
        //console.log(tpl.querySelector(".card-body"));
        tpl.querySelector(".card-body-country").innerHTML = '<b>' + countryName + '</b>';
        //insertion dans le DOM
        document.getElementById("search-results").appendChild(tpl);
    }

    // Clear the result div when clicking somewhere else, except on listed element in the stackoverflow resource
    document.getElementById('advanced_search_search').onblur = function (evt)
    { 
        let searchError = document.getElementById('search-error');
        let target = evt.relatedTarget; // https://stackoverflow.com/questions/42764494/blur-event-relatedtarget-returns-null
        if(target != null) {
            target.click();
        }
        else   
        {
            document.getElementById('advanced_search_search').value = '';
            document.querySelector('#search-results').innerHTML = '';
            document.getElementById('advanced_search_search').style.boxShadow = 'none';
            searchError.classList.remove('search-error-show');
            searchError.classList.add('search-error-hidden');
        }
    }  

    // Clear the result div when clicking on 'x' to erase search
    document.getElementById('advanced_search_search').onsearch = function (evt)
    { 
        let searchError = document.getElementById('search-error');
        document.querySelector('#search-results').innerHTML = '';
        document.getElementById('advanced_search_search').style.boxShadow = 'none';
        searchError.classList.remove('search-error-show');
        searchError.classList.add('search-error-hidden');
    }

    function handleClickOnCountry(evt) {
        inputElt.value = evt.target.querySelector('b').textContent;
        document.querySelector('#search-results').innerHTML = "";
    }


    function loop(data) {
        console.log(data);
        for (let i = 0; i < data.length; i++) {

            let inputValue = '';

            if (data[i].countryName) {
                createCardSuggestionCountry(data[i].countryName);
                console.log(data[i].countryName);

                let cardBodies = document.querySelectorAll('.link-to-country');
                cardBodies.forEach(
                    function (cardBody) {
                        cardBody.addEventListener('click', handleClickOnCountry);
                    }
                )

            }
            else {
                let searchError = document.getElementById('search-error');
                searchError.classList.add('search-error-show');
                searchError.classList.remove('search-error-hidden');
                searchError.style.fontSize = "0.9em";
                searchError.style.position = "absolute";
                searchError.style.left = "50%";
                searchError.style.transform = "translateX(-50%)";
                searchError.style.color = "red";

                inputValue = document.getElementById('advanced_search_search').value;
                console.log(inputValue);
                document.getElementById('advanced_search_search').style.boxShadow = "0px 0px 3px 0px rgba(207, 16, 16, 1)";

                document.getElementById('advanced_search_search').onfocus = function () {
                    document.getElementById('advanced_search_search').value = '';
                    document.getElementById('advanced_search_search').style.boxShadow = "0px 0px 3px 0px rgba(87, 130, 78, 1)";
                    searchError.classList.remove('search-error-show');
                    searchError.classList.add('search-error-hidden');
                }
            }
        }
    }

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
    let country;
    function handleKeyUp(evt) {
        country = evt.target.value;

        if(!country)
        {   
            let searchError = document.getElementById('search-error');
            document.getElementById('advanced_search_search').style.boxShadow = "0px 0px 3px 0px rgba(87, 130, 78, 1)";
            searchError.classList.remove('search-error-show');
            searchError.classList.add('search-error-hidden');
        }

        if (country.length > 1) {
            query(country);
        }
        document.getElementById("search-results").innerHTML = '';

        function query(country) {
            fetch('/api/country?country_name=' + country)
                .then(
                    (response) => {
                        return response.status == 200 ?
                            (
                                console.log(response.status + ' - opération effectué'),
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

    let resetButton = document.querySelector('.form-reset')
    resetButton.addEventListener('click', handleClickOnReset)

    function handleClickOnReset(evt) {
        evt.preventDefault();
        document.getElementById('advanced_search_search').value = '';
        document.getElementById('advanced_search_startDate').value = '';
        document.getElementById('advanced_search_endDate').value = '';
        document.getElementById('advanced_search_language').value = 1;
        document.getElementById('advanced_search_temperature').value = 3;
        document.getElementById('advanced_search_cost').value = 6;
        document.getElementById('advanced_search_area').value = 8;

    }

