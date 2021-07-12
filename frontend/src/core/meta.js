const Meta = {

    init() {
        this.metaTitle("Open Source Wiki for Busy Devs - Wikipeep")
        this.metaCopyright()
    },
   
   /**
    * Set or retrieve the meta title based on current screen.
    * 
    * @param {String} newTitle
    * 
    * @return {Void} [description]
    */
    metaTitle: (newTitle) => {
        return newTitle ? document.title = newTitle : document.title
    },

    /**
     * When enabled, it will insert the given social links
     * @return {Void}
     */
    metaSocial() {

    },

    /**
     * Set the copyright of current Wikipeep instance
     * @return {Void}
     */
    metaCopyright() {

    },
}

export default Meta