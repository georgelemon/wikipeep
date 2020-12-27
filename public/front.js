
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
 * Add automatically target blank for externallinks
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
 * Initialize the juice
 */
document.addEventListener('DOMContentLoaded', function() {
    searchbarFocus('searchbar--input')
    targetBlankLinks()
});

/**
 * Autocomplete
 */
const autoCompleteJS = new autoComplete({
    data: {                              // Data src [Array, Function, Async] | (REQUIRED)
      src: async () => {
        // API key token
        // const token = "this_is_the_API_token_number";
        // User search query
        // const query = document.querySelector("#autoComplete").value;
        // Fetch External Data Source
        const source = await fetch('/search-data.json');
        // Format data into JSON
        const data = await source.json();
        // Return Fetched data
        return data;
      },
      key: ["VillaName"],
      cache: false
    },
    query: {                             // Query Interceptor               | (Optional)
          // manipulate: (query) => {
          //   return query.replace("pizza", "burger");
          // }
    },
    sort: (a, b) => {                    // Sort rendered results ascendingly | (Optional)
        if (a.match < b.match) return -1;
        if (a.match > b.match) return 1;
        return 0;
    },
    placeHolder: "Search for villas...",     // Place Holder text                 | (Optional)
    selector: "#autoComplete",           // Input field selector              | (Optional)
    observer: true,                      // Input field observer | (Optional)
    threshold: 3,                        // Min. Chars length to start Engine | (Optional)
    debounce: 300,                       // Post duration for engine to start | (Optional)
    searchEngine: "strict",              // Search Engine type/mode           | (Optional)
    resultsList: {                       // Rendered results list object      | (Optional)
        container: source => {
            source.setAttribute("id", "list");
        },
        destination: "#autoComplete",
        position: "afterend",
        element: "ul"
    },
    maxResults: 5,                         // Max. number of rendered results | (Optional)
    highlight: true,                       // Highlight matching results      | (Optional)
    resultItem: {                          // Rendered result item            | (Optional)
        content: (data, source) => {
            source.innerHTML = data.VillaName;
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
    onSelection: feedback => {             // Action script onSelection event | (Optional)
        console.log(feedback.selection.value);
    }
});