<x-calc.page
    title="Wire Resistance Calculator - SolveKit"
    description="Free wire resistance calculator: resistance of copper, aluminium and other wire from size, length and temperature."
    lede="Find wire resistance."
    about="Wire resistance is ρL/A, rising with temperature by the coefficient α. Remember the return conductor for a full circuit."
    :calc="['engine' => 'ph-elec', 'tool' => 'wire_resistance', 'fields' => ['mat', 'rho', 'alpha', 'size', 'awg', 'd', 'A', 'L', 'T', 'out'], 'unitFields' => ['rho' => collect(config('units.resistivity'))->only(['ohmm', 'ohmcm', 'uohmcm', 'nohmm', 'ohmmm2m'])->all(), 'd' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'A' => collect(config('units.area'))->only(['m2', 'cm2', 'mm2', 'km2', 'ha', 'ft2', 'in2', 'yd2', 'acre'])->all(), 'L' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'T' => collect(config('units.temperature'))->only(['c', 'f', 'k', 'r'])->all()], 'data' => ['units' => collect(config('units'))->only(['area', 'energy', 'force', 'length', 'mass', 'resistance', 'resistivity', 'speed', 'temperature'])->all(), 'physics' => collect(config('physics_data'))->only(['conductors'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the resistance of 50 m of 2.5 mm² copper?', 'answer' => '0.34482 Ω.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mat" label="Conductor" :options="['copper' => 'Copper (annealed)', 'aluminium' => 'Aluminium (EC grade)', 'silver' => 'Silver', 'gold' => 'Gold', 'tungsten' => 'Tungsten', 'brass' => 'Brass', 'iron' => 'Iron (pure)', 'steel' => 'Carbon steel', 'stainless' => 'Stainless steel 304', 'constantan' => 'Constantan', 'nichrome' => 'Nichrome (80/20)', 'custom' => 'Other (enter the value)']" selected="copper" />
        <div data-show-when="mat:custom">
            <x-calc.field name="rho" label="Resistivity" value="1.72e-08" min="0" placeholder="Resistivity">
                <label for="calc-rho-unit" class="sr-only">Resistivity unit</label>
                <select id="calc-rho-unit" name="rho-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.resistivity'))->only(['ohmm', 'ohmcm', 'uohmcm', 'nohmm', 'ohmmm2m']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ohmm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mat:custom">
            <x-calc.field name="alpha" label="Temperature coefficient (1/K)" value="0.00393" step="any" />
        </div>
        <x-calc.select name="size" label="Size given as" :options="['awg' => 'AWG', 'dia' => 'Diameter', 'area' => 'Area']" selected="area" />
        <div data-show-when="size:awg">
            <x-calc.select name="awg" label="AWG" :options="['0' => '0 (1/0)', '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8', '9' => '9', '10' => '10', '11' => '11', '12' => '12', '13' => '13', '14' => '14', '15' => '15', '16' => '16', '17' => '17', '18' => '18', '19' => '19', '20' => '20', '21' => '21', '22' => '22', '23' => '23', '24' => '24', '25' => '25', '26' => '26', '27' => '27', '28' => '28', '29' => '29', '30' => '30', '31' => '31', '32' => '32', '33' => '33', '34' => '34', '35' => '35', '36' => '36', '37' => '37', '38' => '38', '39' => '39', '40' => '40', '-3' => '0000 (4/0)', '-2' => '000 (3/0)', '-1' => '00 (2/0)']" selected="12" />
        </div>
        <div data-show-when="size:dia">
            <x-calc.field name="d" label="Diameter" value="1.5" placeholder="Diameter">
                <label for="calc-d-unit" class="sr-only">Diameter unit</label>
                <select id="calc-d-unit" name="d-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="size:area">
            <x-calc.field name="A" label="Area" value="2.5" min="0" placeholder="Area">
                <label for="calc-A-unit" class="sr-only">Area unit</label>
                <select id="calc-A-unit" name="A-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.area'))->only(['m2', 'cm2', 'mm2', 'km2', 'ha', 'ft2', 'in2', 'yd2', 'acre']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mm2')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.field name="L" label="Length" value="50" placeholder="Length">
            <label for="calc-L-unit" class="sr-only">Length unit</label>
            <select id="calc-L-unit" name="L-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="T" label="Temperature" value="20" placeholder="Temperature">
            <label for="calc-T-unit" class="sr-only">Temperature unit</label>
            <select id="calc-T-unit" name="T-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.temperature'))->only(['c', 'f', 'k', 'r']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['ohm' => 'Ω', 'mohm' => 'mΩ', 'kohm' => 'kΩ', 'megohm' => 'MΩ', 'gohm' => 'GΩ']" selected="ohm" />
    </div>

    <x-calc.result label="Resistance" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'ohm', 'mat' => 'copper', 'rho' => 1.72e-08, 'rho-unit' => 'ohmm', 'alpha' => 0.00393, 'size' => 'area', 'awg' => '12', 'd' => 1.5, 'd-unit' => 'mm', 'A' => 2.5, 'A-unit' => 'mm2', 'L' => 50, 'L-unit' => 'm', 'T' => 20, 'T-unit' => 'c'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'at20' => ['label' => 'At 20 °C'],
            'loop' => ['label' => 'Round trip (two conductors)'],
            'perkm' => ['label' => 'Per kilometre'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
