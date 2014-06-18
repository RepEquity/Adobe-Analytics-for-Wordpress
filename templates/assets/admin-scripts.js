jQuery(function($) {
  $(document).ready(function() {

    //repeatable field logid
    //TODO: replace with metaboxes code for consistency
    $('.repeatable-field-ali').click(function() {
      var theField = $(this).closest('fieldset.repeatable-wrap').find('.repeatable-fields-list li:last').clone(true);
      var theLocation = $(this).closest('fieldset.repeatable-wrap').find('.repeatable-fields-list li:last');
      $('input', theField).val('').attr('name', function(index, name) {
        return name.replace(/(\d+)/, function(fullMatch, n) {
          return Number(n) + 1;
        });
      });
      theField.insertAfter(theLocation, $(this).closest('fieldset.repeatable-wrap'));
      var fieldsCount = $('.repeatable-field-remove').length;
      if (fieldsCount > 1) {
        $('.repeatable-field-remove').css('display', 'inline');
      }
      return false;
    });
    //remove repeatable field button
    $('.repeatable-field-remove').click(function() {
      $(this).parent().remove();
      var fieldsCount = $('.repeatable-field-remove').length;
      if (fieldsCount == 1) {
        $('.repeatable-field-remove').css('display', 'none');
      }
      return false;
    });

    //serialize global variable values and insert them in variables field
    $('form').submit(function(e) {
      $('#adobe_analytics_custom_variables').val(JSON.stringify($('fieldset').serializeArray()));
      $(this).submit();
    });

    //populates repeatable fields if some custom variables are already set
    //check for value in custom variables field and populate variables fieldset
    var variables = $('#adobe_analytics_custom_variables').val();
    // console.log(variables);
    if (variables.length > 1) {
      vars = JSON.parse(variables);
      $.each(vars, function(i,val) {
        if (val['value'].length > 1) {
          if (i%2 == 0) {
            $('input[name='+val['name']+']').val(val['value']);
          }
          else {
            $('input[name='+val['name']+']').val(val['value']);
            $('.repeatable-field-ali').click();
          }
        }
      });
    }

    //tabbed navigation on the top of the page
    $('#adobe-analytics-tabs-controller a').click(function() {
      //find what we are interested in
      destId = $(this).attr('href').replace('#top', '');
      activTab = $('#adobe-analytics-tabs-controller a.active');

      //do the magic
      $('section.active').removeClass('active');
      $(activTab).removeClass('active');
      $(destId).addClass('active');
      $(this).addClass('active');
    });

  });
});
