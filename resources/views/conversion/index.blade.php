<x-app-layout 
    title="SolveKit - Professional Conversion Tools"
    description="Professional-grade calculators for accurate unit conversions across length, weight, pressure, torque, and more.">

    <!-- Hero Section -->
    <section class="bg-gradient-to-br from-primary-50 to-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">
                Precision Conversion Tools
            </h1>
            <p class="text-xl text-gray-600 mb-8 max-w-3xl mx-auto">
                Professional-grade calculators for accurate unit conversions across length, weight, pressure, torque, and more.
            </p>
            <div class="flex justify-center">
                <div class="bg-white rounded-lg shadow-sm p-6 max-w-md w-full">
                    <div class="flex items-center justify-center space-x-4 text-sm text-gray-500">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-1 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            Accurate
                        </div>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-1 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Fast
                        </div>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-1 text-purple-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12.316 3.051a1 1 0 01.633 1.265l-4 12a1 1 0 11-1.898-.632l4-12a1 1 0 011.265-.633zM5.707 6.293a1 1 0 010 1.414L3.414 10l2.293 2.293a1 1 0 11-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0zm8.586 0a1 1 0 011.414 0l3 3a1 1 0 010 1.414l-3 3a1 1 0 11-1.414-1.414L16.586 10l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                            Professional
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Conversion Categories -->
    @php
        // Categories that show an in-feed ad as the last card of their grid.
        $feedAds = [
            'length-and-area-conversions' => 'index-length-and-area-grid',
            'geographic-and-mapping-tools' => 'index-geographic-and-mapping-grid',
            'data-and-technical-conversion-tools' => 'index-data-and-technical-grid',
            'speed-and-motion-conversion-tools' => 'index-speed-and-motion-grid',
            'digital-and-technical-conversion-tools' => 'index-digital-and-technical-grid',
        ];
    @endphp
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @foreach($categories as $category)
                <div id="{{ $category['slug'] }}" class="mb-16 scroll-mt-24">
                    <div class="text-center mb-12">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">{{ $category['title'] }}</h2>
                        <p class="text-gray-600 max-w-2xl mx-auto">{{ $category['description'] }}</p>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @foreach($category['tools'] as $tool)
                            <a href="{{ route($tool['route_name']) }}" class="{{ $tool['card_class'] }}">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="{{ $tool['icon_wrapper_class'] }}">
                                        {!! $tool['icon_svg'] !!}
                                    </div>
                                    @if(! empty($tool['badge']['label']))
                                        <span class="{{ $tool['badge']['class'] }}">{{ $tool['badge']['label'] }}</span>
                                    @endif
                                </div>
                                <h3 class="font-semibold text-gray-900 mb-2">{{ $tool['title'] }}</h3>
                                <p class="text-sm text-gray-600">{{ $tool['description'] }}</p>
                            </a>
                        @endforeach

                        @isset($feedAds[$category['slug']])
                            <x-ads type="feed" :placement="$feedAds[$category['slug']]" />
                        @endisset
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Statistics Section -->
    <section class="bg-gray-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Trusted by Professionals</h2>
                <p class="text-gray-600">Precision tools for engineers, scientists, and technical professionals worldwide</p>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="text-3xl font-bold text-primary-600 mb-2">40+</div>
                    <div class="text-sm text-gray-600">Conversion Tools</div>
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
                    <div class="text-sm text-gray-600">No Cost</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Why Choose SolveKit?</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Professional-grade conversion tools designed for accuracy and reliability</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 rounded-full mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Precision Accuracy</h3>
                    <p class="text-gray-600">Industry-standard conversion factors ensure precise results for all calculations</p>
                </div>
                <div class="text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mb-4">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Lightning Fast</h3>
                    <p class="text-gray-600">Instant calculations with real-time conversion as you type</p>
                </div>
                <div class="text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-purple-100 rounded-full mb-4">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Mobile Friendly</h3>
                    <p class="text-gray-600">Responsive design works perfectly on all devices and screen sizes</p>
                </div>
            </div>
        </div>
    </section>

    <x-ads type="multiplex" placement="index-bottom" class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8" />
</x-app-layout>
