{set $firstPage = $pagination->getFirstPage()}
{set $lastPage = $pagination->getLastPage()}

{set $prevPage = $pagination->getPreviousPage()}
{set $nextPage = $pagination->getNextPage()}

<div class="pagination-wrapper" data-id="{$pagination->getRequestPageKey()}">
    {if $firstPage != $lastPage}

        <div class="pagination-block">
            {set $activeSize = 2}
            {set $activeFrame = $activeSize * 2 + 1}

            {set $page = $pagination->fetchPage()}
            {set $firstPage = $pagination->getFirstPage()}
            {set $lastPage = $pagination->getLastPage()}

            {set $firstFramePage = $page - $activeSize}
            {if $firstFramePage > $lastPage - $activeSize * 2}
                {set $firstFramePage = $lastPage - $activeSize * 2}
            {/if}
            {if $firstFramePage < $firstPage}
                {set $firstFramePage = $firstPage}
            {/if}

            {set $lastFramePage = $firstFramePage + $activeSize * 2}
            {if $lastFramePage > $lastPage}
                {set $lastFramePage = $lastPage}
            {/if}

            <ul class="pagination-list">
                {if $prevPage}
                    <li class="prev">
                        <a href="{$pagination->getUrl($prevPage)}">
                                &larr;
                        </a>
                    </li>
                {/if}

                <li class="first {if $page == $firstPage}active{/if}">
                    <a href="{$pagination->getUrl($firstPage)}">
                        {$firstPage}
                    </a>
                </li>

                {if $firstFramePage > $firstPage + 1}
                    <li class="dots">
                            ...
                    </li>
                {/if}

                {foreach $firstFramePage..$lastFramePage as $item}
                    {if $item != $firstPage and $item != $lastPage}
                        <li class="page {if $page == $item}active{/if}">
                            <a href="{$pagination->getUrl($item)}">
                                {$item}
                            </a>
                        </li>
                    {/if}
                {/foreach}

                {if $lastFramePage < $lastPage - 1}
                    <li class="dots">
                            ...
                    </li>
                {/if}

                {if $lastPage > $firstPage}
                    <li class="last {if $page == $lastPage}active{/if}">
                        <a href="{$pagination->getUrl($lastPage)}">
                            {$lastPage}
                        </a>
                    </li>
                {/if}

                {if $nextPage}
                    <li class="next">
                        <a id="pager-next" href="{$pagination->getUrl($nextPage)}">
                                &rarr;
                        </a>
                    </li>
                {/if}
            </ul>
        </div>
    {/if}
</div>