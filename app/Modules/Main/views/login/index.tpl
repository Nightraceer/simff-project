{extends "_layouts/base.tpl"}

{block "content"}
    <div class="wrapper-login-page">
        <div class="wrapper-form">
            {set $formName = $form->getName()}

            <form action="" method="post" data-ajax-form="{$formName}">
                {include "_parts/form_fields.tpl" form=$form}

                <button type="submit">Войти</button>
            </form>
        </div>
    </div>
{/block}