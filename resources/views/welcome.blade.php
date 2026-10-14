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

        <div class="mx-auto flex max-w-5xl flex-wrap justify-center gap-8">
            <!-- Conversion Tools Category -->
            <a href="{{ route('conversion.index') }}" class="group w-full md:w-80 bg-white border border-gray-200 rounded-xl p-6 hover:border-blue-300 hover:shadow-lg transition-all duration-200 transform hover:scale-105">
                <div class="text-center">
                    <div class="inline-flex items-center justify-center w-12 h-12 bg-blue-100 rounded-lg mb-4 group-hover:bg-blue-200 transition-colors duration-200">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Conversion Tools</h3>
                    <p class="text-gray-600 text-sm mb-4">
                        Professional unit conversion calculators for engineering and scientific applications.
                    </p>
                    <div class="inline-flex items-center text-blue-600 font-medium text-sm group-hover:text-blue-700">
                        Explore Tools
                        <svg class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </div>
                </div>
            </a>

            <x-ads type="feed" placement="home-category-grid" class="w-full md:w-80" />

            {{-- <!-- Construction Tools Category -->
            <a href="{{ route('construction.index') }}" class="group bg-white border border-gray-200 rounded-xl p-6 hover:border-orange-300 hover:shadow-lg transition-all duration-200 transform hover:scale-105">
                <div class="text-center">
                    <div class="inline-flex items-center justify-center w-12 h-12 bg-orange-100 rounded-lg mb-4 group-hover:bg-orange-200 transition-colors duration-200">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Construction Tools</h3>
                    <p class="text-gray-600 text-sm mb-4">
                        Essential calculators for construction professionals and project planning.
                    </p>
                    <div class="inline-flex items-center text-orange-600 font-medium text-sm group-hover:text-orange-700">
                        Explore Tools
                        <svg class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </div>
                </div>
            </a>

            <!-- Financial Tools Category -->
            <a href="{{ route('financial.index') }}" class="group bg-white border border-gray-200 rounded-xl p-6 hover:border-green-300 hover:shadow-lg transition-all duration-200 transform hover:scale-105">
                <div class="text-center">
                    <div class="inline-flex items-center justify-center w-12 h-12 bg-green-100 rounded-lg mb-4 group-hover:bg-green-200 transition-colors duration-200">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Financial Tools</h3>
                    <p class="text-gray-600 text-sm mb-4">
                        Comprehensive financial calculators for investments and business planning.
                    </p>
                    <div class="inline-flex items-center text-green-600 font-medium text-sm group-hover:text-green-700">
                        Explore Tools
                        <svg class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </div>
                </div>
            </a>

            <!-- Health & Fitness Category -->
            <a href="{{ route('health.index') }}" class="group bg-white border border-gray-200 rounded-xl p-6 hover:border-red-300 hover:shadow-lg transition-all duration-200 transform hover:scale-105">
                <div class="text-center">
                    <div class="inline-flex items-center justify-center w-12 h-12 bg-red-100 rounded-lg mb-4 group-hover:bg-red-200 transition-colors duration-200">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Health & Fitness</h3>
                    <p class="text-gray-600 text-sm mb-4">
                        Health and fitness calculators for wellness and nutritional planning.
                    </p>
                    <div class="inline-flex items-center text-red-600 font-medium text-sm group-hover:text-red-700">
                        Explore Tools
                        <svg class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </div>
                </div>
            </a>

            <!-- Math & Science Category -->
            <a href="{{ route('math.index') }}" class="group bg-white border border-gray-200 rounded-xl p-6 hover:border-purple-300 hover:shadow-lg transition-all duration-200 transform hover:scale-105">
                <div class="text-center">
                    <div class="inline-flex items-center justify-center w-12 h-12 bg-purple-100 rounded-lg mb-4 group-hover:bg-purple-200 transition-colors duration-200">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Math & Science</h3>
                    <p class="text-gray-600 text-sm mb-4">
                        Advanced mathematical and scientific calculators for research and education.
                    </p>
                    <div class="inline-flex items-center text-purple-600 font-medium text-sm group-hover:text-purple-700">
                        Explore Tools
                        <svg class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </div>
                </div>
            </a>

            <!-- Business Tools Category -->
            <a href="{{ route('business.index') }}" class="group bg-white border border-gray-200 rounded-xl p-6 hover:border-indigo-300 hover:shadow-lg transition-all duration-200 transform hover:scale-105">
                <div class="text-center">
                    <div class="inline-flex items-center justify-center w-12 h-12 bg-indigo-100 rounded-lg mb-4 group-hover:bg-indigo-200 transition-colors duration-200">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Business Tools</h3>
                    <p class="text-gray-600 text-sm mb-4">
                        Business calculation tools for analysis, planning, and operational metrics.
                    </p>
                    <div class="inline-flex items-center text-indigo-600 font-medium text-sm group-hover:text-indigo-700">
                        Explore Tools
                        <svg class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </div>
                </div>
            </a> --}}
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
