<x-calc.page
    title="Thrust to Weight Ratio Calculator - SolveKit"
    description="Free thrust-to-weight ratio calculator: TWR and lift-off acceleration of a rocket on Earth, the Moon or Mars."
    lede="Find thrust-to-weight ratio."
    about="A rocket lifts off only if its thrust exceeds its weight. Launchers start around TWR 1.2–1.5; the extra becomes upward acceleration."
    :calc="['engine' => 'ph-astro', 'tool' => 'twr', 'fields' => ['F', 'm', 'body', 'g'], 'unitFields' => ['F' => collect(config('units.force'))->only(['n', 'kn', 'millinewton', 'meganewton', 'lbf', 'kgf', 'dyn', 'kip'])->all(), 'm' => collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us'])->all(), 'g' => collect(config('units.acceleration'))->only(['ms2', 'cms2', 'fts2', 'ins2', 'kmhs', 'mphs', 'g0'])->all()], 'data' => ['units' => collect(config('units'))->only(['acceleration', 'energy', 'force', 'length', 'mass', 'speed'])->all(), 'physics' => collect(config('physics_data'))->only(['bodies'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the TWR of the example rocket?', 'answer' => '1.413.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="F" label="Thrust" value="7607" placeholder="Thrust">
            <label for="calc-F-unit" class="sr-only">Thrust unit</label>
            <select id="calc-F-unit" name="F-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.force'))->only(['n', 'kn', 'millinewton', 'meganewton', 'lbf', 'kgf', 'dyn', 'kip']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kn')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="m" label="Mass" value="549" min="0" placeholder="Mass">
            <label for="calc-m-unit" class="sr-only">Mass unit</label>
            <select id="calc-m-unit" name="m-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 't')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="body" label="Gravity of" :options="['earth' => 'Earth (9.80665 m/s²)', 'moon' => 'Moon', 'mars' => 'Mars', 'custom' => 'Custom']" selected="earth" />
        <div data-show-when="body:custom">
            <x-calc.field name="g" label="Gravity" value="9.80665" placeholder="Gravity">
                <label for="calc-g-unit" class="sr-only">Gravity unit</label>
                <select id="calc-g-unit" name="g-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.acceleration'))->only(['ms2', 'cms2', 'fts2', 'ins2', 'kmhs', 'mphs', 'g0']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ms2')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <x-calc.result label="Thrust-to-weight ratio" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['F' => 7607, 'F-unit' => 'kn', 'm' => 549, 'm-unit' => 't', 'body' => 'earth', 'g' => 9.80665, 'g-unit' => 'ms2'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'a' => ['label' => 'Initial upward acceleration'],
            'lift' => ['label' => 'Lifts off?'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
