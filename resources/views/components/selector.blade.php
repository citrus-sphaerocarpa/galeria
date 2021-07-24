<div class="uk-position-small uk-position-top-right">
    <a href="" class="uk-text-small uk-link-muted uk-text-emphasis" uk-icon="world"></a>
    <div class="uk-padding-small" uk-dropdown="pos: top-right; mode: click">
        <ul class="uk-list uk-margin-remove">
            @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                <li class="pure-menu-item">
                    <a class="uk-link-reset" rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                    {{ $properties['native'] }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</div>