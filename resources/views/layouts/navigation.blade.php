<nav x-data="{ open: false }" class="hidden md:flex bg-white border-r-4 border-slate-900 h-screen w-64 shadow-[8px_0px_0px_0px_rgba(30,41,59,1)] flex-col gap-4 p-6 fixed left-0 top-0 overflow-y-auto z-40">

    <!-- Brand -->
    <div class="flex items-center gap-0 mb-8">
        <img src="/logo/logo-figco-tran.png" alt="" class="h-14 w-auto object-contain flex-shrink-0" />
        <div>
            <img src="/logo/FIGCO.png" alt="FigCo" class="h-14 w-auto object-contain" />
            <p class="font-technical-xs text-technical-xs text-slate-500 uppercase tracking-widest">{{ __('Teacher Mode') }}</p>
        </div>
    </div>

    <!-- Nav Links -->
    <div class="flex-grow flex flex-col gap-2">
        <!-- Dashboard -->
        <a href="{{ route('dashboard') }}"
           class="flex items-center gap-3 px-4 py-3 border-2 font-technical-sm text-technical-sm transition-all
                  {{ request()->routeIs('dashboard')
                      ? 'bg-blue-500 text-white border-slate-900 shadow-[4px_4px_0px_0px_rgba(30,41,59,1)] -translate-x-[2px]'
                      : 'text-slate-700 border-transparent hover:border-slate-900 hover:translate-x-1 hover:bg-surface-container-low' }}">
            <span class="material-symbols-outlined" style="{{ request()->routeIs('dashboard') ? 'font-variation-settings: \'FILL\' 1;' : '' }}">dashboard</span>
            <span>{{ __('Dashboard') }}</span>
        </a>

        <!-- AI Chat -->
        <a href="{{ route('chat.index') }}"
           class="flex items-center gap-3 px-4 py-3 border-2 font-technical-sm text-technical-sm transition-all
                  {{ request()->routeIs('chat.*')
                      ? 'bg-blue-500 text-white border-slate-900 shadow-[4px_4px_0px_0px_rgba(30,41,59,1)] -translate-x-[2px]'
                      : 'text-slate-700 border-transparent hover:border-slate-900 hover:translate-x-1 hover:bg-surface-container-low' }}">
            <span class="material-symbols-outlined" style="{{ request()->routeIs('chat.*') ? 'font-variation-settings: \'FILL\' 1;' : '' }}">chat</span>
            <span>{{ __('AI Assistant') }}</span>
        </a>

        <!-- Homework Generator -->
        <a href="{{ route('homework.index') }}"
           class="flex items-center gap-3 px-4 py-3 border-2 font-technical-sm text-technical-sm transition-all
                  {{ request()->routeIs('homework.*')
                      ? 'bg-blue-500 text-white border-slate-900 shadow-[4px_4px_0px_0px_rgba(30,41,59,1)] -translate-x-[2px]'
                      : 'text-slate-700 border-transparent hover:border-slate-900 hover:translate-x-1 hover:bg-surface-container-low' }}">
            <span class="material-symbols-outlined" style="{{ request()->routeIs('homework.*') ? 'font-variation-settings: \'FILL\' 1;' : '' }}">assignment</span>
            <span>{{ __('Homework Generator') }}</span>
        </a>

        <!-- Divider -->
        <div class="border-t-2 border-dashed border-slate-200 my-2"></div>

        <!-- API Keys -->
        <a href="{{ route('api-keys') }}"
           class="flex items-center gap-3 px-4 py-3 border-2 font-technical-sm text-technical-sm transition-all
                  {{ request()->routeIs('api-keys*')
                      ? 'bg-blue-500 text-white border-slate-900 shadow-[4px_4px_0px_0px_rgba(30,41,59,1)] -translate-x-[2px]'
                      : 'text-slate-700 border-transparent hover:border-slate-900 hover:translate-x-1 hover:bg-surface-container-low' }}">
            <span class="material-symbols-outlined" style="{{ request()->routeIs('api-keys*') ? 'font-variation-settings: \'FILL\' 1;' : '' }}">key</span>
            <span>{{ __('API Keys') }}</span>
        </a>

        <!-- Settings -->
        <a href="{{ route('profile.edit') }}"
           class="flex items-center gap-3 px-4 py-3 border-2 font-technical-sm text-technical-sm transition-all
                  {{ request()->routeIs('profile.*')
                      ? 'bg-blue-500 text-white border-slate-900 shadow-[4px_4px_0px_0px_rgba(30,41,59,1)] -translate-x-[2px]'
                      : 'text-slate-700 border-transparent hover:border-slate-900 hover:translate-x-1 hover:bg-surface-container-low' }}">
            <span class="material-symbols-outlined" style="{{ request()->routeIs('profile.*') ? 'font-variation-settings: \'FILL\' 1;' : '' }}">manage_accounts</span>
            <span>{{ __('Settings') }}</span>
        </a>
    </div>

    <!-- User Info + Logout -->
    <div class="mt-auto flex flex-col gap-3 border-t-2 border-slate-200 pt-4">
        <div class="flex items-center gap-3 px-2">
            <div class="w-8 h-8 bg-primary-fixed border-2 border-slate-900 pixel-border flex items-center justify-center flex-shrink-0">
                <span class="material-symbols-outlined text-[16px] text-on-primary-fixed">school</span>
            </div>
            <div class="min-w-0">
                <p class="font-technical-sm text-technical-sm text-slate-900 truncate font-bold">{{ Auth::user()->name }}</p>
                <p class="font-technical-xs text-technical-xs text-slate-500 truncate">{{ Auth::user()->email }}</p>
            </div>
        </div>

        <!-- Language Switcher -->
        <div class="flex gap-2">
            <a href="{{ route('locale.switch', 'en') }}"
               class="flex-1 text-center px-3 py-2 border-2 font-technical-xs text-technical-xs transition-colors
                      {{ app()->getLocale() === 'en' ? 'bg-slate-900 text-white border-slate-900' : 'border-slate-300 text-slate-500 hover:border-slate-600 hover:text-slate-700' }}">
                EN
            </a>
            <a href="{{ route('locale.switch', 'km') }}"
               class="flex-1 text-center px-3 py-2 border-2 font-technical-xs text-technical-xs transition-colors
                      {{ app()->getLocale() === 'km' ? 'bg-slate-900 text-white border-slate-900' : 'border-slate-300 text-slate-500 hover:border-slate-600 hover:text-slate-700' }}"
               style="font-family: 'Kantumruy Pro', sans-serif;">
                ខ្មែរ
            </a>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="w-full flex items-center gap-3 px-4 py-3 bg-white border-2 border-slate-900 pixel-shadow btn-hover transition-transform font-technical-xs text-technical-xs uppercase tracking-wider font-bold text-slate-700 hover:bg-error-container hover:text-on-error-container hover:border-error">
                <span class="material-symbols-outlined text-[18px]">logout</span>
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</nav>

