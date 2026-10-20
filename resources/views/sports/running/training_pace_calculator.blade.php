<x-calc.page
    title="Training Pace Calculator - SolveKit"
    description="Free training pace calculator: easy, marathon, threshold, interval and repetition paces from a race (VDOT)."
    lede="Find your training paces."
    about="Jack Daniels’ VDOT turns a race result into paces for each type of run."
    :calc="['engine' => 'sp-run', 'tool' => 'training_pace', 'fields' => ['race', 'dist', 't'], 'unitFields' => ['dist' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What threshold pace suits a 25:00 5K?', 'answer' => '5:16 /km (8:29 /mi).'],
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
        <x-calc.field name="t" label="Recent race time (h:mm:ss)" value="25:00" type="text" inputmode="text" />
    </div>

    <x-calc.result label="VDOT" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['race' => '5k', 'dist' => 7, 'dist-unit' => 'km', 't' => '25:00'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'E' => ['label' => 'Easy (E)'],
            'M' => ['label' => 'Marathon (M)'],
            'T' => ['label' => 'Threshold (T)'],
            'I' => ['label' => 'Interval (I)'],
            'R' => ['label' => 'Repetition (R)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
