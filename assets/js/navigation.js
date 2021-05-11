/**
 * File navigation.js.
 *
 * Handles toggling the navigation menu for small screens and enables TAB key
 * navigation support for dropdown menus.
 */
(function () {
    const siteNavigation = document.querySelector('.js-header-nav');
    const menuWrapper = document.querySelector('.js-header-menu');

    // Return early if the navigation don't exist.
    if (!siteNavigation) {
        return;
    }

    const button = siteNavigation.querySelector('.js-header-menu-toggle');

    // Return early if the button don't exist.
    if ('undefined' === typeof button) {
        return;
    }

    const menu = siteNavigation.getElementsByTagName('ul')[0];

    // Hide menu toggle button if menu is empty and return early.
    if ('undefined' === typeof menu) {
        button.style.display = 'none';
        return;
    }

    if (!menu.classList.contains('nav-menu')) {
        menu.classList.add('nav-menu');
    }

    // Toggle the .toggled class and the aria-expanded value each time the button is clicked.
    button.addEventListener('click', function () {
        siteNavigation.classList.toggle('toggled');
        menuWrapper.classList.toggle('is-open');
        button.classList.toggle('is-active');


        if (button.getAttribute('aria-expanded') === 'true') {
            button.setAttribute('aria-expanded', 'false');
        } else {
            button.setAttribute('aria-expanded', 'true');
        }
    });

    // Remove the .toggled class and set aria-expanded to false when the user clicks outside the navigation.
    document.addEventListener('click', function (event) {
        const isClickInside = siteNavigation.contains(event.target);

        if (!isClickInside) {
            siteNavigation.classList.remove('toggled');
            button.setAttribute('aria-expanded', 'false');
        }
    });

    // Get all the link elements within the menu.
    const links = menu.getElementsByTagName('a');

    // Get all the link elements with children within the menu.
    const linksWithChildren = menu.querySelectorAll('.menu-item-has-children > a, .page_item_has_children > a');

    // Toggle focus each time a menu link is focused or blurred.
    for (const link of links) {
        link.addEventListener('focus', toggleFocus, true);
        link.addEventListener('blur', toggleFocus, true);
    }

    // Toggle focus each time a menu link with children receive a touch event.
    for (const link of linksWithChildren) {
        link.addEventListener('touchstart', toggleFocus, false);
    }

    /**
     * Sets or removes .focus class on an element.
     */
    function toggleFocus() {
        if (event.type === 'focus' || event.type === 'blur') {
            let self = this;
            // Move up through the ancestors of the current link until we hit .nav-menu.
            while (!self.classList.contains('nav-menu')) {
                // On li elements toggle the class .focus.
                if ('li' === self.tagName.toLowerCase()) {
                    self.classList.toggle('focus');
                }
                self = self.parentNode;
            }
        }

        if (event.type === 'touchstart') {
            const menuItem = this.parentNode;
            event.preventDefault();
            for (const link of menuItem.parentNode.children) {
                if (menuItem !== link) {
                    link.classList.remove('focus');
                }
            }
            menuItem.classList.toggle('focus');
        }
    }
}());


var shoppe_menuToggle = document.querySelector('.js-header-menu-toggle');
var shoppe_menuSearch = document.querySelector('.c-search-form__label__field');
var shoppe_menuSearchBtn = document.querySelector('.c-search-form__submit');
var shoppe_menu = document.querySelector('.js-header-nav');
var shoppe_menuLinks = shoppe_menu.getElementsByTagName('a');
var shoppe_menuListItems = shoppe_menu.querySelectorAll('li');

var shoppe_focus, shoppe_isToggleItem, shoppe_isBackward;
var shoppe_lastIndex = shoppe_menuListItems.length - 1;
var shoppe_lastParentIndex = document.querySelectorAll('.js-header-nav > ul > li').length - 1;
document.addEventListener('focusin', function () {
    shoppe_focus = document.activeElement;
    if (shoppe_isToggleItem && shoppe_focus !== shoppe_menuLinks[0]) {
        document.querySelectorAll('.js-header-nav > ul > li')[shoppe_lastParentIndex].querySelector('a').focus();
    }

    if (shoppe_focus === shoppe_menuToggle) {
        shoppe_isToggleItem = true;
    } else {
        shoppe_isToggleItem = false;
    }
}, true);

document.addEventListener('keydown', function (e) {
    if (e.shiftKey && e.keyCode == 9) {
        shoppe_isBackward = true;
    } else {
        shoppe_isBackward = false;
    }
});

for (el of shoppe_menuLinks) {
    el.addEventListener('blur', function (e) {
        if (shoppe_isBackward) {
            if (e.target === shoppe_menuLinks[0]) {
                shoppe_menuSearchBtn.focus();
            }
        } else {
			if (e.target === shoppe_menuLinks[shoppe_lastIndex]) {
				shoppe_menuToggle.focus();
			}
		}
    });
}

shoppe_menuSearch.addEventListener('blur', function (e) {
    if (shoppe_isBackward) {
        shoppe_menuToggle.focus();
    } else {
        if (document.querySelector('.js-header-menu.is-open')) {
            shoppe_menuSearchBtn.focus();
        }
    }
});

shoppe_menuSearchBtn.addEventListener('blur', function (e) {
    if (shoppe_isBackward) {
        shoppe_menuSearch.focus();
    } else {
        if (document.querySelector('.js-header-menu.is-open')) {
            shoppe_menuLinks[0].focus();
        }
    }
});

shoppe_menuToggle.addEventListener('blur', function (e) {
    if (shoppe_isBackward) {
        shoppe_menuLinks[shoppe_lastIndex].focus();
    } else {
        console.log(document.querySelector('.js-header-menu.is-open'));
        console.log(shoppe_menuSearch.focus());
        if (document.querySelector('.js-header-menu.is-open')) {

        }
    }
});
