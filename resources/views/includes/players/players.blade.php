<div class="uk-position-relative uk-margin-medium js-example">

    <ul uk-tab="swiping: false" role="tablist" class="uk-tab">
        <li class="uk-active" role="presentation"><a href="#" aria-selected="true" role="tab" id="uk-tab-5-tab-0"
                aria-controls="uk-tab-5-tabpanel-0">Goalkeepers</a></li>
        <li role="presentation" class=""><a href="#" aria-selected="false" role="tab" id="uk-tab-5-tab-1"
                aria-controls="uk-tab-5-tabpanel-1" tabindex="-1">Defenders</a></li>
        <li role="presentation" class=""><a href="#" aria-selected="false" role="tab" id="uk-tab-5-tab-2"
                aria-controls="uk-tab-5-tabpanel-1" tabindex="-1">Midfielders</a></li>
        <li role="presentation" class=""><a href="#" aria-selected="false" role="tab" id="uk-tab-5-tab-3"
                aria-controls="uk-tab-5-tabpanel-1" tabindex="-1">Forwards</a></li>
    </ul>

    <ul class="uk-switcher uk-margin" role="presentation">
        <li class="uk-active" id="uk-tab-5-tabpanel-0" role="tabpanel" aria-labelledby="uk-tab-5-tab-0">
            <div class="uk-position-relative uk-visible-toggle uk-light" tabindex="-1" uk-slider>

                <ul class="uk-slider-items uk-child-width-1-2 uk-child-width-1-3@m uk-grid">
                    @include('includes/players.goalkeepers')
                </ul>
                <a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#" uk-slidenav-previous
                    uk-slider-item="previous"></a>
                <a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" uk-slidenav-next
                    uk-slider-item="next"></a>
            </div>
        </li>
        <li id="uk-tab-5-tabpanel-1" role="tabpanel" aria-labelledby="uk-tab-5-tab-1" class="">
            <div class="uk-position-relative uk-visible-toggle uk-light" tabindex="-1" uk-slider>

                <ul class="uk-slider-items uk-child-width-1-2 uk-child-width-1-3@m uk-grid">
                    @include('includes/players.defenders')
                </ul>

                <a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#" uk-slidenav-previous
                    uk-slider-item="previous"></a>
                <a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" uk-slidenav-next
                    uk-slider-item="next"></a>

            </div>
        </li>
        <li id="uk-tab-5-tabpanel-2" role="tabpanel" aria-labelledby="uk-tab-5-tab-2" class="">
            <div class="uk-position-relative uk-visible-toggle uk-light" tabindex="-1" uk-slider>

                <ul class="uk-slider-items uk-child-width-1-2 uk-child-width-1-3@m uk-grid">
                    @include('includes/players.midfielders')
                </ul>

                <a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#" uk-slidenav-previous
                    uk-slider-item="previous"></a>
                <a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" uk-slidenav-next
                    uk-slider-item="next"></a>

            </div>
        </li>
        <li id="uk-tab-5-tabpanel-3" role="tabpanel" aria-labelledby="uk-tab-5-tab-3" class="">
            <div class="uk-position-relative uk-visible-toggle uk-light" tabindex="-1" uk-slider>

                <ul class="uk-slider-items uk-child-width-1-2 uk-child-width-1-3@m uk-grid">
                    @include('includes/players.forwards')
                </ul>

                <a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#" uk-slidenav-previous
                    uk-slider-item="previous"></a>
                <a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" uk-slidenav-next
                    uk-slider-item="next"></a>

            </div>
        </li>
    </ul>

</div>