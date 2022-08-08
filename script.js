$(window).on('load', function () {
    $('.menu-button').on('click', function () {
        $('body').toggleClass('menu-shown')
        $('.menu-button').toggleClass('trigger')
        $('.wrapper .sidebar').toggleClass('show-menu')
    })
})