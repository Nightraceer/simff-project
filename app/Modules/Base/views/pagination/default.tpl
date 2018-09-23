{set $prevPage = $pagination->getPreviousPage()}
{set $nextPage = $pagination->getNextPage()}

<div class="pagination-block" data-pagination-list="{$pagination->getId()}">
    {if $nextPage}
        <div class="pagination justify-content-center">
            <a id="pager-next" href="{$pagination->getUrl($nextPage)}" data-next-pager-link="{$pagination->getId()}">
                <span class="bricks">
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
                <span class="text">Загрузить еще</span>
            </a>
        </div>
    {/if}
</div>