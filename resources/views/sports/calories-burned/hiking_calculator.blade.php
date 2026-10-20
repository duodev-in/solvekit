<x-calc.page
    title="Hiking Calculator - SolveKit"
    description="Free hiking calorie calculator: energy and time for a hike from distance, climb, pack weight and terrain."
    lede="Find calories burned hiking."
    about="The Pandolf equation, developed for soldiers carrying loads, estimates energy from body weight, pack, speed, gradient and terrain."
    :calc="['engine' => 'sp-fit', 'tool' => 'hiking', 'fields' => ['w', 'load', 'd', 'up', 'v', 'terrain'], 'unitFields' => ['w' => collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us'])->all(), 'load' => collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us'])->all(), 'd' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'up' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'v' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all()], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What does a 10 km hike with 500 m of climbing burn?', 'answer' => 'About 1,304 kcal kcal.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="w" label="Body weight" value="70" min="0" placeholder="Body weight">
            <label for="calc-w-unit" class="sr-only">Body weight unit</label>
            <select id="calc-w-unit" name="w-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="load" label="Pack weight" value="8" min="0" placeholder="Pack weight">
            <label for="calc-load-unit" class="sr-only">Pack weight unit</label>
            <select id="calc-load-unit" name="load-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="d" label="Distance" value="10" placeholder="Distance">
            <label for="calc-d-unit" class="sr-only">Distance unit</label>
            <select id="calc-d-unit" name="d-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'km')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="up" label="Total ascent" value="500" placeholder="Total ascent">
            <label for="calc-up-unit" class="sr-only">Total ascent unit</label>
            <select id="calc-up-unit" name="up-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="v" label="Walking speed on the flat" value="4.5" placeholder="Walking speed on the flat">
            <label for="calc-v-unit" class="sr-only">Walking speed on the flat unit</label>
            <select id="calc-v-unit" name="v-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kmh')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="terrain" label="Terrain" :options="['1' => 'Paved road or treadmill', '1.1' => 'Dirt road or good trail', '1.2' => 'Light brush', '1.5' => 'Heavy brush or rough trail', '1.8' => 'Swampy bog', '2.1' => 'Loose sand']" selected="1.1" />
    </div>

    <x-calc.result label="Calories burned" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['w' => 70, 'w-unit' => 'kg', 'load' => 8, 'load-unit' => 'kg', 'd' => 10, 'd-unit' => 'km', 'up' => 500, 'up-unit' => 'm', 'v' => 4.5, 'v-unit' => 'kmh', 'terrain' => '1.1'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'time' => ['label' => 'Hiking time (Naismith)'],
            'rate' => ['label' => 'Average energy rate'],
            'grade' => ['label' => 'Average grade uphill'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
