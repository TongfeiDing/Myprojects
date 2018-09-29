$('.form').find('input, textarea').on('keyup blur focus', function (e) {
  
  var $this = $(this),
      label = $this.prev('label');

	  if (e.type === 'keyup') {
			if ($this.val() === '') {
          label.removeClass('active highlight');
        } else {
          label.addClass('active highlight');
        }
    } else if (e.type === 'blur') {
    	if( $this.val() === '' ) {
    		label.removeClass('active highlight'); 
			} else {
		    label.removeClass('highlight');   
			}   
    } else if (e.type === 'focus') {
      
      if( $this.val() === '' ) {
    		label.removeClass('highlight'); 
			} 
      else if( $this.val() !== '' ) {
		    label.addClass('highlight');
			}
    }

});

$('.nav-tabs > li > a').on('click', function (e) {
  
  e.preventDefault();
  
  $(this).parent().addClass('active');
  var tabid = $(this).parent().attr('id');
  switch(tabid){
    case 'available': 
      $('#delivered').removeClass('active');
      $('#removed').removeClass('active'); break;
    case 'delivered':
      $('#available').removeClass('active');
      $('#removed').removeClass('active'); break;
    case 'removed':
      $('#delivered').removeClass('active');
      $('#available').removeClass('active'); break;
    case 'map':
      $('#list').removeClass('active'); 
      target = $(this).attr('href');
      $('.tab-content > div').not(target).hide(); 
      $(target).fadeIn(600); break;
    case 'list':
      $('#map').removeClass('active'); 
      target = $(this).attr('href');
      $('.tab-content > div').not(target).hide(); 
      $(target).fadeIn(600); break;
  }
  
  
  
});