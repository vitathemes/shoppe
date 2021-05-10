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


var shelly_menuToggle = document.querySelector('.js-header-menu-toggle');
var shelly_menuSearch = document.querySelector('.c-search-form__label__field');
var shelly_menuSearchBtn = document.querySelector('.c-search-form__submit');
var shelly_menu = document.querySelector('.js-header-nav');
var shelly_menuLinks = shelly_menu.getElementsByTagName('a');
var shelly_menuListItems = shelly_menu.querySelectorAll('li');

var shelly_focus, shelly_isToggleItem, shelly_isBackward;
var shelly_lastIndex = shelly_menuListItems.length - 1;
var shelly_lastParentIndex = document.querySelectorAll('.js-header-nav > ul > li').length - 1;
document.addEventListener('focusin', function () {
    shelly_focus = document.activeElement;
    if (shelly_isToggleItem && shelly_focus !== shelly_menuLinks[0]) {
        document.querySelectorAll('.js-header-nav > ul > li')[shelly_lastParentIndex].querySelector('a').focus();
    }

    if (shelly_focus === shelly_menuToggle) {
        shelly_isToggleItem = true;
    } else {
        shelly_isToggleItem = false;
    }
}, true);

document.addEventListener('keydown', function (e) {
    if (e.shiftKey && e.keyCode == 9) {
        shelly_isBackward = true;
    } else {
        shelly_isBackward = false;
    }
});

for (el of shelly_menuLinks) {
    el.addEventListener('blur', function (e) {
        if (shelly_isBackward) {
            if (e.target === shelly_menuLinks[0]) {
                shelly_menuSearchBtn.focus();
            }
        } else {
			if (e.target === shelly_menuLinks[shelly_lastIndex]) {
				shelly_menuToggle.focus();
			}
		}
    });
}

shelly_menuSearch.addEventListener('blur', function (e) {
    if (shelly_isBackward) {
        shelly_menuToggle.focus();
    } else {
        if (document.querySelector('.js-header-menu.is-open')) {
            shelly_menuSearchBtn.focus();
        }
    }
});

shelly_menuSearchBtn.addEventListener('blur', function (e) {
    if (shelly_isBackward) {
        shelly_menuSearch.focus();
    } else {
        if (document.querySelector('.js-header-menu.is-open')) {
            shelly_menuLinks[0].focus();
        }
    }
});

shelly_menuToggle.addEventListener('blur', function (e) {
    if (shelly_isBackward) {
        shelly_menuLinks[shelly_lastIndex].focus();
    } else {
        console.log(document.querySelector('.js-header-menu.is-open'));
        console.log(shelly_menuSearch.focus());
        if (document.querySelector('.js-header-menu.is-open')) {

        }
    }
});
