<x-calc.page
    title="Running Split Calculator - SolveKit"
    description="Free running split calculator: even or negative split times for a goal."
    lede="Plan your race splits."
    about="Even splits keep the same pace; a negative split runs the second half faster, which many runners find easier to pace."
    :calc="['engine' => 'sp-run', 'tool' => 'running_split', 'fields' => ['race', 'dist', 't', 'split', 'neg'], 'unitFields' => ['dist' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'split' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What pace runs 10 km in 50:00?', 'answer' => '10:00 /km.'],
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
        <x-calc.field name="t" label="Goal time (h:mm:ss)" value="50:00" type="text" inputmode="text" />
        <x-calc.field name="split" label="Split every" value="1" placeholder="Split every">
            <label for="calc-split-unit" class="sr-only">Split every unit</label>
            <select id="calc-split-unit" name="split-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'km')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="neg" label="Negative split: second half faster by (%)" value="0" min="0" step="any" />
    </div>

    <x-calc.result label="Average pace" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['race' => '5k', 'dist' => 7, 'dist-unit' => 'km', 't' => '50:00', 'split' => 1, 'split-unit' => 'km', 'neg' => 0],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'halves' => ['label' => 'First and second half'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Split times" name="splits" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
