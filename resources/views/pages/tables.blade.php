@extends('layouts.app')

@section('content')


<!-- Fixtures Page Tabs -->
<h1 class="uk-heading-line uk-text-center match-center"><span>MATCH CENTER
        <div class="uk-form-controls">
            <select class="uk-select" id="form-stacked-select">
                <option>Senior team</option>
                <option>Under 13</option>
                <option>Under 15</option>
                <option>Under 17</option>
                <option>Under 20</option>
            </select>
        </div>
    </span></h1>

<div class="uk-position-relative uk-margin-medium js-example fixtures-section">

    <ul uk-tab="swiping: false" role="tablist" class="uk-tab fxture-tabs">
        <li class="tab-itm" role="presentation"><a href="#" aria-selected="true" role="tab" id="uk-tab-5-tab-0"
                aria-controls="uk-tab-5-tabpanel-0">Fixtures</a></li>
        <li role="presentation" class="tab-itm"><a href="#" aria-selected="false" role="tab" id="uk-tab-5-tab-1"
                aria-controls="uk-tab-5-tabpanel-1" tabindex="-1">Results</a></li>
        <li role="presentation" class="uk-active tab-itm"><a href="#" aria-selected="false" role="tab"
                id="uk-tab-5-tab-2" aria-controls="uk-tab-5-tabpanel-2" tabindex="-1">Tables</a></li>
    </ul>

    <ul class="uk-switcher" role="presentation">
        <!-- Fixtures -->
        <li class="uk-active fxturestabsinner" id="uk-tab-5-tabpanel-0" role="tabpanel"
            aria-labelledby="uk-tab-5-tab-0">
            @include('includes/results.fixtures')
        </li>

        <!-- Results -->
        <li id="uk-tab-5-tabpanel-1" role="tabpanel" aria-labelledby="uk-tab-5-tab-1" class="fxturestabsinner">
            @include('includes/results.results')
        </li>

        <!-- Tables -->
        <li id="uk-tab-5-tabpanel-2" role="tabpanel" aria-labelledby="uk-tab-5-tab-2" class="fxturestabsinner">
            @include('includes/results.tables')
        </li>
    </ul>
</div>



@endsection