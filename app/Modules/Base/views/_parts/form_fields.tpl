{set $fields = $form->getFields()}

{foreach $fields as $name => $field}
    {if !in_array($name, $form->exclude)}
        {set $type = $field->getHtmlType()}
        {set $placeholder = $field->placeholder}

        <div class="form-field">

            {if $field->label}
                <label for="{$formName}_{$name}">{$field->label}</label>
            {/if}

            {if $type == 'textarea'}
                <textarea {if $placeholder}placeholder="{$placeholder}"{/if} name="{$formName}[{$name}]" id="{$formName}_{$name}"></textarea>
            {else}
                <input {if $placeholder}placeholder="{$placeholder}"{/if} type="{$type}" id="{$formName}_{$name}" name="{$formName}[{$name}]">
            {/if}

            <ul class="errors" id="{$formName}_{$name}_errors">
                {if $field->error}
                    <li>{$field->error}</li>
                {/if}
            </ul>
        </div>
    {/if}
{/foreach}