$(function () {
    var pagerLinkSelector = '[data-next-pager-link]';
    var timeout = 0;

    $(document)
        .on('click', 'a.modal', function (e) {
            $(this).modal();
            return false;
        })
        // .on('click', pagerLinkSelector, function (e) {
        //     e.preventDefault();
        //     var $this = $(this),
        //         updateIdContainer = $this.data('next-pager-link'),
        //         updateSelector = '[data-pagination-update="' + updateIdContainer + '"]',
        //         paginationListSelector = '[data-pagination-list="' + updateIdContainer + '"]';
        //
        //     if ($this.hasClass('loading')) {
        //         return false;
        //     }
        //
        //     $this.addClass('loading');
        //     $.ajax({
        //         url: $this.attr('href'),
        //         success: function (page) {
        //             var $page = $('<div/>').append(page);
        //
        //             $(updateSelector).append($page.find(updateSelector).html());
        //
        //             $(paginationListSelector).html($page.find(paginationListSelector).html());
        //             $this.removeClass('loading');
        //         }
        //     });
        //     return false;
        // })

        .on('click', '[data-save]', function () {
            var $this = $(this);
            var url = $this.attr('href');
            var textLink = $this.html();
            var $block = $this.closest('[data-block-task]');
            var text = $block.find('[data-field-text]').val();
            var done = $block.find('[data-field-done]').prop('checked') ? 1 : 0;


            $this.addClass('disabled');

            $.ajax({
                url: url,
                data: {
                    text: text,
                    done: done
                },
                dataType: 'json',
                type: 'post',
                success: function (data) {
                    $this.html(data.state);

                    setTimeout(function () {
                        $this.html(textLink);
                        $this.removeClass('disabled');
                    }, 4000);
                }
            });

            return false;
        })

        .on('change input', '[data-form-filter] input, [data-form-filter] select', function () {
            var $form = $(this).closest('form');

            clearTimeout(timeout);

            timeout = setTimeout(function () {
                $.ajax({
                    data: $form.serialize(),
                    type: $form.attr('method'),
                    dataType: 'html',
                    success: function (page) {
                        var $page = $('<div/>').append(page);

                        console.log(page);

                        $('[data-filter-update]').html($page.find('[data-filter-update]').html());
                    }
                });
            }, 300);
        });


    $('[data-sticky-form]').psticky({
        top: 20,
        parent: ".row"
    });

    var checkInputs = '.wrapper-create-task input, .wrapper-create-task textarea';

    $(checkInputs).on('input', function () {
       var $form  = $(this).closest('form');
       var $preview = $form.find('[data-preview]');
       var filled = false;

        $(checkInputs).each(function () {
            if ($(this).val().trim() !== '') {
                filled = true;
            }
        });

        if (filled) {
            $preview.attr('href', $preview.data('preview') + '?' + $form.serialize());
            $preview.addClass('show');
        } else {
            $preview.removeClass('show');
        }
    });


});