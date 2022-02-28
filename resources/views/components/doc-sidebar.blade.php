<div
    x-data="{ openedPage: '' }"
    x-init="$el.querySelectorAll('a').forEach((link) => {
        if (
            link.pathname === window.location.pathname &&
            (
                (link.hash && link.hash === window.location.hash) ||
                !link.hash
            )
        ) {
            link.parentNode.classList.add('active');

            let $li = link.parentNode;
            while (!$li.dataset.id) {
                $li = $li.parentNode;
            }
            openedPage = $li.dataset.id;
        }
    })"
>
    {!! $html !!}
</div>
