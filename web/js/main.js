$(function() {
    new Fingerprint2().get(function(result, components){
      var fingerprint = {};
      fingerprint[result] = components;
      $('#appbundle_suggestion_fingerprint').val(JSON.stringify(fingerprint));
      $('#appbundle_mailing_fingerprint').val(JSON.stringify(fingerprint));
    });

    $('.show-jumbo-more').click(function() {
        $('.jumbo-less').hide();
        $('.jumbo-more').show();
    });
});