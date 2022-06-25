{{-- For submenu --}}
@php
    $subAuthUser = Auth::user();
@endphp
<ul class="menu-content">
    @if (isset($menu))
        @foreach ($menu as $submenu)
            @if ($subAuthUser->hasAnyPermission(explode('|', $submenu->permissions)))
                <li class="{{ $submenu->slug === Route::currentRouteName() ? 'active' : '' }}">
                    <a href="{{ isset($submenu->url) ? url($submenu->url) : '#' }}" class="d-flex align-items-center" target="{{ isset($submenu->newTab) && $submenu->newTab === true ? '_blank' : '_self' }}">
                        @if (isset($submenu->icon))
                            <i data-feather="{{ $submenu->icon }}"></i>
                        @endif
                        <span class="menu-item">{{ __('locale.' . $submenu->name) }}</span>

                        @if (isset($submenu->submenu))
                            @include('panels/submenu', ['menu' => $submenu->submenu])
                        @endif
                    </a>
                </li>
            @endif
        @endforeach
    @endif
</ul>
