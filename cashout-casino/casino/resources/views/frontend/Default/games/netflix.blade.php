@extends('frontend.Default.layouts.app')

@section('page-title', $title)
@section('body', $body)
@section('keywords', $keywords)
@section('description', $description)

@section('content')
<style type="text/css">
@charset "UTF-8";
[ng\:cloak],
[ng-cloak],
[data-ng-cloak],
[x-ng-cloak],
.ng-cloak,
.x-ng-cloak,
.ng-hide:not(.ng-hide-animate) {
    display: none !important;
}

.netflix-gallery {
    width: 100%;
    background-color: #0e0e0e;
    padding: 40px 0;
    min-height: 100vh;
}

.netflix-row {
    margin-bottom: 60px;
    padding: 0 60px;
}

.netflix-row__header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.netflix-row__title {
    color: #e5e5e5;
    font-size: 24px;
    font-weight: 600;
    margin: 0;
    padding: 0;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.netflix-row__view-all {
    color: #54b9c5;
    font-size: 14px;
    font-weight: 500;
    text-decoration: none;
    cursor: pointer;
    transition: color 0.3s ease;
}

.netflix-row__view-all:hover {
    color: #ffffff;
    text-decoration: underline;
}

.netflix-slider {
    position: relative;
    overflow: hidden;
}

.netflix-slider__container {
    display: flex;
    gap: 10px;
    overflow-x: auto;
    scroll-behavior: smooth;
    padding-bottom: 20px;
    scrollbar-width: none;
    -ms-overflow-style: none;
}

.netflix-slider__container::-webkit-scrollbar {
    display: none;
}

.netflix-card {
    flex: 0 0 calc((100% - 50px) / 6);
    max-width: calc((100% - 50px) / 6);
    min-width: 180px;
    position: relative;
    border-radius: 16px;
    overflow: hidden;
    cursor: pointer;
    transition: transform 0.3s ease, z-index 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.05));
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.15);
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.3);
}

.netflix-card:hover {
    transform: scale(1.15) translateY(-8px);
    z-index: 100;
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.6);
    border-color: rgba(255, 255, 255, 0.3);
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.15), rgba(255, 255, 255, 0.08));
}

.netflix-card:hover .netflix-card__overlay {
    opacity: 1;
}

.netflix-card__image-container {
    width: 100%;
    padding-top: 140%;
    position: relative;
    overflow: hidden;
    background-color: #1a1a1a;
}

