<x-app-layout
    title="Finance Calculators - SolveKit"
    description="Finance calculators for loans and mortgages, savings and investing, retirement, US, UK and Indian tax and pay, business planning, sales and economics, each with its formula and dated sources.">

    <section class="bg-gradient-to-br from-primary-50 to-white py-16">
        <div class="mx-auto max-w-7xl px-4 text-center sm:px-6 lg:px-8">
            <h1 class="mb-4 text-4xl font-bold text-gray-900">Finance Calculators</h1>
            <p class="mx-auto max-w-3xl text-xl text-gray-600">Calculators for loans and mortgages, savings and investing, retirement, tax and pay, business planning, sales and economics, each showing its formula and the dated official tables it uses.</p>
            <p class="mx-auto mt-3 max-w-3xl text-sm text-gray-500">Estimates for planning, not financial, tax or legal advice.</p>
            <nav aria-label="Finance categories" class="mx-auto mt-8 flex max-w-5xl flex-wrap justify-center gap-2">
                @foreach($categories as $category)
                    @continue(empty($category['tools']))
                    <a href="#{{ $category['slug'] }}" class="rounded-sm border border-gray-200 bg-white px-3 py-1.5 text-sm text-gray-700 hover:border-primary-500 hover:text-primary-700">{{ $category['title'] }}</a>
                @endforeach
            </nav>
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

    <x-ads type="multiplex" placement="finance-index-bottom" class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8" />
</x-app-layout>