<!-- Mobile Topbar -->
<div class="md:hidden bg-white border-b-4 border-slate-900 px-4 py-3 flex items-center justify-between shadow-[0px_4px_0px_0px_rgba(30,41,59,1)] sticky top-0 z-40 w-full" x-data="{ mobileOpen: false }">
    <div class="flex items-center gap-0">
        <img src="/logo/logo-figco-tran.png" alt="" class="h-8 w-auto object-contain" />
        <img src="/logo/FIGCO.png" alt="FigCo" class="h-8 w-auto object-contain" />
    </div>

    <button @click="mobileOpen = !mobileOpen" class="border-2 border-slate-900 p-2 hover:bg-surface-container transition-colors">
        <span class="material-symbols-outlined" x-text="mobileOpen ? 'close' : 'menu'">menu</span>
    </button>

    <div x-show="mobileOpen" x-cloak
         class="absolute top-full left-0 right-0 bg-white border-b-4 border-slate-900 shadow-[0px_8px_0px_0px_rgba(30,41,59,1)] flex flex-col z-50">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-6 py-4 border-b-2 border-slate-100 font-technical-sm text-technical-sm text-slate-700 hover:bg-surface-container-low">
            <span class="material-symbols-outlined text-[20px]">dashboard</span> {{ __('Dashboard') }}
        </a>
        <a href="{{ route('chat.index') }}" class="flex items-center gap-3 px-6 py-4 border-b-2 border-slate-100 font-technical-sm text-technical-sm text-slate-700 hover:bg-surface-container-low">
            <span class="material-symbols-outlined text-[20px]">chat</span> {{ __('AI Assistant') }}
        </a>
        <a href="{{ route('homework.index') }}" class="flex items-center gap-3 px-6 py-4 border-b-2 border-slate-100 font-technical-sm text-technical-sm text-slate-700 hover:bg-surface-container-low">
            <span class="material-symbols-outlined text-[20px]">assignment</span> {{ __('Homework Generator') }}
        </a>
        <a href="{{ route('api-keys') }}" class="flex items-center gap-3 px-6 py-4 border-b-2 border-slate-100 font-technical-sm text-technical-sm text-slate-700 hover:bg-surface-container-low">
            <span class="material-symbols-outlined text-[20px]">key</span> {{ __('API Keys') }}
        </a>
        <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-6 py-4 border-b-2 border-slate-100 font-technical-sm text-technical-sm text-slate-700 hover:bg-surface-container-low">
            <span class="material-symbols-outlined text-[20px]">manage_accounts</span> {{ __('Settings') }}
        </a>
        <div class="flex gap-2 px-4 py-3 border-b-2 border-slate-100">
            <a href="{{ route('locale.switch', 'en') }}"
               class="flex-1 text-center px-3 py-2 border-2 font-technical-xs text-technical-xs transition-colors
                      {{ app()->getLocale() === 'en' ? 'bg-slate-900 text-white border-slate-900' : 'border-slate-300 text-slate-500 hover:border-slate-600 hover:text-slate-700' }}">
                EN
            </a>
            <a href="{{ route('locale.switch', 'km') }}"
               class="flex-1 text-center px-3 py-2 border-2 font-technical-xs text-technical-xs transition-colors
                      {{ app()->getLocale() === 'km' ? 'bg-slate-900 text-white border-slate-900' : 'border-slate-300 text-slate-500 hover:border-slate-600 hover:text-slate-700' }}"
               style="font-family: 'Kantumruy Pro', sans-serif;">
                ខ្មែរ
            </a>
        </div>
        <form method="POST" action="{{ route('logout') }}" class="p-4">
            @csrf
            <button type="submit" class="w-full border-2 border-slate-900 px-4 py-3 font-technical-xs text-technical-xs uppercase tracking-wider font-bold text-slate-700 hover:bg-error-container pixel-shadow btn-hover transition-transform">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</div>
