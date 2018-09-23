<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">

    {block 'head'}{/block}


    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">

    <link rel="stylesheet" href="/static/dist/css/main.css">
    <script src="/static/dist/js/main.js"></script>


</head>
<body>
<div id="wrapper">
    <header>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="header-inner d-flex justify-content-between align-items-center">
                        <a href="/" rel="nofollow" class="name">
                            Привет,

                            {if !$user->getIsGuest()}
                                {$user->login}!
                            {else}
                                незнакомец!
                            {/if}
                        </a>

                        {if !$user->getIsGuest()}
                            <a href="/logout" class="link">Выйти</a>
                        {else}
                            <a href="/login" class="link">Авторизоваться</a>
                        {/if}

                    </div>
                </div>
            </div>
        </div>
    </header>

    {block "content"}

    {/block}
</div>

{block 'js'}

{/block}

</body>
</html>