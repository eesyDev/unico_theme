(function () {
    'use strict';

    const searchInput    = document.querySelector('.header-search__input');
    const searchClose    = document.querySelector('.header-search__close');
    const searchResults  = document.getElementById('header-search-results');

    if (!searchInput || !searchResults) return;

    let timer = null;

    function renderResults(items) {
        if (!items.length) {
            searchResults.innerHTML = '<p class="header-search__no-results">Ничего не найдено</p>';
            return;
        }

        const list = items.map(function (item) {
            const img = item.image
                ? '<img src="' + item.image + '" alt="' + item.title + '" class="header-search__result-img">'
                : '<div class="header-search__result-img header-search__result-img--placeholder"></div>';

            return '<li class="header-search__result-item">'
                + '<a href="' + item.url + '" class="header-search__result-link">'
                + img
                + '<div class="header-search__result-info">'
                + '<span class="header-search__result-title">' + item.title + '</span>'
                + '<span class="header-search__result-price">' + item.price + '</span>'
                + '</div>'
                + '</a>'
                + '</li>';
        }).join('');

        searchResults.innerHTML = '<ul class="header-search__results-list">' + list + '</ul>';
    }

    function clearResults() {
        searchResults.innerHTML = '';
        searchResults.classList.remove('is-visible');
    }

    searchInput.addEventListener('input', function () {
        const query = this.value.trim();

        clearTimeout(timer);

        if (query.length < 2) {
            clearResults();
            return;
        }

        searchResults.innerHTML = '<p class="header-search__loading">Поиск...</p>';
        searchResults.classList.add('is-visible');

        timer = setTimeout(function () {
            fetch(unico_ajax.ajax_url + '?action=unico_ajax_search&q=' + encodeURIComponent(query))  
                .then(function (res) { return res.json(); })
                .then(renderResults)
                .catch(clearResults);
        }, 350);
    });

    if (searchClose) {
        searchClose.addEventListener('click', clearResults);
    }
})();
