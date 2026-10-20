<x-calc.page
    title="Hiking Time Calculator - SolveKit"
    description="Free hiking time calculator: walking time from distance and climb by Naismith’s rule and Tobler’s function."
    lede="Estimate hiking time."
    about="Naismith’s rule allows an hour per 5 km plus an hour per 600 m of ascent; Tobler’s hiking function gives a slope-based alternative."
    :calc="['engine' => 'sp-fit', 'tool' => 'hiking_time', 'fields' => ['d', 'up', 'down', 'speed', 'fit'], 'unitFields' => ['d' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'up' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'down' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'speed' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all()], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'How long is 15 km with 800 m up?', 'answer' => 'About 4:28:20.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="d" label="Distance" value="15" placeholder="Distance">
            <label for="calc-d-unit" class="sr-only">Distance unit</label>
            <select id="calc-d-unit" name="d-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'km')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="up" label="Ascent" value="800" placeholder="Ascent">
            <label for="calc-up-unit" class="sr-only">Ascent unit</label>
            <select id="calc-up-unit" name="up-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="down" label="Descent" value="800" placeholder="Descent">
            <label for="calc-down-unit" class="sr-only">Descent unit</label>
            <select id="calc-down-unit" name="down-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="speed" label="Flat walking speed" value="5" placeholder="Flat walking speed">
            <label for="calc-speed-unit" class="sr-only">Flat walking speed unit</label>
            <select id="calc-speed-unit" name="speed-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kmh')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="fit" label="Fitness and pack" :options="['1' => 'Fit, light pack', '1.15' => 'Average, day pack', '1.35' => 'Heavy pack or slow group']" selected="1.15" />
    </div>

    <x-calc.result label="Walking time (Naismith)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['d' => 15, 'd-unit' => 'km', 'up' => 800, 'up-unit' => 'm', 'down' => 800, 'down-unit' => 'm', 'speed' => 5, 'speed-unit' => 'kmh', 'fit' => '1.15'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'tobler' => ['label' => 'Tobler’s hiking function (average-slope estimate)'],
            'breaks' => ['label' => 'With 10 minutes of rest per hour'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
