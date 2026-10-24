<x-app-layout 
    title="SolveKit - Professional Calculation Tools"
    description="Professional-grade calculators for conversions, construction, finance, and more. Trusted by engineers, scientists, and professionals worldwide."
>
    <!-- Hero Section -->
    <section class="bg-gradient-to-br from-primary-50 via-white to-blue-50 py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <div class="mb-8">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-primary-100 rounded-full mb-6">
                        <svg class="w-12 h-12 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
                
                <h1 class="text-5xl md:text-6xl font-bold text-gray-900 mb-6 leading-tight">
                    Professional
                    <span class="text-primary-600 block">Calculation Tools</span>
                </h1>
                
                <p class="text-xl text-gray-600 mb-8 max-w-3xl mx-auto leading-relaxed">
                    Precision-engineered calculators for engineers, scientists, and technical professionals. 
                    Accurate, fast, and reliable tools for all your professional needs.
                </p>
                
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-12">
                    <a href="#categories" 
                       class="bg-primary-600 text-white px-8 py-4 rounded-lg shadow-lg hover:bg-primary-700 transition-all duration-200 font-semibold text-lg transform hover:scale-105 inline-flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        Explore Tools
                    </a>
                    <a href="{{ route('feature-request.create') }}" 
                       class="border-2 border-primary-600 text-primary-600 px-8 py-4 rounded-lg hover:bg-primary-50 transition-all duration-200 font-semibold text-lg inline-flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8h-16"></path>
                        </svg>
                        Request a feature
                    </a>
                </div>

                <!-- Trust Indicators -->
                <div class="bg-white rounded-2xl shadow-lg p-8 max-w-4xl mx-auto">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-primary-600 mb-2">100+</div>
                            <div class="text-sm text-gray-600">Professional Tools</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-primary-600 mb-2">99.9%</div>
                            <div class="text-sm text-gray-600">Accuracy Rate</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-primary-600 mb-2">24/7</div>
                            <div class="text-sm text-gray-600">Available</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-primary-600 mb-2">Free</div>
                            <div class="text-sm text-gray-600">Always</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<!-- Categories Section -->
