<!-- Trending Prompts -->
<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('admin.trending-prompts.*') ? 'active' : '' }}" 
       href="{{ route('admin.trending-prompts.index') }}">
        <i class="fas fa-fire"></i>
        <span>Trending Prompts</span>
    </a>
</li> 