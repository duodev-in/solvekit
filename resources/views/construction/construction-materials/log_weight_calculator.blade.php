<x-calc.page
    title="Log Weight Calculator - SolveKit"
    description="Free log weight calculator: green or dry weight of a log by species from its end diameters and length, using USDA Wood Handbook specific gravity and moisture data."
    lede="Work out the weight of a log by species, green or dry."
    about="Volume is by Smalian's formula (the average of the two end areas × length), with diameters inside the bark. Density = specific gravity × 1000 × (1 + moisture ÷ 100), with specific gravity and average green moisture for each species from the USDA Forest Products Laboratory Wood Handbook (2021). Green moisture varies a lot between trees; enter a measured value if you have one."
    :calc="['engine' => 'con-weight', 'tool' => 'log_weight', 'fields' => ['small', 'large', 'length', 'species', 'count', 'condition', 'moisture'], 'unitFields' => ['small' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'large' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'length' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all()], 'data' => ['wood' => config('construction_data.wood')]]"
    :how-to="[
        ['name' => 'Measure both ends', 'text' => 'Inside the bark, and the length.'],
        ['name' => 'Choose the species', 'text' => 'And whether it is green or dry.'],
    ]"
    :faqs="[
        ['question' => 'How much does a green oak log weigh?', 'answer' => 'A 16 ft white oak log 12–14 in across weighs about 950 lb green.'],
        ['question' => 'Why is green wood so heavy?', 'answer' => 'Fresh wood can hold its own weight in water or more; cottonwood averages over 150% moisture.'],
        ['question' => 'What moisture is air-dry wood?', 'answer' => 'About 12–15% indoors in most of the US.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="small" label="Small-end diameter" value="12" min="0" placeholder="Small-end diameter">
            <label for="calc-small-unit" class="sr-only">Small-end diameter unit</label>
            <select id="calc-small-unit" name="small-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="large" label="Large-end diameter" value="14" min="0" placeholder="Large-end diameter">
            <label for="calc-large-unit" class="sr-only">Large-end diameter unit</label>
            <select id="calc-large-unit" name="large-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="length" label="Length" value="16" min="0" placeholder="Length">
            <label for="calc-length-unit" class="sr-only">Length unit</label>
            <select id="calc-length-unit" name="length-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="species" label="Species" :options="collect(config('construction_data.wood'))->map(fn ($w) => $w['name'])->all()" selected="white_oak" />
        <x-calc.field name="count" label="Logs" value="1" min="1" step="1" />
    </div>

    <x-calc.segmented name="condition" legend="Condition" :options="['green' => 'Green (fresh cut)', 'dry' => 'Air-dry (12%)', 'custom' => 'Moisture I enter']" selected="green" />

    <div data-show-when="condition:green,custom" hidden>
        <x-calc.field name="moisture" label="Moisture content (optional for green)" value="" min="0" max="300" suffix="%" placeholder="Species average" />
    </div>

    <x-calc.result label="Log weight" />

    <x-calc.options :examples="[
        'White oak 16 ft' => ['small' => 12, 'small-unit' => 'in', 'large' => 14, 'large-unit' => 'in', 'length' => 16, 'length-unit' => 'ft', 'species' => 'white_oak', 'count' => 1, 'condition' => 'green'],
        'Douglas-fir, dry' => ['small' => 30, 'small-unit' => 'cm', 'large' => 35, 'large-unit' => 'cm', 'length' => 5, 'length-unit' => 'm', 'species' => 'douglas_fir', 'count' => 1, 'condition' => 'dry'],
        'Pine at 60% moisture' => ['small' => 10, 'small-unit' => 'in', 'large' => 11, 'large-unit' => 'in', 'length' => 12, 'length-unit' => 'ft', 'species' => 'southern_pine_loblolly', 'count' => 3, 'condition' => 'custom', 'moisture' => 60],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'kg' => ['label' => 'Kilograms'],
            'volume' => ['label' => 'Volume'],
            'density' => ['label' => 'Density'],
            'board_feet' => ['label' => 'Log scale'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>V = L × (A_small + A_large) ÷ 2</li>
            <li>ρ = G × 1000 × (1 + MC ÷ 100) kg/m³</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
