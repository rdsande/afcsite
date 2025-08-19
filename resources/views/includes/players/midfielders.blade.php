@if(isset($seniorPlayers['Midfielder']) && $seniorPlayers['Midfielder']->count() > 0)
    @foreach($seniorPlayers['Midfielder'] as $midfielder)
        <!-- Player -->
        <li>
            <a href="{{ route('player.show', $midfielder->id) }}">
                <div>
                    <div class="uk-card uk-card-default uk-card-body uk-animation-toggle" tabindex="0">
                        <div class="uk-inline-clip uk-transition-toggle" tabindex="0">
                            <span class="bgtop"></span>
                            <img loading="lazy" class="uk-transition-scale-up uk-transition-opaque" src="{{ $midfielder->profile_image ? asset('storage/' . $midfielder->profile_image) : asset('/img/players/profiles/default-player.png') }}" width="1800" height="1200" alt="{{ $midfielder->name }}">
                        </div>
                        <div class="player-card-details uk-animation-slide-bottom-medium">
                            <div class="uk-child-width-expand@s uk-text-center" uk-grid>
                                <div>
                                    <span class="uk-heading-divider">{{ strtoupper($midfielder->name) }}<span class="secondname">
                                            {{ strtoupper($midfielder->last_name ?? '') }}
                                        </span></span>
                                    <span class="pos-player"> {{ $midfielder->position }} </span>
                                </div>
                                <div>
                                    <span class="plyr-number">
                                        {{ $midfielder->jersey_number }}
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
            <p>No midfielders available</p>
        </div>
    </li>
@endif