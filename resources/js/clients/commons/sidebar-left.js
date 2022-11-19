$(function (){
    let url = new URL(window.location.href);
    let searchParams = url.searchParams;
    var newPath;
    const allOptionSkill = $('#list-search-ul-skill');
    const allOptionConsult = $('#list-search-ul-consult');
    const allOption = $('#list-search-ul-fortunetelling');
    // handleEventClickCategory(allOptionSkill);
    // handleEventClickCategory(allOptionConsult);
    // handleEventClickCategory(allOption);
    handleEventClickCategoryType();

    function formatUrl(searchParams, params = []) {
        let newSearchParams = "?";
        searchParams.forEach((item, index) => {
            if (item && !params.includes(index) && !newSearchParams.includes(index)) {
                newSearchParams += index + "=" + encodeURIComponent(item) + "&";
            }
        });
        return newSearchParams;
    }

    function handleEventClickCategory($selector){
        $selector.on('click','li a', function (){
            $selector.removeClass('active');
            $(this).parent('li').addClass('active');
            let categoryId = $(this).parent('li').val();
            const currentUrl = new URL(window.location.href);
            currentUrl.pathname = '/search';
            currentUrl.searchParams.delete('category_type');
            currentUrl.searchParams.set('category_id', categoryId);
            window.location.href = currentUrl.toString();
        });
    }

    function handleEventClickCategoryType() {
        $('.card__input-search').on('click', function (e) {
            if($(e.target).hasClass('arrow-top')){
                e.preventDefault();
            }
            else{
                $('.card__input-search').removeClass('active');
                $(this).addClass('active');
                const categoryType = $(this).attr('value');
                const currentUrl = new URL(window.location.href);
                currentUrl.pathname = '/search';
                currentUrl.searchParams.delete('category_id');
                currentUrl.searchParams.set('category_type', categoryType);
                currentUrl.searchParams.set('page', 1);
                window.location.href = currentUrl.toString();
            }
        });
    }
})
