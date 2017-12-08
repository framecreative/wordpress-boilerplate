import FastClick from 'fastclick';

export const Site = {

  init: function() {

    FastClick.attach(document.body);

    this.setupSVGs();

  },

  setupSVGs: function() {

    let iconsPath = $(document.body).data('icons');

    if (!iconsPath)
      return;

    $.ajax({url: iconsPath, dataType: 'xml'}).done(function(xml) {

      let sprite = $(xml.documentElement);
      $(document.body).prepend(sprite);
      sprite.hide();
      sprite.attr('aria-hidden', true);

    });

  }
};
