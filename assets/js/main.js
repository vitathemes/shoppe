const closePopup = () => {
    const popup = document.querySelector('.js-popup');
    popup.classList.remove('is-open');
};

const openPopup = () => {
    const popup = document.querySelector('.js-popup');
    popup.classList.add('is-open');
};

if (document.querySelector('.js-search-btn')) {
const shelly_searchBtnToggle = document.querySelector('.js-search-btn');
const shelly_searchBtnClose = document.querySelector('.js-popup-close');

shelly_searchBtnToggle.addEventListener('click', openPopup);
shelly_searchBtnClose.addEventListener('click', closePopup);
}

const selectCarouselSlide = (carousel, index) => {
    const flkty = Flickity.data(carousel);
    flkty.select(index);
};

const accountCarouselNavActiveItem = (e) => {
    const target = e.target;
    document.querySelectorAll('.js-account-carousel-btn').forEach((el) => {
        el.classList.remove('is-active');
    });
    target.classList.add('is-active');
};

document.querySelectorAll('.js-account-carousel-btn').forEach((el) => {
    el.addEventListener('click', (el) => {
        accountCarouselNavActiveItem(el)
    });
});

if (document.querySelectorAll('.js-woocommerce-review-form').length) {
    const reviewsStickyForm = new Sticky('.js-woocommerce-review-form');
}

if (document.querySelectorAll('.js-cart-total').length) {
    const cartTotalSticky = new Sticky('.js-cart-total');
}

const closeFiltersPopup = () => {
    const popup = document.querySelector('.js-popup-filters');
    popup.classList.remove('is-open');
};

const openFiltersPopup = () => {
    const popup = document.querySelector('.js-popup-filters');
    popup.classList.add('is-open');
};
