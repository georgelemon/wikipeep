/**
 * Initialize IndexedDB with Dexie.js
 * @see https://github.com/dfahlander/Dexie.js
 */

function getAppUrl(path)
{
    return __settings.app_url + path;
}

const LocalDatabase = new Dexie("wikipeepSearchDB"),
      SearchEndpoint = getAppUrl(__settings.api_base + '/' + __settings.search_endpoint),
      __searchVersion = __settings.latest_search_update;

let toggleElement;

/**
 * Highlight current contents while in reading mode
 */
function onScroll(event){
    var sections = document.querySelectorAll('#contents--sidebar li a');
    var scrollPos = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop;

    for (var i = 0; i < sections.length; i++ ) {

        let current = sections[i],
            val = current.getAttribute('href'),
            refElement = document.querySelector(val);
        
        if( refElement.offsetTop - 50 <= scrollPos ){
        // if( refElement.offsetTop - 50 <= scrollPos && ( refElement.offsetTop + refElement.offsetHeight > scrollPos) ){
            document.querySelector('#contents--sidebar li a').classList.remove('active');
            
            sections.forEach(function(contentNavItem){
                contentNavItem.classList.remove('active');
            });

            current.classList.add('active');
        } else {

            // refElement.classList.remove('active')
            current.classList.remove('active');
        }
    }     

};

/**
 * Focusing the search bar input when pressing the / key
 */
function searchbarFocus(element)
{
    searchBarElement = document.getElementById(element);
    document.addEventListener("keydown", event => {
        if (event.keyCode === 191) {
            event.preventDefault()
            searchBarElement.focus()
        }
    });
}

/**
 * Creates the toggle element that
 * brings back content summary sidebar.
 */
function getSummaryRevealBtn()
{
    // return the element in case is already created
    if( toggleElement ) return toggleElement;

    toggleElement = document.createElement("a");
    let toggleElementIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"><line x1="21" y1="10" x2="7" y2="10"></line><line x1="21" y1="6" x2="3" y2="6"></line><line x1="21" y1="14" x2="3" y2="14"></line><line x1="21" y1="18" x2="7" y2="18"></line></svg>';

    toggleElement.setAttribute('class', 'btn position-absolute')
    toggleElement.setAttribute('id', 'contents--summary--reveal')

    toggleElement.innerHTML = toggleElementIcon;

    return toggleElement;
}

/**
 * While in reading mode, summary contents can be toggle
 * for a better reading experience.
 */
function toggleSummaryContents(triggerId, wrapperId, articleWrapperId = 'article--side')
{
    let toggleButton = document.getElementById(triggerId),
        summaryWrapper = document.getElementById(wrapperId),
        articleWrapper = document.getElementById(articleWrapperId);

    if( toggleButton === null ) {
        return;
    }

    toggleButton.addEventListener('click', function(e) {
        e.preventDefault();
        summaryWrapper.classList.add('d-none')
        articleWrapper.prepend(getSummaryRevealBtn())

        if( articleWrapper.classList.contains('offset-lg-2') ) {
            articleWrapper.setAttribute('class', 'col-lg-12')
        }
        summaryWrapper.classList.add('--hide')
    });

    getSummaryRevealBtn().addEventListener('click', function(e){
        e.preventDefault();
        summaryWrapper.classList.remove('d-none')
        articleWrapper.setAttribute('class', 'col-lg-10 offset-lg-2')
        getSummaryRevealBtn().remove();
    })
}

/**
 * Add automatically target blank for external links
 */
function targetBlankLinks() {

    let internal = location.host.replace("www.", "");
    internal = new RegExp(internal, "i");
      
    let a = document.getElementsByTagName('a');
    
    for (var i = 0; i < a.length; i++) {
        let href = a[i].host;
        if( !internal.test(href) ) {
            a[i].setAttribute('target', '_blank');
        }
    }
};

/**
 * 
 * It use LowDB API in order to store the entire search
 * resuls directly in user's browser for super fast results.
 */
async function updateBrowserLocalStorage()
{
    let results = await LocalDatabase.search_results.orderBy('title').toArray();
    // let toBeUpdated = true;

    if( results.length === 0 ) {        
        await fetchSearchResults();
        results = await LocalDatabase.search_results.orderBy('title').toArray();
    } else {
        console.info("%c Serve search results from Indexed Database", 'padding:5px; border-radius:25px; background: lightblue; color: black');
    }

    return results;
}

// Fetching the search results database and prepare
// for storing as Local Storage to the user's browser.
async function fetchSearchResults()
{
    await fetch(SearchEndpoint, {
        method: 'GET',
        cache: 'force-cache'
    }).then(function(response) {
        return response.json();
    }).then(function (getSearchData) {
        LocalDatabase.search_results.bulkAdd(getSearchData).then(function() {
            return LocalDatabase.search_results.orderBy('title').toArray();
        }).then(function (results) {
            console.info("%c Local Database successfuly initiated:", 'padding:5px; border-radius:25px; background: blue; color: white');
            console.log(results);
        }).catch(function (e) {
            console.log("Error: " + (e.stack || e));
        });

    }).catch(function (error) {
        console.warn('Error while fetching database search results with the browser...', error);
    });
}

