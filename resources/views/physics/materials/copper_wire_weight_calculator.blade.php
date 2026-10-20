<x-calc.page
    title="Copper Wire Weight Calculator - SolveKit"
    description="Free copper wire weight calculator: weight, cross-section and resistance of copper wire by AWG gauge, diameter or area."
    lede="Find the weight of copper wire."
    about="Copper weight is density × cross-section × length. AWG sizes follow a fixed geometric rule: each gauge is 92^(1/39) thinner than the last, and 36 AWG is exactly 0.005 in."
    :calc="['engine' => 'ph-mat', 'tool' => 'copper_wire', 'fields' => ['mode', 'awg', 'd', 'area', 'L', 'cores', 'out'], 'unitFields' => ['d' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'area' => collect(config('units.area'))->only(['m2', 'cm2', 'mm2', 'km2', 'ha', 'ft2', 'in2', 'yd2', 'acre'])->all(), 'L' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['area', 'energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'How much does 100 m of 12 AWG copper weigh?', 'answer' => '2.96466 kg.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mode" label="Size given as" :options="['awg' => 'AWG gauge', 'dia' => 'Diameter', 'area' => 'Cross-section area']" selected="awg" />
        <div data-show-when="mode:awg">
            <x-calc.select name="awg" label="AWG" :options="['0' => '0 (1/0)', '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8', '9' => '9', '10' => '10', '11' => '11', '12' => '12', '13' => '13', '14' => '14', '15' => '15', '16' => '16', '17' => '17', '18' => '18', '19' => '19', '20' => '20', '21' => '21', '22' => '22', '23' => '23', '24' => '24', '25' => '25', '26' => '26', '27' => '27', '28' => '28', '29' => '29', '30' => '30', '31' => '31', '32' => '32', '33' => '33', '34' => '34', '35' => '35', '36' => '36', '37' => '37', '38' => '38', '39' => '39', '40' => '40', '-3' => '0000 (4/0)', '-2' => '000 (3/0)', '-1' => '00 (2/0)']" selected="12" />
        </div>
        <div data-show-when="mode:dia">
            <x-calc.field name="d" label="Diameter" value="2.05" placeholder="Diameter">
                <label for="calc-d-unit" class="sr-only">Diameter unit</label>
                <select id="calc-d-unit" name="d-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:area">
            <x-calc.field name="area" label="Area" value="2.5" min="0" placeholder="Area">
                <label for="calc-area-unit" class="sr-only">Area unit</label>
                <select id="calc-area-unit" name="area-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.area'))->only(['m2', 'cm2', 'mm2', 'km2', 'ha', 'ft2', 'in2', 'yd2', 'acre']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mm2')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.field name="L" label="Length" value="100" placeholder="Length">
            <label for="calc-L-unit" class="sr-only">Length unit</label>
            <select id="calc-L-unit" name="L-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="cores" label="Number of conductors" value="1" min="1" step="any" />
        <x-calc.select name="out" label="Show the result in" :options="['kg' => 'kg', 'g' => 'g', 'mg' => 'mg', 't' => 't', 'lb' => 'lb', 'oz' => 'oz', 'gr' => 'gr', 'ton_us' => 'US ton']" selected="kg" />
    </div>

    <x-calc.result label="Copper weight" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'kg', 'mode' => 'awg', 'awg' => '12', 'd' => 2.05, 'd-unit' => 'mm', 'area' => 2.5, 'area-unit' => 'mm2', 'L' => 100, 'L-unit' => 'm', 'cores' => 1],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'area' => ['label' => 'Copper cross-section'],
            'dia' => ['label' => 'Diameter'],
            'R' => ['label' => 'Resistance at 20 °C (per conductor)'],
            'perm' => ['label' => 'Weight per metre'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
