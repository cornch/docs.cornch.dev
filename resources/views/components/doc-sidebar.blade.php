<div
    x-data="{ opening: '' }"
    x-init="$el.querySelectorAll('a').forEach((link) => {
        if (link.href.startsWith(window.location.href)) {
            link.parentNode.classList.add('active')

            let $li = link.parentNode;
            while (!$li.dataset.uuid) {
                $li = $li.parentNode;
            }
            opening = $li.dataset.uuid;
        }
    })"
>
    {!! $html !!}
</div>
