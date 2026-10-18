@php
$sections = \App\Services\CalculatorCatalog::SECTIONS;
$calculatorCount = collect($sections)->sum(fn ($section) => count(config("{$section['config']}.calculators", [])));
$isHomeActive = request()->is('/');
$isConversionActive = request()->routeIs('conversion.*');
$isBiologyActive = request()->routeIs('biology.*');
$isChemistryActive = request()->routeIs('chemistry.*');
$isConstructionActive = request()->routeIs('construction.*');
$quickLinks = [];

foreach ($sections as $section) {
    foreach (config("{$section['config']}.categories", []) as $category) {
        $title = $category['title'] ?? null;
        $slug = $category['slug'] ?? null;
        $tools = $category['tools'] ?? [];

        // Each category links to its own section of that section's tools index; empty categories are not shown there.
        if (is_string($title) && $title !== '' && is_string($slug) && $slug !== '' && is_array($tools) && $tools !== []) {
            $quickLinks[] = [
                'title' => $title,
                'url' => route($section['index']).'#'.$slug,
                'count' => is_array($tools) ? count($tools) : 0,
            ];
        }
    }
}
@endphp

<header class="sticky top-0 z-40 border-b border-slate-200/80 bg-white/95 backdrop-blur supports-[backdrop-filter]:bg-white/80">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between gap-3 py-2 md:py-2.5">
            <a href="{{ url('/') }}" class="group flex min-w-0 items-center gap-2.5 rounded-lg px-1.5 py-0.5 transition-colors duration-200 hover:bg-slate-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2">
                <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg bg-blue-50 text-blue-600 transition-colors duration-200 group-hover:bg-blue-100">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="truncate text-sm font-semibold leading-tight tracking-tight text-slate-900 sm:text-base">SolveKit</p>
                    <p class="hidden truncate text-[10px] text-slate-500 lg:block">Professional Calculation Tools</p>
                </div>
            </a>

            <nav class="hidden md:flex items-center gap-1" aria-label="Primary navigation">
                <a
                    href="{{ url('/') }}"
                    class="inline-flex items-center rounded-lg px-2.5 py-1.5 text-[13px] font-medium transition-colors duration-200 {{ $isHomeActive ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}"
                >
                    Home
                </a>

                <a
                    href="{{ route('conversion.index') }}"
                    class="inline-flex items-center rounded-lg px-2.5 py-1.5 text-[13px] font-medium transition-colors duration-200 {{ $isConversionActive ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}"
                >
                    Conversion Tools
                </a>

                <a
                    href="{{ route('biology.index') }}"
                    class="inline-flex items-center rounded-lg px-2.5 py-1.5 text-[13px] font-medium transition-colors duration-200 {{ $isBiologyActive ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}"
                >
                    Biology &amp; Nature
                </a>

                <a
                    href="{{ route('chemistry.index') }}"
                    class="inline-flex items-center rounded-lg px-2.5 py-1.5 text-[13px] font-medium transition-colors duration-200 {{ $isChemistryActive ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}"
                >
                    Chemistry
                </a>


                <a
                    href="{{ route('construction.index') }}"
                    class="inline-flex items-center rounded-lg px-2.5 py-1.5 text-[13px] font-medium transition-colors duration-200 {{ $isConstructionActive ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}"
                >
                    Construction
                </a>

                <div class="relative group">
                    <button
                        type="button"
                        class="inline-flex items-center rounded-lg px-2.5 py-1.5 text-[13px] font-medium text-slate-600 transition-colors duration-200 hover:bg-slate-100 hover:text-slate-900 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
                        aria-haspopup="menu"
                    >
                        Quick Access
                        <svg class="ml-1 h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <div class="pointer-events-none absolute right-0 top-full z-50 pt-2 opacity-0 transition duration-200 group-hover:pointer-events-auto group-hover:opacity-100 group-focus-within:pointer-events-auto group-focus-within:opacity-100">
                        <div class="w-72 rounded-xl border border-slate-200 bg-white p-1.5 shadow-xl shadow-slate-900/10">
                            <p class="px-2 py-1.5 text-[10px] font-semibold uppercase tracking-wide text-slate-500">Jump to a category</p>

                            <div class="max-h-64 overflow-y-auto">
                                @foreach($quickLinks as $link)
                                    <a
                                        href="{{ $link['url'] }}"
                                        class="flex items-center justify-between rounded-lg px-2 py-1.5 text-[13px] text-slate-600 transition-colors duration-200 hover:bg-slate-50 hover:text-slate-900"
                                    >
                                        <span class="truncate">{{ $link['title'] }}</span>
                                        <span class="ml-2 inline-flex items-center rounded-full bg-slate-100 px-1.5 py-0.5 text-[10px] font-semibold text-slate-500">{{ $link['count'] }}</span>
                                    </a>
                                @endforeach
                            </div>

                            <a
                                href="{{ route('conversion.index') }}"
                                class="mt-1 flex items-center justify-between rounded-lg border border-slate-200 bg-slate-50 px-2 py-1.5 text-[13px] font-medium text-slate-700 transition-colors duration-200 hover:bg-slate-100"
                            >
                                <span>View all calculators</span>
                                <span class="text-[11px] text-slate-500">{{ $calculatorCount }}</span>
                            </a>
                        </div>
                    </div>
                </div>
            </nav>

            <div class="hidden md:flex items-center gap-2">
                <span class="hidden lg:inline-flex rounded-full border border-slate-200 bg-slate-50 px-2.5 py-0.5 text-[11px] font-semibold text-slate-600">{{ $calculatorCount }} calculators</span>
                <a
                    href="{{ route('conversion.index') }}"
                    class="inline-flex items-center rounded-lg bg-blue-600 px-3 py-1.5 text-[13px] font-semibold text-white shadow-sm transition-colors duration-200 hover:bg-blue-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
                >
                    Browse Tools
                    <svg class="ml-1 h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>

            <div class="md:hidden">
                <button
                    type="button"
                    id="mobile-menu-button"
                    class="inline-flex items-center justify-center rounded-lg border border-slate-200 bg-white p-1.5 text-slate-500 transition-colors duration-200 hover:bg-slate-50 hover:text-slate-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
                    aria-controls="mobile-menu"
                    aria-expanded="false"
                >
                    <span class="sr-only">Toggle main menu</span>
                    <svg id="menu-icon" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    <svg id="close-icon" class="hidden h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>

        <div id="mobile-menu" class="hidden border-t border-slate-200 pb-3 md:hidden">
            <div class="space-y-1 pt-3">
                <a
                    href="{{ url('/') }}"
                    class="block rounded-lg px-3 py-1.5 text-[13px] font-medium transition-colors duration-200 {{ $isHomeActive ? 'bg-blue-50 text-blue-700' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}"
                >
                    Home
                </a>

                <a
                    href="{{ route('conversion.index') }}"
                    class="block rounded-lg px-3 py-1.5 text-[13px] font-medium transition-colors duration-200 {{ $isConversionActive ? 'bg-blue-50 text-blue-700' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}"
                >
                    Conversion Tools
                </a>

                <a
                    href="{{ route('biology.index') }}"
                    class="block rounded-lg px-3 py-1.5 text-[13px] font-medium transition-colors duration-200 {{ $isBiologyActive ? 'bg-blue-50 text-blue-700' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}"
                >
                    Biology &amp; Nature
                </a>

                <a
                    href="{{ route('chemistry.index') }}"
                    class="block rounded-lg px-3 py-1.5 text-[13px] font-medium transition-colors duration-200 {{ $isChemistryActive ? 'bg-blue-50 text-blue-700' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}"
                >
                    Chemistry
                </a>


                <a
                    href="{{ route('construction.index') }}"
                    class="block rounded-lg px-3 py-1.5 text-[13px] font-medium transition-colors duration-200 {{ $isConstructionActive ? 'bg-blue-50 text-blue-700' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}"
                >
                    Construction
                </a>

                <div class="rounded-xl border border-slate-200 bg-slate-50/70">
                    <button
                        id="mobile-categories-button"
                        type="button"
                        class="flex w-full items-center justify-between rounded-xl px-3 py-1.5 text-left text-[13px] font-medium text-slate-700 transition-colors duration-200 hover:bg-slate-100 hover:text-slate-900"
                        aria-controls="mobile-categories-menu"
                        aria-expanded="false"
                    >
                        Quick Access Categories
                        <svg id="mobile-categories-icon" class="h-4 w-4 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <div id="mobile-categories-menu" class="hidden px-3 pb-2">
                        <div class="space-y-1 border-l border-slate-200 pl-3">
                            @foreach($quickLinks as $link)
                                <a
                                    href="{{ $link['url'] }}"
                                    class="flex items-center justify-between rounded-lg px-2 py-1.5 text-[13px] text-slate-600 transition-colors duration-200 hover:bg-white hover:text-slate-900"
                                >
                                    <span class="truncate">{{ $link['title'] }}</span>
                                    <span class="ml-2 inline-flex items-center rounded-full bg-slate-200 px-1.5 py-0.5 text-[10px] font-semibold text-slate-600">{{ $link['count'] }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                <a
                    href="{{ route('conversion.index') }}"
                    class="mt-1.5 block rounded-lg bg-blue-600 px-3 py-1.5 text-center text-[13px] font-semibold text-white transition-colors duration-200 hover:bg-blue-700"
                >
                    Browse All {{ $calculatorCount }} Calculators
                </a>
            </div>
        </div>
    </div>
</header>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    const menuIcon = document.getElementById('menu-icon');
    const closeIcon = document.getElementById('close-icon');

    const mobileCategoriesButton = document.getElementById('mobile-categories-button');
    const mobileCategoriesMenu = document.getElementById('mobile-categories-menu');
    const mobileCategoriesIcon = document.getElementById('mobile-categories-icon');

    const setExpanded = (element, expanded) => {
        if (element) {
            element.setAttribute('aria-expanded', expanded ? 'true' : 'false');
        }
    };

    const closeMobileCategories = () => {
        if (mobileCategoriesMenu) {
            mobileCategoriesMenu.classList.add('hidden');
        }

        if (mobileCategoriesIcon) {
            mobileCategoriesIcon.classList.remove('rotate-180');
        }

        setExpanded(mobileCategoriesButton, false);
    };

    const closeMobileMenu = () => {
        if (mobileMenu) {
            mobileMenu.classList.add('hidden');
        }

        if (menuIcon) {
            menuIcon.classList.remove('hidden');
        }

        if (closeIcon) {
            closeIcon.classList.add('hidden');
        }

        closeMobileCategories();
        setExpanded(mobileMenuButton, false);
    };

    if (mobileMenuButton && mobileMenu && menuIcon && closeIcon) {
        mobileMenuButton.addEventListener('click', function () {
            const shouldOpen = mobileMenu.classList.contains('hidden');

            if (shouldOpen) {
                mobileMenu.classList.remove('hidden');
                menuIcon.classList.add('hidden');
                closeIcon.classList.remove('hidden');
                setExpanded(mobileMenuButton, true);
            } else {
                closeMobileMenu();
            }
        });
    }

    if (mobileCategoriesButton && mobileCategoriesMenu && mobileCategoriesIcon) {
        mobileCategoriesButton.addEventListener('click', function () {
            const shouldOpen = mobileCategoriesMenu.classList.contains('hidden');

            if (shouldOpen) {
                mobileCategoriesMenu.classList.remove('hidden');
                mobileCategoriesIcon.classList.add('rotate-180');
                setExpanded(mobileCategoriesButton, true);
            } else {
                closeMobileCategories();
            }
        });
    }

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            closeMobileMenu();
        }
    });
});
</script>
@endpush
