<div class="wrapper-preview">

    <div>
        <div class="wrapper-task">
            {set $name = $form->getField('name')}
            {set $email = $form->getField('email')}
            {set $text = $form->getField('text')}

            <div class="name">{$name->getValue()}</div>
            <div class="email">{$email->getValue()}</div>
            <div class="text">

                <div>{$text->getValue()}</div>

            </div>

            <div class="holder-image">
                <img data-img-preview src="" alt="">
            </div>
        </div>
    </div>

    <script>
        $(function () {
            var $form = $('.wrapper-create-task').find('form');
            var $imgPreview = $('[data-img-preview]');
            var input = $form.find('input[type=file]').get(0);
            var reader  = new FileReader();

            reader.onloadend = function () {
                $imgPreview.attr('src', reader.result);
            }

            if (input.files[0]) {
                reader.readAsDataURL(input.files[0]);
            } else {
                $imgPreview.attr('src', '');
            }
        });
    </script>
</div>