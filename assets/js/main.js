const closePopup = () => {
    const popup = document.querySelector('.js-popup');
    popup.classList.remove('is-open');
};

const openPopup = () => {
    const popup = document.querySelector('.js-popup');
    popup.classList.add('is-open');
};

if (document.querySelector('.js-search-btn')) {
    const shoppe_searchBtnToggle = document.querySelector('.js-search-btn');
    const shoppe_searchBtnClose = document.querySelector('.js-popup-close');

    shoppe_searchBtnToggle.addEventListener('click', openPopup);
    shoppe_searchBtnClose.addEventListener('click', closePopup);
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

document.querySelectorAll('.js-popup').forEach(popup => {
    document.addEventListener('keydown', e => {
        if (e.key === "Escape") {
            document.querySelectorAll('.js-popup').forEach(popupEl => {
                popupEl.classList.remove('is-open');
            });
        }
    });
});