<section id="categories" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Choose Your Category</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Professional calculation tools organized by industry and use case
            </p>
        </div>

        @php
            /*
             * One card per calculator section. Colour classes are written out in full so Tailwind keeps them.
             * Icons are 24 × 24 outline paths.
             */
            $sections = [
                ['config' => 'conversion', 'route' => 'conversion.index', 'title' => 'Conversion Tools', 'description' => 'Professional unit conversion calculators for engineering and scientific applications.', 'icon' => 'M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4', 'border' => 'hover:border-blue-300', 'badge' => 'bg-blue-100 group-hover:bg-blue-200', 'tint' => 'text-blue-600', 'link' => 'text-blue-600 group-hover:text-blue-700'],
                ['config' => 'biology', 'route' => 'biology.index', 'title' => 'Biology & Nature', 'description' => 'Gardening, trees, laboratory, genetics, animal and livestock calculators.', 'icon' => 'M5 21c.5-8.5 6-14.5 15-16-.5 9-6.5 14.5-15 16zm0 0l7-7', 'border' => 'hover:border-lime-300', 'badge' => 'bg-lime-100 group-hover:bg-lime-200', 'tint' => 'text-lime-600', 'link' => 'text-lime-600 group-hover:text-lime-700'],
                ['config' => 'chemistry', 'route' => 'chemistry.index', 'title' => 'Chemistry', 'description' => 'Stoichiometry, solutions, reactions, thermodynamics and physical chemistry.', 'icon' => 'M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z', 'border' => 'hover:border-cyan-300', 'badge' => 'bg-cyan-100 group-hover:bg-cyan-200', 'tint' => 'text-cyan-600', 'link' => 'text-cyan-600 group-hover:text-cyan-700'],
                ['config' => 'construction', 'route' => 'construction.index', 'title' => 'Construction', 'description' => 'Concrete, lumber, roofing, stairs, tanks, fasteners and electrical calculators.', 'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4', 'border' => 'hover:border-orange-300', 'badge' => 'bg-orange-100 group-hover:bg-orange-200', 'tint' => 'text-orange-600', 'link' => 'text-orange-600 group-hover:text-orange-700'],
                ['config' => 'ecology', 'route' => 'ecology.index', 'title' => 'Ecology', 'description' => 'Carbon footprint, renewable energy and sustainable living calculators.', 'icon' => 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'border' => 'hover:border-emerald-300', 'badge' => 'bg-emerald-100 group-hover:bg-emerald-200', 'tint' => 'text-emerald-600', 'link' => 'text-emerald-600 group-hover:text-emerald-700'],
                ['config' => 'everyday', 'route' => 'everyday.index', 'title' => 'Everyday Life', 'description' => 'Dates and times, transport, clothing, the home, work, school and leisure.', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6', 'border' => 'hover:border-amber-300', 'badge' => 'bg-amber-100 group-hover:bg-amber-200', 'tint' => 'text-amber-600', 'link' => 'text-amber-600 group-hover:text-amber-700'],
                ['config' => 'finance', 'route' => 'finance.index', 'title' => 'Finance', 'description' => 'Loans, mortgages, savings, investing, retirement, tax and business planning.', 'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'border' => 'hover:border-green-300', 'badge' => 'bg-green-100 group-hover:bg-green-200', 'tint' => 'text-green-600', 'link' => 'text-green-600 group-hover:text-green-700'],
                ['config' => 'food', 'route' => 'food.index', 'title' => 'Food & Cooking', 'description' => 'Cups to grams, recipe and baking maths, drinks, party planning and food safety.', 'icon' => 'M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.701 2.701 0 00-1.5-.454M9 6v2m3-2v2m3-2v2M9 3h.01M12 3h.01M15 3h.01M21 21v-7a2 2 0 00-2-2H5a2 2 0 00-2 2v7h18zm-3-9v-2a2 2 0 00-2-2H8a2 2 0 00-2 2v2h12z', 'border' => 'hover:border-rose-300', 'badge' => 'bg-rose-100 group-hover:bg-rose-200', 'tint' => 'text-rose-600', 'link' => 'text-rose-600 group-hover:text-rose-700'],
                ['config' => 'health', 'route' => 'health.index', 'title' => 'Health & Fitness', 'description' => 'Body measurements, nutrition, pregnancy, sleep and validated clinical scores.', 'icon' => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z', 'border' => 'hover:border-red-300', 'badge' => 'bg-red-100 group-hover:bg-red-200', 'tint' => 'text-red-600', 'link' => 'text-red-600 group-hover:text-red-700'],
                ['config' => 'math', 'route' => 'math.index', 'title' => 'Math', 'description' => 'Percentages, fractions, algebra, geometry, trigonometry, matrices and more.', 'icon' => 'M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z', 'border' => 'hover:border-purple-300', 'badge' => 'bg-purple-100 group-hover:bg-purple-200', 'tint' => 'text-purple-600', 'link' => 'text-purple-600 group-hover:text-purple-700'],
                ['config' => 'physics', 'route' => 'physics.index', 'title' => 'Physics', 'description' => 'Motion, energy, waves, light, electricity, fluids, heat and quantum physics.', 'icon' => 'M13 10V3L4 14h7v7l9-11h-7z', 'border' => 'hover:border-indigo-300', 'badge' => 'bg-indigo-100 group-hover:bg-indigo-200', 'tint' => 'text-indigo-600', 'link' => 'text-indigo-600 group-hover:text-indigo-700'],
                ['config' => 'sports', 'route' => 'sports.index', 'title' => 'Sports', 'description' => 'Cricket, baseball, running, cycling, swimming, strength and scoring.', 'icon' => 'M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9', 'border' => 'hover:border-sky-300', 'badge' => 'bg-sky-100 group-hover:bg-sky-200', 'tint' => 'text-sky-600', 'link' => 'text-sky-600 group-hover:text-sky-700'],
                ['config' => 'statistics', 'route' => 'statistics.index', 'title' => 'Statistics', 'description' => 'Probability, distributions, hypothesis tests, p-values and regression.', 'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z', 'border' => 'hover:border-violet-300', 'badge' => 'bg-violet-100 group-hover:bg-violet-200', 'tint' => 'text-violet-600', 'link' => 'text-violet-600 group-hover:text-violet-700'],
                ['config' => 'technology', 'route' => 'technology.index', 'title' => 'Technology', 'description' => 'Encoders and hashes, electronics, networking, photography, video and music.', 'icon' => 'M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z', 'border' => 'hover:border-slate-300', 'badge' => 'bg-slate-100 group-hover:bg-slate-200', 'tint' => 'text-slate-600', 'link' => 'text-slate-600 group-hover:text-slate-700'],
                ['config' => 'other', 'route' => 'other.index', 'title' => 'Other', 'description' => 'Education, video games, logistics, holidays, earth and weather, and more.', 'icon' => 'M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z', 'border' => 'hover:border-teal-300', 'badge' => 'bg-teal-100 group-hover:bg-teal-200', 'tint' => 'text-teal-600', 'link' => 'text-teal-600 group-hover:text-teal-700'],
            ];
        @endphp
        <div class="mx-auto flex max-w-5xl flex-wrap justify-center gap-8">
            @foreach($sections as $section)
                @continue(! Route::has($section['route']))
                <a href="{{ route($section['route']) }}" class="group w-full md:w-80 bg-white border border-gray-200 rounded-xl p-6 {{ $section['border'] }} hover:shadow-lg transition-all duration-200 transform hover:scale-105">
                    <div class="text-center">
                        <div class="inline-flex items-center justify-center w-12 h-12 {{ $section['badge'] }} rounded-lg mb-4 transition-colors duration-200">
                            <svg class="w-6 h-6 {{ $section['tint'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $section['icon'] }}"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $section['title'] }}</h3>
                        <p class="text-gray-600 text-sm mb-4">{{ $section['description'] }}</p>
                        <div class="inline-flex items-center {{ $section['link'] }} font-medium text-sm">
                            Explore {{ number_format(count(config("{$section['config']}.calculators", []))) }} tools
                            <svg class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </div>
                    </div>
                </a>
            @endforeach

            <x-ads type="feed" placement="home-category-grid" class="w-full md:w-80" />
        </div>
    </div>
</section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Why Choose SolveKit?</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Professional-grade calculation tools designed for accuracy, speed, and reliability
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <div class="text-center group">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 rounded-full mb-6 group-hover:bg-blue-200 transition-colors duration-200">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Precision Accuracy</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Industry-standard calculation methods ensure precise results for all tools. Trusted by professionals worldwide.
                    </p>
                </div>

                <div class="text-center group">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mb-6 group-hover:bg-green-200 transition-colors duration-200">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Lightning Fast</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Instant calculations with real-time results as you type. No waiting, no delays - just immediate, accurate results.
                    </p>
                </div>

                <div class="text-center group">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-purple-100 rounded-full mb-6 group-hover:bg-purple-200 transition-colors duration-200">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">All Devices</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Responsive design works perfectly on all devices and screen sizes. Access your tools anywhere, anytime.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-br from-primary-600 to-primary-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl font-bold text-white mb-6">Ready to Get Started?</h2>
            <p class="text-xl text-primary-100 mb-8 max-w-2xl mx-auto">
                Join thousands of professionals who trust SolveKit for their daily calculation needs.
            </p>
            <a href="#categories" 
               class="inline-flex items-center bg-white text-primary-600 px-8 py-4 rounded-lg shadow-lg hover:bg-gray-50 transition-all duration-200 font-semibold text-lg transform hover:scale-105">
                Choose Your Category
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                </svg>
            </a>
        </div>
    </section>

    <x-ads type="multiplex" placement="home-bottom" class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8" />
</x-app-layout>
