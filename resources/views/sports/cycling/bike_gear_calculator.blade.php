<x-calc.page
    title="Bike Gear Calculator - SolveKit"
    description="Free bike gear calculator: gear inches, development and gain ratio for every chainring and cog."
    lede="Compare bike gears."
    about="Gear inches, development and gain ratio all describe how far one pedal turn moves the bike. The table shows every combination."
    :calc="['engine' => 'sp-cycle', 'tool' => 'bike_gear', 'fields' => ['rings', 'cogs', 'wheel', 'circ', 'crank', 'measure'], 'unitFields' => ['circ' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'crank' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all(), 'sports' => collect(config('sports_data'))->only(['wheels'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What range does 50/34 with 11–28 give?', 'answer' => '32–120 gear inches.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="rings" label="Chainrings (teeth, comma separated)" value="50, 34" type="text" inputmode="text" />
        <x-calc.field name="cogs" label="Cassette (teeth, comma separated)" value="11, 12, 13, 14, 15, 17, 19, 21, 24, 28" type="text" inputmode="text" />
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
        <x-calc.field name="crank" label="Crank length" value="172.5" placeholder="Crank length">
            <label for="calc-crank-unit" class="sr-only">Crank length unit</label>
            <select id="calc-crank-unit" name="crank-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="measure" label="Show" :options="['inches' => 'Gear inches', 'dev' => 'Development (m)', 'gain' => 'Gain ratio']" selected="inches" />
    </div>

    <x-calc.result label="Gear range" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['rings' => '50, 34', 'cogs' => '11, 12, 13, 14, 15, 17, 19, 21, 24, 28', 'wheel' => '700x25', 'circ' => 2105, 'circ-unit' => 'mm', 'crank' => 172.5, 'crank-unit' => 'mm', 'measure' => 'inches'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'low' => ['label' => 'Lowest gear'],
            'high' => ['label' => 'Highest gear'],
            'range' => ['label' => 'Range'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Every combination" name="gears" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
