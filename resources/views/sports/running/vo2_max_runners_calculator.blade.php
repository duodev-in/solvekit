<x-calc.page
    title="VO2 Max Runners Calculator - SolveKit"
    description="Free running VO₂max calculator: VDOT from a race time, with equivalent times."
    lede="Estimate VO₂max from a race."
    about="Daniels and Gilbert’s equations estimate an effective VO₂max (VDOT) from any race time."
    :calc="['engine' => 'sp-run', 'tool' => 'vo2_runners', 'fields' => ['race', 'dist', 't'], 'unitFields' => ['dist' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What VDOT does a 25:00 5K give?', 'answer' => '38.3 ml/kg/min.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="race" label="Race distance" :options="['1500' => '1500 m', 'mile' => '1 mile', '3k' => '3 km', '5k' => '5 km', '8k' => '8 km', '10k' => '10 km', '15k' => '15 km', '10mi' => '10 miles', 'half' => 'Half marathon', 'marathon' => 'Marathon', 'custom' => 'Other distance']" selected="5k" />
        <div data-show-when="race:custom">
            <x-calc.field name="dist" label="Distance" value="7" placeholder="Distance">
                <label for="calc-dist-unit" class="sr-only">Distance unit</label>
                <select id="calc-dist-unit" name="dist-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'km')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.field name="t" label="Race time (h:mm:ss)" value="25:00" type="text" inputmode="text" />
    </div>

    <x-calc.result label="VDOT (effective VO₂max)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['race' => '5k', 'dist' => 7, 'dist-unit' => 'km', 't' => '25:00'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'note' => ['label' => 'Meaning'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Equivalent race times" name="equiv" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
