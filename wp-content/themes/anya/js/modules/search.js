class Search {
    constructor() {
        this.events()
    }

    events() {
        $('#navbar__search--btn').on('click', (e)=> {
            let _this = $(e.currentTarget)
            _this.find('.fas').slideToggle(0)
            $('#navbar__search').slideToggle(0)
            if ($('#navbar__search').is(":visible")) {
                $('#navbar__search--input').focus()
            }

        })
    }

}

export default Search;
