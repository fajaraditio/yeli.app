<div class="flex items-center gap-2">
    <img src="{{ asset('/images/logo-yeli.png') }}" alt="Logo" class="h-14 w-auto">
    @auth
        <span>{{ $panel->getBrandName() }}</span>
    @endauth
</div>
