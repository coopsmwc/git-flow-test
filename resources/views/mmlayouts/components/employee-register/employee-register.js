$('.onboarding-slider').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    dots: true,
    arrows: false
});

$('.onboarding .btn-primary').on('click', function (e) {
    e.preventDefault();
    const elm = document.querySelector('#account-form');
    $('html,body').animate({
        scrollTop: $(elm).offset().top
    });
});

var fauxCheckboxes = document.querySelectorAll('.faux-checkbox');
var initCheckboxes = this.initCheckboxes.bind(this);
this.init();

function init() {
    this.initCheckboxes();
}

function initCheckboxes() {
    Array.from(this.fauxCheckboxes).map((checkbox) => {
        checkbox.addEventListener('click', (e) => {
            const target = e.currentTarget;
            const input = target.parentNode.querySelector('input');
            const isChecked = target.getAttribute('data-checked');
            if (isChecked === 'true') {
                input.setAttribute('checked', false);
                input.setAttribute('value', 0);
                target.setAttribute('data-checked', false);
            } else {
                input.setAttribute('checked', true);
                input.setAttribute('value', 1);
                target.setAttribute('data-checked', true);
            }
        });
    });
}