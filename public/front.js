// const adapter = new LocalStorage('wikipeepSearchDB')
// const LowDB = low(adapter)

const LocalDatabase = new Dexie("wikipeepSearchDB");

/**
 * Highlight current contents while in reading mode
 */
function onScroll(event){
    var sections = document.querySelectorAll('#contents--sidebar a');
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

window.document.addEventListener('scroll', onScroll );

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
    await fetch('/search/search-results.json').then(function (response) {
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
 * Initialize the juice
 */
document.addEventListener('DOMContentLoaded', function() {

    // Creating the Local Indexed Database which stores
    // local to user's browser all the search indexes for fast results.
    LocalDatabase.version(1).stores({
        search_results: "++id,title,slug,excerpt"
    });

    // Make the search bar input focusable on pressing slash key
    searchbarFocus('searchbar--input')
    // Make external links opening in a new tab on the fly
    targetBlankLinks()
});

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
        // results: (list) => {
        //     // Filter duplicates
        //     const filteredResults = Array.from(new Set(list.map((value) => value.match))).map((title) => {
        //         return list.find((value) => value.match === title);
        //     });

        //     return filteredResults;
        // },
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
            // source.innerHTML = data.match;
        },
        element: "li"
    },
    noResults: (dataFeedback, generateList) => {
        // Generate autoComplete List
        generateList(autoCompleteJS, dataFeedback, dataFeedback.results);
        // No Results List Item
        const result = document.createElement("li");
        result.setAttribute("class", "no_result");
        result.setAttribute("tabindex", "1");
        result.innerHTML = `<span style="display: flex; align-items: center; font-weight: 100; color: rgba(0,0,0,.2);">Found No Results for "${dataFeedback.query}"</span>`;
        document.querySelector(`#${autoCompleteJS.resultsList.idName}`).appendChild(result);
    },
    onSelection: feedback => {
        document.querySelector("#searchbar--input").blur();

        let slug = feedback.selection.value.slug;
            window.location.href = slug;
    }
});
