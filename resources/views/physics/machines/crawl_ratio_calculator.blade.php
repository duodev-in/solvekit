<x-calc.page
    title="Crawl Ratio Calculator - SolveKit"
    description="Free crawl ratio calculator: overall off-road gearing and crawl speed from first gear, transfer case and axle ratios."
    lede="Find a 4×4’s crawl ratio."
    about="Crawl ratio is the product of first gear, low range and axle ratio. Higher numbers give slower, more controlled crawling."
    :calc="['engine' => 'ph-mach', 'tool' => 'crawl_ratio', 'fields' => ['first', 'low', 'axle', 'rpm', 'tyre'], 'unitFields' => ['tyre' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the crawl ratio of the example?', 'answer' => '52.53 : 1.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="first" label="First gear ratio" value="4.71" min="0" step="any" />
        <x-calc.field name="low" label="Transfer case low range" value="2.72" min="0" step="any" />
        <x-calc.field name="axle" label="Axle ratio" value="4.1" min="0" step="any" />
        <x-calc.field name="rpm" label="Engine idle speed (rpm, optional)" value="800" min="0" step="any" />
        <x-calc.field name="tyre" label="Tyre diameter (optional)" value="33" placeholder="Tyre diameter (optional)">
            <label for="calc-tyre-unit" class="sr-only">Tyre diameter (optional) unit</label>
            <select id="calc-tyre-unit" name="tyre-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Crawl ratio" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['first' => 4.71, 'low' => 2.72, 'axle' => 4.1, 'rpm' => 800, 'tyre' => 33, 'tyre-unit' => 'in'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'speed' => ['label' => 'Crawl speed at idle'],
            'torque' => ['label' => 'Torque multiplication'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
