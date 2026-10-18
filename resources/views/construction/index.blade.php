<x-app-layout
    title="Construction Calculators - SolveKit"
    description="Construction calculators for concrete, gravel, lumber, roofing, stairs, tanks, fasteners and wiring, each with the formula, code section or data source it uses.">

    <section class="bg-gradient-to-br from-primary-50 to-white py-16">
        <div class="mx-auto max-w-7xl px-4 text-center sm:px-6 lg:px-8">
            <h1 class="mb-4 text-4xl font-bold text-gray-900">Construction Calculators</h1>
            <p class="mx-auto max-w-3xl text-xl text-gray-600">Concrete, aggregates, lumber, roofing, stairs, tanks, fasteners and electrical calculators, each with the formula, code section or data source it uses.</p>
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
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <x-ads type="multiplex" placement="construction-index-bottom" class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8" />
</x-app-layout>
