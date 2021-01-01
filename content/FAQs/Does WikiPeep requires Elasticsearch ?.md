# Does WikiPeep requires Elasticsearch?
No way. WikiPeep has zero dependency related to the search functionality, except Flywheel, Symfony Console and two pure vanilla JS plugins, Dexie.js & the AutoComplete and all these comes packed with your WikiPeep copy.

## How is possible to have such a fast search?
Thanks to IndexedDB feature that lives in your modern browser, and Dexie.js which makes easy to work with IndexedDB API.

IndexedDB is a low-level API for client-side storage of significant amounts of structured data, including files/blobs. This API uses indexes to enable high-performance searches of this data. While Web Storage is useful for storing smaller amounts of data, it is less useful for storing larger amounts of structured data. IndexedDB provides a solution. This is the main landing page for MDN's IndexedDB coverage — here we provide links to the full API reference and usage guides, browser support details, and some explanation of key concepts
[More about IndexedDB and its usability on Mozilla](https://developer.mozilla.org/en-US/docs/Web/API/IndexedDB_API)