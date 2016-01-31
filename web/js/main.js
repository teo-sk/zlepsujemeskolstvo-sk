$(function() {
    new Fingerprint2().get(function(result, components){
      var fingerprint = {};
      fingerprint[result] = components;
      $('#appbundle_suggestion_fingerprint').val(JSON.stringify(fingerprint));
      $('#appbundle_mailing_fingerprint').val(JSON.stringify(fingerprint));
    });
});