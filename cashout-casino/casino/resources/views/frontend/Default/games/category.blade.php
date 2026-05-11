@extends('frontend.Default.layouts.app')

@section('page-title', $title)
@section('body', $body)
@section('keywords', $keywords)
@section('description', $description)

@section('content')
<style type="text/css">
    @charset "UTF-8";
    [ng\:cloak], [ng-cloak], [data-ng-cloak], [x-ng-cloak], .ng-cloak, .x-ng-cloak, .ng-hide:not(.ng-hide-animate) { display: none !important; }
    ng\:form { display: block; }
    .ng-animate-shim { visibility: hidden; }
    .ng-anchor { position: absolute; }
    html, body, .carcass, .carcass__body, .main-content, .contain, .main, .footer { background: #ffffff !important; }
</style>

@php
    if(Auth::check() && auth()->user()->email == 'demo01@gmail.com'){
        \Auth::logout();
        echo "<script>location.reload()</script>";
    }
    $currency = Auth::check() && auth()->user()->present()->shop ? auth()->user()->present()->shop->currency : '';
    
    $categoryTitle = ucfirst($category1);
    if($cat1) {
        $categoryTitle = $cat1->title ?? ucfirst($category1);
    }
@endphp

<main class="carcass__body">
    <div class="main-content">
        <div class="contain">
            <div class="ng-scope">
                <div class="category-page">
                    <div class="category-page__header">
                        <a href="/" class="category-page__back">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"/></svg>
                            Back
                        </a>
                        <h1 class="category-page__title">{{ $categoryTitle }}</h1>
                    </div>
                    
                    <div class="category-page__search">
                        <input type="text" placeholder="Search {{ $categoryTitle }} games..." class="category-search-input" id="categorySearchInput">
                        <svg class="category-search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
                        </svg>
                    </div>
                    
                    <div class="category-page__grid" id="categoryGamesGrid">
                        @if ($games && count($games))
                            @foreach ($games as $game)
                            <a href="@if(isset(auth()->user()->username) && auth()->user()->balance > 0){{ route('frontend.game.go', $game->name) }}?api_exit=/@else{{ route('frontend.game.go', $game->name) }}/prego?api_exit=/@endif" class="category-game-card" data-title="{{ strtolower($game->title) }}">
                                <img class="category-game-card__image" src="/frontend/Default/ico/{{ $game->name }}.jpg" alt="{{ $game->title }}" loading="lazy">
                                <div class="category-game-card__overlay">
                                    <span class="category-game-card__title">{{ $game->title }}</span>
                                </div>
                                @if($game->label)<span class="category-game-card__badge">{{ $game->label }}</span>@endif
                            </a>
                            @endforeach
                        @else
                            <div class="category-page__empty">
                                <p>No games found in this category.</p>
                            </div>
                        @endif
                    </div>
                    
                    <div class="category-page__pagination">
                        {{ $games->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('categorySearchInput');
    const gamesGrid = document.getElementById('categoryGamesGrid');
    
    if (searchInput && gamesGrid) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase().trim();
            const gameCards = gamesGrid.querySelectorAll('.category-game-card');
            
            gameCards.forEach(function(card) {
                const title = card.getAttribute('data-title') || '';
                if (searchTerm === '' || title.includes(searchTerm)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    }
});
</script>
@endsection
