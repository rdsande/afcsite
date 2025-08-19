@extends('layouts.app')

@section('content')
<!-- Breadcrumb -->
<div class="page-brdc">
    <div class="uk-background-cover uk-height-medium uk-panel uk-flex uk-flex-center uk-flex-middle" style="background-image: url(img/breadcrumbs/image2.png);">
        <h1 class="page-title"> MEMBERSHIP </h1>
    </div>
</div>

<!-- Section begin -->
<div class="uk-section pull-top-two whiteptn team-inner">
    <div class="uk-container uk-container-medium">
        <div class="home-posts team-section shadow-one uk-padding bg-blue">
            <div class="uk-grid-small uk-child-width-expand@s" uk-grid>
                <div class="uk-container uk-container-medium">

                    <div class="uk-position-relative uk-visible-toggle uk-light" tabindex="-1" uk-slider>

                        <div class="uk-slider-items uk-child-width-1-2 uk-child-width-1-3@m uk-grid">
                            <div>
                                <div class="uk-panel">
                                    <img src="{{asset('img/cards/blue.png')}}" width="400" height="600" alt="">
                                </div>
                            </div>
                            <div>
                                <div class="uk-panel">
                                    <img src="{{asset('img/cards/gold.png')}}" width="400" height="600" alt="">
                                </div>
                            </div>
                            <div>
                                <div class="uk-panel">
                                    <img src="{{asset('img/cards/platinum.png')}}" width="400" height="600" alt="">
                                </div>
                            </div>

                        </div>

                        <a class="uk-position-center-left uk-position-small uk-hidden-hover" href uk-slidenav-previous uk-slider-item="previous"></a>
                        <a class="uk-position-center-right uk-position-small uk-hidden-hover" href uk-slidenav-next uk-slider-item="next"></a>

                    </div>



                    <div class="uk-section afc-cards">
                        <div class="uk-container">
                            <div class="uk-position-relative uk-margin-medium js-example about-vertical">

                                <ul uk-tab="swiping: false" role="tablist" class="uk-tab sidebar">
                                    <li class="uk-active" role="presentation"><a href="#" aria-selected="true" role="tab" id="uk-tab-5-tab-0" aria-controls="uk-tab-5-tabpanel-0">About Azam FC Membership cards</a></li>
                                    <li role="presentation" class=""><a href="#" aria-selected="false" role="tab" id="uk-tab-5-tab-1" aria-controls="uk-tab-5-tabpanel-1" tabindex="-1">Types of cards</a></li>
                                    <li role="presentation" class=""><a href="#" aria-selected="false" role="tab" id="uk-tab-5-tab-2" aria-controls="uk-tab-5-tabpanel-2" tabindex="-1">How to register</a></li>
                                </ul>

                                <ul class="uk-switcher uk-margin sidemain uk-margin-large-bottom uk-padding" role=" presentation">
                                    <li class="uk-active" id="uk-tab-5-tabpanel-0" role="tabpanel" aria-labelledby="uk-tab-5-tab-0">
                                        <div class="uk-child-width-expand@s uk-grid-match" uk-grid>
                                            <div>
                                                <div class="uk-card uk-card-default uk-card-body">
                                                    <iframe width="1920" height="1080" allowfullscreen uk-responsive src="https://www.youtube.com/embed/fHPYpw3Yypc" title="AZAM Member cards" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="uk-card uk-card-default uk-card-body">
                                                    <h3>Get Your Exclusive AZAM FC Membership Cards Today! </h3>
                                                    <br>
                                                    <p>Elevate your AZAM FC experience with our exclusive membership cards, powered by Azampesa! Our NFC-enabled cards provide seamless access to all major club activities and come with a host of benefits tailored to meet your needs. Choose from our Platinum, Gold, or Silver cards and start enjoying exclusive discounts and rewards today. </p>
                                                    <div class="uk-grid-small uk-child-width-expand@s uk-text-center uk-padding-small values-icons" uk-grid>
                                                        <div>
                                                            <div class="uk-card uk-card-default uk-card-body">
                                                                <i class="ri-planet-line"></i>
                                                                Seamless Integration
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <div class="uk-card uk-card-default uk-card-body">
                                                                <i class="ri-wireless-charging-line"></i>
                                                                Versatile Benefits
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <div class="uk-card uk-card-default uk-card-body">
                                                                <i class="ri-user-smile-line"></i>
                                                                Family friendly
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li id="uk-tab-5-tabpanel-1" role="tabpanel" aria-labelledby="uk-tab-5-tab-1" class="">
                                        <div class="uk-child-width-expand@s uk-grid-match" uk-grid>
                                            <div>
                                                <div class="uk-card uk-card-default uk-card-body">
                                                    <h3>Platinum Card</h3>
                                                    <img src="{{asset('img/cards/platinum.png')}}" width="100%" alt="">
                                                </div>
                                            </div>
                                            <div>
                                                <div class="uk-card uk-card-default uk-card-body">
                                                    <span class="card-cost">
                                                        <h1>Tsh. 50,000 <sup> One time fee </sup> </h1>

                                                    </span>
                                                    <strong> Our top-tier Platinum Card offers unmatched perks and privileges for the ultimate AZAM FC fan: </strong>
                                                    <ul class="uk-list uk-list-bullet">
                                                        <li> <strong>Exclusive Discounts:</strong> Enjoy a 10% discount on all AZAM FC jerseys and official merchandise. Show your support in style while saving money!
                                                        </li>
                                                        <li><strong>Azam Marine Tickets:</strong> For every ticket purchased using your Platinum Card, receive TZS 1000 cashback. Travel and save with ease! </li>
                                                        <li><strong>Sarafu App Rewards: </strong>Earn 1% cashback on all your sales through the Sarafu app. Turn your transactions into savings effortlessly. </li>
                                                        <li><strong>Pocket Money Management:</strong> This card is perfect for managing your child’s pocket money, allowing you to control spending and teach financial responsibility.</li>

                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="uk-child-width-expand@s uk-grid-match" uk-grid>
                                            <div>
                                                <div class="uk-card uk-card-default uk-card-body">
                                                    <h3>Gold Card</h3>
                                                    <img src="{{asset('img/cards/gold.png')}}" width="100%" alt="">
                                                </div>
                                            </div>
                                            <div>
                                                <div class="uk-card uk-card-default uk-card-body">
                                                    <span class="card-cost">
                                                        <h1>Tsh. 25,000 <sup> One time fee </sup> </h1>

                                                    </span>
                                                    <strong> Our Gold Card strikes the perfect balance between benefits and affordability: </strong>
                                                    <ul class="uk-list uk-list-bullet">
                                                        <li> <strong>Exclusive Discounts:</strong> Enjoy an 8% discount on all AZAM FC jerseys and official merchandise. Show your support in style while saving money!
                                                        </li>
                                                        <li><strong>Azam Marine Tickets:</strong> For every ticket purchased using your Platinum Card, receive TZS 1000 cashback. Travel and save with ease! </li>
                                                        <li><strong>Sarafu App Rewards: </strong>Earn 1% cashback on all your sales through the Sarafu app. Turn your transactions into savings effortlessly. </li>
                                                        <li><strong>Pocket Money Management:</strong> This card is perfect for managing your child’s pocket money, allowing you to control spending and teach financial responsibility.</li>

                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="uk-child-width-expand@s uk-grid-match" uk-grid>
                                            <div>
                                                <div class="uk-card uk-card-default uk-card-body">
                                                    <h3>Silver Card</h3>
                                                    <img src="{{asset('img/cards/blue.png')}}" width="100%" alt="">
                                                </div>
                                            </div>
                                            <div>
                                                <div class="uk-card uk-card-default uk-card-body">
                                                    <span class="card-cost">
                                                        <h1>Tsh. 5,000 <sup> One time fee </sup> </h1>

                                                    </span>
                                                    <strong> Our Silver Card offers essential benefits at an incredible value: </strong>
                                                    <ul class="uk-list uk-list-bullet">
                                                        <li> <strong>Exclusive Discounts:</strong> Enjoy a 6% discount on all AZAM FC jerseys and official merchandise. Show your support in style while saving money!
                                                        </li>
                                                        <li><strong>Azam Marine Tickets:</strong> For every ticket purchased using your Platinum Card, receive TZS 1000 cashback. Travel and save with ease! </li>
                                                        <li><strong>Sarafu App Rewards: </strong>Earn 1% cashback on all your sales through the Sarafu app. Turn your transactions into savings effortlessly. </li>
                                                        <li><strong>Pocket Money Management:</strong> This card is perfect for managing your child’s pocket money, allowing you to control spending and teach financial responsibility.</li>

                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li id="uk-tab-5-tabpanel-2" role="tabpanel" aria-labelledby="uk-tab-5-tab-2" class="">
                                        Thanks for your interest in getting your Azam FC Fan card. Currently you may be registered only by our Agents.
                                        <p><strong>Prerequisites for Registration</strong></p>
                                        <ul>
                                            <li>NIDA number</li>
                                            <li>AZAMPESA account</li>
                                        </ul>

                                        <br />
                                        <p> For more information please contact:
                                            <br />
                                            <i class="ri-phone-line"></i> <span> +255 712 370 000 </span>
                                        </p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection