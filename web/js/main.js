$(function() {
    var fingerprintHash = false;

    new Fingerprint2().get(function(result, components){
      var fingerprint = {};
      fingerprint[result] = components;
      fingerprintHash = result;
      $('#appbundle_suggestion_fingerprint').val(JSON.stringify(fingerprint));
      $('#appbundle_mailing_fingerprint').val(JSON.stringify(fingerprint));
    });

    $('.show-jumbo-more').click(function() {
        $('.jumbo-less').hide();
        $('.jumbo-more').show();
    });

    $('[data-vote]').click(function(evt) {
        evt.preventDefault();

        var id = $(this).attr('data-vote');
        var url = '/api/vote/' + id;
        var data = {
            fingerprint: fingerprintHash
        }
        $.post(url, data)
            .done(function(data) {
                var existingVotes = parseInt($('.votes-for-' + id).html());
                existingVotes++;
                $('.votes-for-' + id).html(existingVotes);
                toastr.success('Ďakujeme za váš hlas.');
            })
            .fail(function(error) {
                toastr.error(error.responseJSON.error);
            });
    });
});