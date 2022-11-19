jQuery(document).ready(function ($) {
    let url = new URL(window.location.href);
    let searchParams = url.searchParams;
    let pageSelect = $('#select-per-page');
    let searchButton = $('#search-form');
    let sortColumn, sortBy;
    searchParams.forEach((item, index) => {
        if (index == "sort_column") {
            sortColumn = "." + item;
        }
        if (index == "sort_by") {
            sortBy = ".sort-" + item;
        }
        if (sortColumn && sortBy) {
            let sortElement = $(sortColumn + " " + sortBy);
            sortElement.addClass('active-item');
        }
    });

    searchButton.on("submit", function (e) {
        e.preventDefault();
        params = searchButton.serialize();
        let url = new URL(window.location.origin + window.location.pathname + "?" + params);
        let newPath = formatUrl(url.searchParams, []);
        window.location.href = window.location.pathname + newPath.slice(0, -1);
    });

    pageSelect.on("change", function (e) {
        e.preventDefault();
        let perPageSelect = pageSelect.val();
        let currentPage = pageSelect.attr('current-page');
        let lastPage = pageSelect.attr('last-page');
        let newPath = formatUrl(searchParams, ['page', 'per_page']);
        // if (currentPage >= lastPage) {
        newPath += `page=1&per_page=${perPageSelect}`;
        // } else {
        //   newPath += `page=${currentPage}&per_page=${perPageSelect}`;
        // }
        window.location.href = window.location.pathname + newPath;
    });

    $(".sort-asc").click(function (e) {
        let sortColumn = e.target.parentNode.className;
        let sortBy = "ASC";
        let newPath = formatUrl(searchParams, ['sort_by', 'sort_column']);
        newPath += `sort_by=${sortBy}&sort_column=${sortColumn}`;
        window.location.href = window.location.pathname + newPath;
    });

    $(".sort-desc").on("click", function (e) {
        let sortColumn = e.target.parentNode.className;
        let sortBy = "DESC";
        let newPath = formatUrl(searchParams, ['sort_by', 'sort_column']);
        newPath += `sort_by=${sortBy}&sort_column=${sortColumn}`;
        window.location.href = window.location.pathname + newPath;
    });

    function formatUrl(searchParams, params = []) {
        let newSearchParams = "?";
        searchParams.forEach((item, index) => {
            if (item && !params.includes(index) && !newSearchParams.includes(index)) {
                newSearchParams += index + "=" + encodeURIComponent(item) + "&";
            }
        });

        return newSearchParams;
    }

    $("#search-form input").keyup(e => {
        if (e.which === 13) {
            $('#search-form').submit();
        }
    });

    $("#search-form select").change(e => {
        $('#search-form').submit();
    });

    $("#search-form .search-calendar").click(e => {
        $('#search-form').submit();
    });
});
