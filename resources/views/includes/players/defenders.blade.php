@if(isset($seniorPlayers['Defender']) && $seniorPlayers['Defender']->count() > 0)
    @foreach($seniorPlayers['Defender'] as $defender)
        <!-- Player -->
        <li>
            <a href="{{ route('player.show', $defender->id) }}">
                <div>
                    <div class="uk-card uk-card-default uk-card-body uk-animation-toggle" tabindex="0">
                        <div class="uk-inline-clip uk-transition-toggle" tabindex="0">
                            <span class="bgtop"></span>
                            <img loading="lazy" class="uk-transition-scale-up uk-transition-opaque" src="{{ $defender->profile_image ? asset('storage/' . $defender->profile_image) : asset('/img/players/profiles/default-player.png') }}" width="1800" height="1200" alt="{{ $defender->name }}">
                        </div>
                        <div class="player-card-details uk-animation-slide-bottom-medium">
                            <div class="uk-child-width-expand@s uk-text-center" uk-grid>
                                <div>
                                    <span class="uk-heading-divider">{{ strtoupper($defender->name) }}<span class="secondname">
                                            {{ strtoupper($defender->last_name ?? '') }}
                                        </span></span>
                                    <span class="pos-player"> {{ $defender->position }} </span>
                                </div>
                                <div>
                                    <span class="plyr-number">
                                        {{ $defender->jersey_number }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </li>
    @endforeach
@else
    <li>
        <div class="uk-text-center uk-padding">
            <p>No defenders available</p>
        </div>
    </li>
@endif