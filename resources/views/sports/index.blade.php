<x-app-layout
    title="Sports Calculators - SolveKit"
    description="Free sports calculators: baseball, basketball and cricket stats, calories burned, heart rate zones, running pace and race prediction, cycling gears and power, triathlon, swimming and boating, weightlifting, golf, bowling and more, with the working shown.">

    <section class="bg-gradient-to-br from-primary-50 to-white py-16">
        <div class="mx-auto max-w-7xl px-4 text-center sm:px-6 lg:px-8">
            <h1 class="mb-4 text-4xl font-bold text-gray-900">Sports Calculators</h1>
            <p class="mx-auto max-w-3xl text-xl text-gray-600">Stats for baseball, basketball and cricket, calories and heart rate, running and cycling, swimming and boating, strength and scoring. Official statistics follow each sport's own definitions, training numbers use named published formulas, and every tool shows its working.</p>
        </div>
    </section>

    <section class="bg-white py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @foreach($categories as $category)
                @continue(empty($category['tools']))
                <div id="{{ $category['slug'] }}" class="mb-16 scroll-mt-24">
                    <div class="mb-12 text-center">
                        <h2 class="mb-4 text-2xl font-bold text-gray-900">{{ $category['title'] }}</h2>
                        <p class="mx-auto max-w-2xl text-gray-600">{{ $category['description'] }}</p>
                    </div>
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                        @foreach($category['tools'] as $tool)
                            <a href="{{ route($tool['route_name']) }}" class="group flex flex-col rounded-xl border border-gray-200 bg-white p-6 transition-all duration-200 hover:border-primary-500 hover:shadow-lg">
                                <h3 class="mb-2 font-semibold text-gray-900 group-hover:text-primary-700">{{ $tool['title'] }}</h3>
                                <p class="text-sm text-gray-600">{{ $tool['description'] }}</p>
                            </a>
                        @endforeach
                        @foreach($category['elsewhere'] ?? [] as $link)
                            @continue(! Route::has($link['route']))
                            <a href="{{ route($link['route']) }}" class="group flex flex-col rounded-xl border border-dashed border-gray-300 bg-white p-6 transition-all duration-200 hover:border-primary-500 hover:shadow-lg">
                                <h3 class="mb-2 font-semibold text-gray-900 group-hover:text-primary-700">{{ $link['title'] }}</h3>
                                <p class="text-sm text-gray-600">{{ $link['description'] }}</p>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <x-ads type="multiplex" placement="sports-index-bottom" class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8" />
</x-app-layout>
