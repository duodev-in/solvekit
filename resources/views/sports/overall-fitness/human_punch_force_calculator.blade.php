<x-calc.page
    title="Human Punch Force Calculator - SolveKit"
    description="Free punch force calculator: estimated punch force from effective mass, fist speed and contact time."
    lede="Estimate punch force."
    about="A punch delivers momentum over a few milliseconds. Olympic boxers average about 3,400 N."
    :calc="['engine' => 'sp-fit', 'tool' => 'punch_force', 'fields' => ['m', 'v', 't', 'out'], 'unitFields' => ['m' => collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us'])->all(), 'v' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all(), 't' => collect(config('units.short_time'))->only(['s', 'ms', 'us', 'ns', 'ps', 'min', 'h'])->all()], 'data' => ['units' => collect(config('units'))->only(['force', 'length', 'mass', 'short_time', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What force do 2.9 kg at 9 m/s over 8 ms give?', 'answer' => '3,262.5 N.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="m" label="Effective mass behind the punch" value="2.9" min="0" placeholder="Effective mass behind the punch">
            <label for="calc-m-unit" class="sr-only">Effective mass behind the punch unit</label>
            <select id="calc-m-unit" name="m-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="v" label="Fist speed at impact" value="9" placeholder="Fist speed at impact">
            <label for="calc-v-unit" class="sr-only">Fist speed at impact unit</label>
            <select id="calc-v-unit" name="v-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ms')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="t" label="Contact time" value="8" min="0" placeholder="Contact time">
            <label for="calc-t-unit" class="sr-only">Contact time unit</label>
            <select id="calc-t-unit" name="t-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.short_time'))->only(['s', 'ms', 'us', 'ns', 'ps', 'min', 'h']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ms')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['n' => 'N', 'kn' => 'kN', 'millinewton' => 'mN', 'meganewton' => 'MN', 'lbf' => 'lbf', 'kgf' => 'kgf', 'dyn' => 'dyn', 'kip' => 'kip']" selected="n" />
    </div>

    <x-calc.result label="Average punch force" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'n', 'm' => 2.9, 'm-unit' => 'kg', 'v' => 9, 'v-unit' => 'ms', 't' => 8, 't-unit' => 'ms'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'kgf' => ['label' => 'As a weight'],
            'E' => ['label' => 'Kinetic energy of the fist'],
            'compare' => ['label' => 'For comparison'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
