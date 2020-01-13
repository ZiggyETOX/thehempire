/**
 * @file
 * Provides a collapsible show/hide type menu behaviour to menus in the sidebar
 */

Drupal.behaviors.myDashboardMenu = {
  attach: function (context) {
    var menu = jQuery('.menu--jse-dashboard'),
        icon = jQuery('.contextual-icon'),
        activePageLink = menu.find('a.is-active');

    // add relevant classes and hide menus
    // menu.find('ul.menu-level-0 > li > .contextual-icon').addClass('is-active');
    menu.find('ul.menu-level-1, ul.menu-level-2, ul.menu-level-3, ul.menu-level-4').hide();
    menu.find('.menu-item--active-trail > div > ul.menu').show();
    menu.find('.menu-item--active-trail > .contextual-icon').addClass('is-active');

    // on click
    icon.on('click', function() {

      var $self = jQuery(this),
          targetMenu = $self.siblings('.menu-dropdown').find('> .menu');

      $self.toggleClass('is-active');

      if ($self.hasClass('is-active')) {
        targetMenu.show();
      } else {
        targetMenu.hide();
      }

    });

  }
};