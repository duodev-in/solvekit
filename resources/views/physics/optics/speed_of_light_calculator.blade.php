<x-calc.page
    title="Speed of Light Calculator - SolveKit"
    description="Free speed of light calculator: light travel time for any distance, or distance for a time, in vacuum or a medium."
    lede="Find how long light takes."
    about="Light travels 299,792,458 m/s in vacuum (exact by definition) and c ÷ n in a material. Moonlight is 1.28 s old; sunlight about 8 min 20 s."
    :calc="['engine' => 'ph-wave', 'tool' => 'speed_light', 'fields' => ['mode', 'd', 't', 'm', 'mn'], 'unitFields' => ['d' => collect(config('units.astronomical'))->only(['m', 'km', 'au', 'ly', 'pc', 'mpc', 'mi'])->all(), 't' => collect(config('units.time'))->only(['s', 'ms', 'us', 'min', 'h', 'day', 'year'])->all()], 'data' => ['units' => collect(config('units'))->only(['astronomical', 'energy', 'force', 'length', 'mass', 'speed', 'time'])->all(), 'physics' => collect(config('physics_data'))->only(['refractive'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'How long does light take from the Moon?', 'answer' => '1.28222 s.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mode" label="Find" :options="['t' => 'Travel time for a distance', 'd' => 'Distance for a time']" selected="t" />
        <div data-show-when="mode:t">
            <x-calc.field name="d" label="Distance" value="384400" min="0" placeholder="Distance">
                <label for="calc-d-unit" class="sr-only">Distance unit</label>
                <select id="calc-d-unit" name="d-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.astronomical'))->only(['m', 'km', 'au', 'ly', 'pc', 'mpc', 'mi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'km')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:d">
            <x-calc.field name="t" label="Time" value="1" placeholder="Time">
                <label for="calc-t-unit" class="sr-only">Time unit</label>
                <select id="calc-t-unit" name="t-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.time'))->only(['s', 'ms', 'us', 'min', 'h', 'day', 'year']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 's')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.select name="m" label="Medium" :options="['vacuum' => 'Vacuum', 'air' => 'Air (15 °C, 1 atm)', 'water' => 'Water', 'ice' => 'Ice', 'ethanol' => 'Ethanol', 'glycerol' => 'Glycerol', 'silica' => 'Fused silica (quartz glass)', 'acrylic' => 'Acrylic (PMMA)', 'bk7' => 'Crown glass (N-BK7)', 'polycarbonate' => 'Polycarbonate', 'flint' => 'Dense flint glass (SF2)', 'sapphire' => 'Sapphire', 'zirconia' => 'Cubic zirconia', 'diamond' => 'Diamond', 'custom' => 'Other (enter the value)']" selected="vacuum" />
        <div data-show-when="m:custom">
            <x-calc.field name="mn" label="Medium: refractive index" value="1.5" min="1" step="any" />
        </div>
    </div>

    <x-calc.result label="Travel time" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 't', 'd' => 384400, 'd-unit' => 'km', 't' => 1, 't-unit' => 's', 'm' => 'vacuum', 'mn' => 1.5],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'v' => ['label' => 'Speed of light in this medium'],
            'vac' => ['label' => 'In vacuum'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
