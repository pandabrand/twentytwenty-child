jQuery(function($) {
  var forms = document.querySelectorAll('[id^="form-"]');

  forms.forEach(function(_form) {
     _form.addEventListener('submit', save_everything);
  });
  
  function save_everything(event) {
    event.preventDefault();
    var _form     = event.target;
    var photo     = _form.querySelector('[name="photo_id"]');
    var post      = _form.querySelector('[name="post_id"]');
    var checkbox  = _form.querySelector('[name="keep"]');
    var text      = _form.querySelector('[name="notes"]');
    var paint_row = _form.querySelector('[name="paint_row"]');
    var photo_row = _form.querySelector('[name="photo_row"]');
    
    var data = {
      'action': 'update_image',
      'photo_id': photo.value,
      'post_id': post.value,
      'checkbox': checkbox.checked,
      'text': text.value,
      'paint_row': paint_row.value,
      'photo_row': photo_row.value,
    }
    
    console.log(data);

    $.post( fww_ajax_object.ajax_url, data, function( response ) {
      console.log( response );
      $(text).notify( response, {autoHideDelay: 3000, className: 'success'} )
    } )
  }
});

var carousels = document.querySelectorAll('.carousel');
carousels.forEach(function(carousel) {
  new Flickity( carousel, {
    on: {
      ready: function() {
        console.log('Flickity is ready');
      },
      change: function( index ) {
        console.log( 'Slide changed to' + index );
      }
    }
  });
});
