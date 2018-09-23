{extends "_layouts/base.tpl"}

{block "content"}
    <div class="wrapper-index-page">
        <div class="container">
            <div class="row">
                <div class="col-9">
                    <div class="inner-container" >
                        <div class="wrapper-filter">
                            <form class="d-flex justify-content-between align-items-center" action="" method="get" data-form-filter>
                                <div class="form-field">
                                    <label for="sort-tasks">Введите имя или email</label>
                                    <input type="text" id="sort-tasks" name="filter_name_or_email">
                                </div>

                                <div class="form-field">
                                    <label for="filter_status">Статус:</label>
                                    <select name="filter_status" id="filter_status">
                                        <option selected value="all">Все</option>
                                        <option value="1">Выполненные</option>
                                        <option value="0">Не выполненные</option>
                                    </select>
                                </div>
                            </form>
                        </div>

                        <div data-filter-update>
                            <div class="wrapper-tasks" data-pagination-update="{$pager->getId()}">
                                {set $admin = $user->getIsAdmin()}

                                {foreach $pager->getData() as $task}
                                    <div class="wrapper-task {if $admin}admin{/if}" data-block-task>
                                        <div class="name">{$task->name}</div>
                                        <div class="email">{$task->email}</div>
                                        <div class="text">
                                            {if $admin}
                                                <textarea data-field-text name="text" id="">{$task->text}</textarea>
                                            {else}
                                                <div>{$task->text}</div>
                                            {/if}
                                        </div>

                                        {if $task->image}
                                            <div class="holder-image">
                                                <a href="{$task->image}" class="fanybox" data-fancybox>
                                                    <img src="{$task->image}" alt="">
                                                </a>
                                            </div>
                                        {/if}

                                        {if $admin}
                                            <div class="holder-done">
                                                <input data-field-done name="done" id="checkbox-done-{$task->pk}" type="checkbox" value="1" {if $task->done}checked{/if}>
                                                <label for="checkbox-done-{$task->pk}">Выполнено</label>
                                            </div>

                                            <div class="holder-button">
                                                <a href="/edit/{$task->pk}" data-save class="link">Сохранить</a>
                                            </div>
                                        {/if}
                                    </div>
                                {foreachelse}
                                    <div class="empty">
                                        Задачи не найдены :(
                                    </div>
                                {/foreach}
                            </div>

                            {raw $pager->render()}
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="wrapper-form" data-sticky-form>
                        {set $formName = $form->getName()}

                        <form action="" data-reset="1" data-success="$('[data-form-filter] input').trigger('input')"
                              data-ajax-form="{$formName}" method="post" enctype="multipart/form-data" data-timeout="3000">
                            {include "_parts/form_fields.tpl" form=$form}

                            <button type="submit">Создать задачу</button>

                            {include "_parts/success.tpl" text='Задача создана!'}
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
{/block}