.netflix-card__image {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.netflix-card:hover .netflix-card__image {
    transform: scale(1.1);
}

.netflix-card__label {
    position: absolute;
    top: 10px;
    right: 10px;
    background-color: #e50914;
    color: white;
    padding: 4px 10px;
    font-size: 11px;
    font-weight: 700;
    border-radius: 3px;
    text-transform: uppercase;
    z-index: 10;
    letter-spacing: 0.5px;
}

.netflix-card__label--hot {
    background-color: #ff6b00;
}

.netflix-card__label--new {
    background-color: #00ab66;
}

.netflix-card__label--jackpot {
    background-color: #ffd700;
    color: #000;
}

.netflix-card__overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(to top, rgba(0,0,0,0.95) 0%, rgba(0,0,0,0.7) 50%, transparent 100%);
    padding: 20px 12px 12px;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.netflix-card__title {
    color: #ffffff;
    font-size: 14px;
    font-weight: 600;
    margin: 0 0 8px 0;
    line-height: 1.3;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
}

.netflix-card__actions {
    display: flex;
    gap: 8px;
    margin-top: 10px;
}

.netflix-card__button {
    flex: 1;
    padding: 8px 12px;
    border: none;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    text-decoration: none;
    text-align: center;
    display: block;
}

.netflix-card__button--primary {
    background-color: #ffffff;
    color: #000000;
}

.netflix-card__button--primary:hover {
    background-color: #d4d4d4;
}

.netflix-card__button--secondary {
    background-color: rgba(109, 109, 110, 0.7);
    color: #ffffff;
}

.netflix-card__button--secondary:hover {
    background-color: rgba(109, 109, 110, 0.9);
}

.netflix-nav {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background-color: rgba(0,0,0,0.7);
    color: white;
    border: none;
    width: 50px;
    height: 100px;
    cursor: pointer;
    z-index: 50;
    transition: background-color 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 32px;
    font-weight: 300;
}

.netflix-nav:hover {
    background-color: rgba(0,0,0,0.9);
}

.netflix-nav--left {
    left: 0;
    border-radius: 0 4px 4px 0;
}

.netflix-nav--right {
    right: 0;
    border-radius: 4px 0 0 4px;
}

.netflix-nav:disabled {
    opacity: 0;
    cursor: default;
}

@media (max-width: 1200px) {
    .netflix-card {
        flex: 0 0 calc((100% - 30px) / 4);
        max-width: calc((100% - 30px) / 4);
    }
}

@media (max-width: 768px) {
    .netflix-row {
        padding: 0 20px;
    }
    
    .netflix-card {
        flex: 0 0 calc((100% - 20px) / 3);
        max-width: calc((100% - 20px) / 3);
        min-width: 120px;
    }
    
    .netflix-row__title {
        font-size: 20px;
    }
}

@media (max-width: 480px) {
    .netflix-card {
        flex: 0 0 calc((100% - 10px) / 2);
        max-width: calc((100% - 10px) / 2);
    }
    
    .netflix-nav {
        width: 40px;
        height: 80px;
    }
}
</style>

@php
if(Auth::check() && auth()->user()->email == 'demo01@gmail.com'){
    \Auth::logout();
    echo "<script>location.reload()</script>";
}
if(Auth::check()){
    $currency = auth()->user()->present()->shop ? auth()->user()->present()->shop->currency : '';
} else{
    $currency = '';
}
@endphp

<main class="carcass__body netflix-gallery">
    @foreach($categoriesWithGames as $categoryData)
    <div class="netflix-row">
        <div class="netflix-row__header">
            <h2 class="netflix-row__title">{{ $categoryData['title'] }}</h2>
            <a href="{{ route('frontend.game.list.category', $categoryData['key']) }}" class="netflix-row__view-all">
                View All &rsaquo;
            </a>
        </div>
        
        <div class="netflix-slider">
            <button class="netflix-nav netflix-nav--left" onclick="scrollSlider('{{ $categoryData['key'] }}', -1)" id="prev-{{ $categoryData['key'] }}" disabled>&lt;</button>
            
            <div class="netflix-slider__container" id="slider-{{ $categoryData['key'] }}" onscroll="updateNavButtons('{{ $categoryData['key'] }}')">
                @foreach($categoryData['games'] as $game)
                <div class="netflix-card">
                    <div class="netflix-card__image-container">
                        <img class="netflix-card__image" 
                             src="{{ $game->name ? '/frontend/Default/ico/' . $game->name . '.jpg' : '' }}" 
                             alt="{{ $game->title }}"
                             loading="lazy">
                        
                        @if($game->label)
                        <div class="netflix-card__label netflix-card__label--{{ strtolower($game->label) }}">
                            {{ $game->label }}
                        </div>
                        @endif
                    </div>
                    
                    <div class="netflix-card__overlay">
                        <h3 class="netflix-card__title">{{ $game->title }}</h3>
                        <div class="netflix-card__actions">
                            @if(isset(auth()->user()->username) && auth()->user()->balance > 0)
                                <a href="{{ route('frontend.game.go', $game->name) }}?api_exit=/" class="netflix-card__button netflix-card__button--primary">
                                    Play Now
                                </a>
                            @elseif(isset(auth()->user()->username) && auth()->user()->balance == 0)
                                <a href="javascript:;" class="netflix-card__button netflix-card__button--primary" ng-click="openModal($event, '#my-account')">
                                    Deposit
                                </a>  
                            @else
                                <a href="{{ route('frontend.game.go', $game->name) }}/prego?api_exit=/" class="netflix-card__button netflix-card__button--primary">
                                    Demo
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <button class="netflix-nav netflix-nav--right" onclick="scrollSlider('{{ $categoryData['key'] }}', 1)" id="next-{{ $categoryData['key'] }}">></button>
        </div>
    </div>
    @endforeach
</main>

<script>
function scrollSlider(category, direction) {
    const container = document.getElementById('slider-' + category);
    const scrollAmount = container.offsetWidth * 0.8;
    container.scrollBy({
        left: scrollAmount * direction,
        behavior: 'smooth'
    });
    
    setTimeout(() => updateNavButtons(category), 300);
}

function updateNavButtons(category) {
    const container = document.getElementById('slider-' + category);
    const prevBtn = document.getElementById('prev-' + category);
    const nextBtn = document.getElementById('next-' + category);
    
    if (!container || !prevBtn || !nextBtn) return;
    
    const isAtStart = container.scrollLeft <= 0;
    const isAtEnd = container.scrollLeft + container.offsetWidth >= container.scrollWidth - 5;
    
    prevBtn.disabled = isAtStart;
    nextBtn.disabled = isAtEnd;
}

document.addEventListener('DOMContentLoaded', function() {
    const sliders = document.querySelectorAll('.netflix-slider__container');
    sliders.forEach(slider => {
        const category = slider.id.replace('slider-', '');
        updateNavButtons(category);
    });
});
</script>
@stop

@section('scripts')
@stop
