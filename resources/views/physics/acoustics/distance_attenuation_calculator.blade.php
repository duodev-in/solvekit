<x-calc.page
    title="Distance Attenuation Calculator - SolveKit"
    description="Free sound distance attenuation calculator: sound level at a new distance for point and line sources."
    lede="Find how sound fades with distance."
    about="Sound from a point source spreads over a sphere, so the level drops 6 dB each time the distance doubles. A long line source like a road spreads over a cylinder and drops only 3 dB per doubling."
    :calc="['engine' => 'ph-wave', 'tool' => 'distance_attenuation', 'fields' => ['L1', 'r1', 'r2', 'src'], 'unitFields' => ['r1' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'r2' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is 90 dB at 1 m when you are 10 m away?', 'answer' => '70 dB.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="L1" label="Sound level at the first distance (dB)" value="90" step="any" />
        <x-calc.field name="r1" label="First distance" value="1" placeholder="First distance">
            <label for="calc-r1-unit" class="sr-only">First distance unit</label>
            <select id="calc-r1-unit" name="r1-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="r2" label="Second distance" value="10" placeholder="Second distance">
            <label for="calc-r2-unit" class="sr-only">Second distance unit</label>
            <select id="calc-r2-unit" name="r2-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="src" label="Source" :options="['point' => 'Point source (spreads in all directions)', 'line' => 'Line source (busy road, pipe)']" selected="point" />
    </div>

    <x-calc.result label="Level at the second distance" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['L1' => 90, 'r1' => 1, 'r1-unit' => 'm', 'r2' => 10, 'r2-unit' => 'm', 'src' => 'point'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'change' => ['label' => 'Change'],
            'rule' => ['label' => 'Rule of thumb'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
