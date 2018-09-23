$(function () {
    $(function(){
        $(document).on('submit', '[data-ajax-form]', function(e){
            e.preventDefault();
            var $form = $(this);
            var formClass = $form.data('ajax-form');
            var successSelector = $form.data('success-selector');
            var $success = successSelector ? $(successSelector) : $form;
            var successFunc = $form.data('success');
            var reset = $form.data('reset');
            var timeout = $form.data('timeout');

            $form.ajaxSubmit({
                type: $form.attr('method'),
                dataType: 'json',
                success: function(data) {
                    var errors = {};

                    $( ".errors[id^='" + formClass + "']" ).html("").css({'display': 'none'});

                    if (data.errors) {
                        errors = data.errors;

                        Object.keys(errors).forEach(function (key){
                            var $errors = $('#'+formClass+'_'+key+'_errors').css({"display":"inline-block"});

                            $errors.append('<li>'+errors[key]+'</li>');
                        });
                    }


                    if (data.state === 'success') {
                        $success.addClass('success');

                        if (data.redirect) {
                            window.location.href = data.redirect;
                        }

                        if (successFunc) {
                            eval(successFunc);
                        }

                        if (reset) {
                            $form.get(0).reset();
                        }

                        if (timeout) {
                            setTimeout(function () {
                                $success.removeClass('success');
                            }, timeout);
                        }
                    }
                }
            });

            return false;
        });
    });
});