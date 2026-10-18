<x-calc.page
    title="Rebar Calculator - SolveKit"
    description="Free rebar calculator: number of bars, total length, stock bars and weight for a slab rebar grid, with US (#3–#18) or metric bars and lap splices."
    lede="Work out the rebar for a slab: bars each way, total length, stock bars and weight."
    about="Bars run both ways inside the edge cover at the spacing you set. Runs longer than a stock bar are spliced with a lap, given in bar diameters (use the lap on your drawings; ACI 318 sets it from the bar size, concrete strength and grade). Bar weights are ASTM A615/A706 (US) and EN 10080 (metric)."
    :calc="['engine' => 'con-weight', 'tool' => 'rebar', 'fields' => ['length', 'width', 'spacing', 'spacing_other', 'cover', 'stock', 'system', 'us_bar', 'metric_bar', 'lap'], 'unitFields' => ['length' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'width' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'spacing' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'spacing_other' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'cover' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'stock' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all()], 'data' => ['rebar' => config('construction_data.rebar')]]"
    :how-to="[
        ['name' => 'Enter the slab size', 'text' => 'And the bar spacing.'],
        ['name' => 'Enter cover and stock length', 'text' => 'Bars stop short of the edge by the cover.'],
        ['name' => 'Choose the bar size', 'text' => 'And the lap length from your drawings.'],
    ]"
    :faqs="[
        ['question' => 'How much rebar for a 20 × 30 ft slab?', 'answer' => 'At 12 in each way with 3 in cover: 20 bars of 29.5 ft and 30 bars of 19.5 ft, about 1,208 ft of #4 including laps.'],
        ['question' => 'How much does #4 rebar weigh?', 'answer' => '0.668 lb per foot.'],
        ['question' => 'What is edge cover?', 'answer' => 'The concrete between the bars and the edge; 3 in against soil is the ACI 318 minimum for cast-against-earth concrete.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="length" label="Slab length" value="30" min="0" placeholder="Slab length">
            <label for="calc-length-unit" class="sr-only">Slab length unit</label>
            <select id="calc-length-unit" name="length-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="width" label="Slab width" value="20" min="0" placeholder="Slab width">
            <label for="calc-width-unit" class="sr-only">Slab width unit</label>
            <select id="calc-width-unit" name="width-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="spacing" label="Spacing" value="12" min="0" placeholder="Spacing">
            <label for="calc-spacing-unit" class="sr-only">Spacing unit</label>
            <select id="calc-spacing-unit" name="spacing-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="spacing_other" label="Spacing the other way (optional)" value="" min="0" placeholder="Spacing the other way (optional)">
            <label for="calc-spacing_other-unit" class="sr-only">Spacing the other way (optional) unit</label>
            <select id="calc-spacing_other-unit" name="spacing_other-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="cover" label="Edge cover" value="3" min="0" placeholder="Edge cover">
            <label for="calc-cover-unit" class="sr-only">Edge cover unit</label>
            <select id="calc-cover-unit" name="cover-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="stock" label="Stock bar length" value="20" min="0" placeholder="Stock bar length">
            <label for="calc-stock-unit" class="sr-only">Stock bar length unit</label>
            <select id="calc-stock-unit" name="stock-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.segmented name="system" legend="Bars" :options="['us' => 'US (#)', 'metric' => 'Metric (mm)']" selected="us" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="system:us">
            <x-calc.select name="us_bar" label="Bar size" :options="collect(config('construction_data.rebar.us'))->mapWithKeys(fn ($b, $k) => [$k => $k.' ('.$b['diameter'].' in)'])->all()" selected="#4" />
        </div>
        <div data-show-when="system:metric" hidden>
            <x-calc.select name="metric_bar" label="Bar size" :options="collect(config('construction_data.rebar.metric'))->mapWithKeys(fn ($b, $k) => [$k => $k])->all()" selected="12 mm" />
        </div>
        <x-calc.field name="lap" label="Lap splice (bar diameters)" value="40" min="0" step="1" />
    </div>

    <x-calc.result label="Rebar needed" />

    <x-calc.options :examples="[
        'Slab 30 × 20 ft, #4 at 12 in' => ['length' => 30, 'length-unit' => 'ft', 'width' => 20, 'width-unit' => 'ft', 'spacing' => 12, 'spacing-unit' => 'in', 'cover' => 3, 'cover-unit' => 'in', 'stock' => 20, 'stock-unit' => 'ft', 'system' => 'us', 'us_bar' => '#4', 'lap' => 40],
        'Metric 8 × 6 m, 12 mm at 200' => ['length' => 8, 'length-unit' => 'm', 'width' => 6, 'width-unit' => 'm', 'spacing' => 200, 'spacing-unit' => 'mm', 'cover' => 75, 'cover-unit' => 'mm', 'stock' => 12, 'stock-unit' => 'm', 'system' => 'metric', 'metric_bar' => '12 mm', 'lap' => 40],
        'Patio 12 × 12 ft, #3 at 18 in' => ['length' => 12, 'length-unit' => 'ft', 'width' => 12, 'width-unit' => 'ft', 'spacing' => 18, 'spacing-unit' => 'in', 'cover' => 2, 'cover-unit' => 'in', 'stock' => 20, 'stock-unit' => 'ft', 'system' => 'us', 'us_bar' => '#3', 'lap' => 40],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'stock' => ['label' => 'Stock bars'],
            'weight' => ['label' => 'Weight'],
            'meters' => ['label' => 'Meters'],
            'laps' => ['label' => 'Lap splices'],
            'bars' => ['label' => 'Bar runs'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>bars = ⌊(width − 2 × cover) ÷ spacing⌋ + 1</li>
            <li>pieces per run = ⌈(run − lap) ÷ (stock − lap)⌉</li>
            <li>lap = bar diameters × d</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
