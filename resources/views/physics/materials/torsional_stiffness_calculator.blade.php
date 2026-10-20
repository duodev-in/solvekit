<x-calc.page
    title="Torsional Stiffness Calculator - SolveKit"
    description="Free torsional stiffness calculator: k = GJ/L of a solid or hollow shaft in N·m per radian and per degree."
    lede="Find a shaft’s torsional stiffness."
    about="Torsional stiffness is the torque needed per unit twist, GJ/L."
    :calc="['engine' => 'ph-mat', 'tool' => 'torsional_stiffness', 'fields' => ['G', 'd', 'di', 'L', 'out'], 'unitFields' => ['G' => collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o'])->all(), 'd' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'di' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'L' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['area_moment', 'energy', 'force', 'length', 'mass', 'pressure', 'rotational_stiffness', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the stiffness of a 1 m, 40 mm steel shaft?', 'answer' => '19,930.3 N·m/rad.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="G" label="Shear modulus" value="79.3" min="0" placeholder="Shear modulus">
            <label for="calc-G-unit" class="sr-only">Shear modulus unit</label>
            <select id="calc-G-unit" name="G-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'gpa')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="d" label="Outer diameter" value="40" placeholder="Outer diameter">
            <label for="calc-d-unit" class="sr-only">Outer diameter unit</label>
            <select id="calc-d-unit" name="d-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="di" label="Inner diameter (0 for solid)" value="0" placeholder="Inner diameter (0 for solid)">
            <label for="calc-di-unit" class="sr-only">Inner diameter (0 for solid) unit</label>
            <select id="calc-di-unit" name="di-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="L" label="Length" value="1" placeholder="Length">
            <label for="calc-L-unit" class="sr-only">Length unit</label>
            <select id="calc-L-unit" name="L-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['nmrad' => 'N·m/rad', 'nmdeg' => 'N·m/°', 'knmrad' => 'kN·m/rad', 'lbfinrad' => 'lbf·in/rad', 'lbfindeg' => 'lbf·in/°']" selected="nmrad" />
    </div>

    <x-calc.result label="Torsional stiffness" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'nmrad', 'G' => 79.3, 'G-unit' => 'gpa', 'd' => 40, 'd-unit' => 'mm', 'di' => 0, 'di-unit' => 'mm', 'L' => 1, 'L-unit' => 'm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'perdeg' => ['label' => 'Per degree'],
            'J' => ['label' => 'Polar moment J'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
