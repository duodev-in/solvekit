<x-calc.page
    title="Bike Cadence and Speed Calculator - SolveKit"
    description="Free bike cadence and speed calculator: speed from cadence and gearing, or cadence for a speed."
    lede="Convert cadence and speed."
    about="Speed is pedalling cadence times the distance the bike travels per pedal turn, set by the gear ratio and wheel size. Also known as Bike Cadence Calculator and Bike Speed Calculator."
    :calc="['engine' => 'sp-cycle', 'tool' => 'cadence_speed', 'fields' => ['by', 'ring', 'cog', 'wheel', 'circ', 'rpm', 'v'], 'unitFields' => ['circ' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'v' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all()], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all(), 'sports' => collect(config('sports_data'))->only(['wheels'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'How fast is 90 rpm in 50×17 on 700×25c?', 'answer' => '33.43 km/h.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="by" label="Find" :options="['speed' => 'Speed from cadence', 'cadence' => 'Cadence from speed']" selected="speed" />
        <x-calc.field name="ring" label="Chainring teeth" value="50" min="1" step="any" />
        <x-calc.field name="cog" label="Cog teeth" value="17" min="1" step="any" />
        <x-calc.select name="wheel" label="Wheel and tyre" :options="['700x23' => '700 × 23c', '700x25' => '700 × 25c', '700x28' => '700 × 28c', '700x32' => '700 × 32c', '700x38' => '700 × 38c', '26x1.95' => '26 × 1.95', '26x2.1' => '26 × 2.1', '27.5x2.1' => '27.5 × 2.1', '29x2.1' => '29 × 2.1', '29x2.3' => '29 × 2.3', '20x1.75' => '20 × 1.75', 'custom' => 'Other (enter the value)']" selected="700x25" />
        <div data-show-when="wheel:custom">
            <x-calc.field name="circ" label="Rolling circumference" value="2105" placeholder="Rolling circumference">
                <label for="calc-circ-unit" class="sr-only">Rolling circumference unit</label>
                <select id="calc-circ-unit" name="circ-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="by:speed">
            <x-calc.field name="rpm" label="Cadence (rpm)" value="90" min="1" step="any" />
        </div>
        <div data-show-when="by:cadence">
            <x-calc.field name="v" label="Speed" value="30" placeholder="Speed">
                <label for="calc-v-unit" class="sr-only">Speed unit</label>
                <select id="calc-v-unit" name="v-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kmh')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <x-calc.result label="Speed" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['by' => 'speed', 'ring' => 50, 'cog' => 17, 'wheel' => '700x25', 'circ' => 2105, 'circ-unit' => 'mm', 'rpm' => 90, 'v' => 30, 'v-unit' => 'kmh'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'ratio' => ['label' => 'Gear ratio'],
            'dev' => ['label' => 'Development (metres per pedal turn)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Speed at each cadence" name="table" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