/**
 * Setup Autocomplete 
 * @see https://github.com/TarekRaafat/autoComplete.js
 */
const autoCompleteJS = new autoComplete({
    data: {
      src: async () => {
            // Creating or getting search data from Indexed Database via user's browser
            const source = await updateBrowserLocalStorage();
            // Format data into JSON
            const data = await source;
            // Return Fetched data
            return data;
    },
    key: ["title"],
        results: (list) => {
            // console.log(list);
            // Filter duplicates
            // const filteredResults = Array.from(new Set(list.map((value) => value.match))).map((title) => {
            //     return list.find((value) => value.match === title);
            // });

            return list;
        },
        cache: false
    },
    sort: (a, b) => {                    // Sort rendered results ascendingly | (Optional)
        if (a.match < b.match) return -1;
        if (a.match > b.match) return 1;
        return 0;
    },
    selector: "#searchbar--input",
    // observer: true,
    threshold: 3,
    debounce: 170,
    searchEngine: "loose",
    resultsList: {
        container: source => {
            source.setAttribute("id", "list");
        },
        destination: "#searchbar--input",
        position: "afterend",
        element: "ul"
    },
    maxResults: 10,
    highlight: false,
    resultItem: {
        content: (data, source) => {
            let excerpt = data.value.excerpt ? '<span class="search--item--excerpt">' + data.value.excerpt + '</span>' : '',
                title = '<span class="search--item--title">' + data.value.title + '</span>',
                slug = '<code class="d-block"><small>' + data.value.slug + '</small></code>';

            source.innerHTML = title + excerpt + slug;
        },
        element: "li"
    },
    noResults: (dataFeedback, generateList) => {
        // Generate autoComplete List
        generateList(autoCompleteJS, dataFeedback, dataFeedback.results);
        // No Results List Item
        const result = document.createElement("li");
        result.setAttribute("class", "no_result d-block");
        result.setAttribute("tabindex", "1");
        result.innerHTML = `<span class="font-weight-normal">Couldn't find anything related to <code>"${dataFeedback.query}"</code></span>`;

        document.querySelector('#searchbar--area ul').appendChild(result);
    },
    onSelection: feedback => {
        document.querySelector("#searchbar--input").blur();

        let slug = "/" + feedback.selection.value.slug;
            window.location.href = slug;
    }
});

/**
 * Creating the Theme switcher
 */
function appThemeSwitcher(buttonElement) {

    // Automatically switch to a preferred theme according to the OS theme preference.
    let autoPreferredTheme,
        cookieSettings = {
            secure: false,
            expires: 7,
            path: '/'
        };

    if( ! cookie('appearance') ) {
        autoPreferredTheme = (matchMedia('(prefers-color-scheme: dark)').matches ? 'theme-dark' : 'theme-light');
        cookie.set('appearance', autoPreferredTheme, cookieSettings);
    } else {
        autoPreferredTheme = cookie.get('appearance');
    }

    let BodyClass = document.body.classList;
        BodyClass.add(autoPreferredTheme);

    document.getElementById(buttonElement).addEventListener('click', function(event) {

            let btn = event.currentTarget;
                btn.classList.toggle('lights_on');
            
            // Adding a temporary class for creating a fluent transition between themes
            BodyClass.add('switching-theme');

            if( BodyClass.contains('theme-dark') ) {
                BodyClass.toggle('theme-dark');
                BodyClass.add('theme-light');
                // update cookie with the light theme
                cookie.set('appearance', 'theme-light', cookieSettings);

            } else {
                BodyClass.toggle('theme-light');
                BodyClass.add('theme-dark');
                // update cookie with the dark theme
                cookie.set('appearance', 'theme-dark', cookieSettings);
            }

        });
}

/**
 * Initialize the juice
 */
document.addEventListener('DOMContentLoaded', function() {

    // Creating the Local Indexed Database which stores
    // local to user's browser all the search indexes for fast results.
    LocalDatabase.version(2).stores({
        search_results: "++id,title,slug,excerpt"
    });

    // Enable the Theme Switcher
    appThemeSwitcher('app--theme--switcher');
    // Enable toggle switcher while in reading mode
    toggleSummaryContents('summary--trigger', 'sidebar--summary-wrapper')
    // Make the search bar input focusable on pressing slash key
    searchbarFocus('searchbar--input')
    // Make external links opening in a new tab on the fly
    targetBlankLinks()
    // highlight the available code syntax
    hljs.initHighlightingOnLoad()
});

window.document.addEventListener('scroll', onScroll );
