<x-calc.page
    title="Elastic Potential Energy Calculator - SolveKit"
    description="Free elastic potential energy calculator: energy stored in a spring, E = ½kx², solved for any value."
    lede="Solve E = ½kx²."
    about="Stretching or compressing a spring stores energy equal to the work done, ½kx²."
    :calc="['engine' => 'ph-mech', 'tool' => 'elastic_pe', 'fields' => ['solve', 'E', 'k', 'x', 'out_E', 'out_k', 'out_x'], 'unitFields' => ['E' => collect(config('units.energy'))->only(['j', 'kj', 'mj', 'gj', 'wh', 'kwh', 'cal', 'kcal', 'btu', 'ftlbf', 'ev'])->all(), 'k' => collect(config('units.stiffness'))->only(['npm', 'npmm', 'knpm', 'npcm', 'lbfpin', 'lbfpft', 'kgfpmm'])->all(), 'x' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['E', 'energy', 'force', 'length', 'mass', 'speed', 'stiffness'])->all()]]"
    :how-to="[
        ['name' => 'Choose what to solve for', 'text' => 'The other quantities stay as inputs, each with its own unit.'],
        ['name' => 'Enter the values', 'text' => 'The result is shown in the unit you pick, with the rearranged formula and your numbers in the working.'],
    ]"
    :faqs="[
        ['question' => 'How much energy is in a 500 N/m spring stretched 10 cm?', 'answer' => '2.5 J.'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['E' => 'Elastic potential energy', 'k' => 'Spring constant', 'x' => 'Extension or compression']" selected="E" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:k,x" hidden>
            <x-calc.field name="E" label="Elastic potential energy" value="2.5" placeholder="Elastic potential energy">
                <label for="calc-E-unit" class="sr-only">Elastic potential energy unit</label>
                <select id="calc-E-unit" name="E-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.energy'))->only(['j', 'kj', 'mj', 'gj', 'wh', 'kwh', 'cal', 'kcal', 'btu', 'ftlbf', 'ev']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'j')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:E,x">
            <x-calc.field name="k" label="Spring constant" value="500" min="0" placeholder="Spring constant">
                <label for="calc-k-unit" class="sr-only">Spring constant unit</label>
                <select id="calc-k-unit" name="k-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.stiffness'))->only(['npm', 'npmm', 'knpm', 'npcm', 'lbfpin', 'lbfpft', 'kgfpmm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'npm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:E,k">
            <x-calc.field name="x" label="Extension or compression" value="10" placeholder="Extension or compression">
                <label for="calc-x-unit" class="sr-only">Extension or compression unit</label>
                <select id="calc-x-unit" name="x-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:E">
            <x-calc.select name="out_E" label="Show the result in" :options="['j' => 'J', 'kj' => 'kJ', 'mj' => 'MJ', 'gj' => 'GJ', 'wh' => 'Wh', 'kwh' => 'kWh', 'cal' => 'cal', 'kcal' => 'kcal', 'btu' => 'BTU', 'ftlbf' => 'ft·lbf', 'ev' => 'eV']" selected="j" />
        </div>
        <div data-show-when="solve:k" hidden>
            <x-calc.select name="out_k" label="Show the result in" :options="['npm' => 'N/m', 'npmm' => 'N/mm', 'knpm' => 'kN/m', 'npcm' => 'N/cm', 'lbfpin' => 'lbf/in', 'lbfpft' => 'lbf/ft', 'kgfpmm' => 'kgf/mm']" selected="npm" />
        </div>
        <div data-show-when="solve:x" hidden>
            <x-calc.select name="out_x" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'cm' => 'cm', 'mm' => 'mm', 'um' => 'µm', 'nm' => 'nm', 'mi' => 'mi', 'yd' => 'yd', 'ft' => 'ft', 'in' => 'in', 'nmi' => 'nmi']" selected="cm" />
        </div>
    </div>

    <x-calc.result label="Elastic potential energy" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['solve' => 'E', 'E' => 2.5, 'E-unit' => 'j', 'out_E' => 'j', 'k' => 500, 'k-unit' => 'npm', 'out_k' => 'npm', 'x' => 10, 'x-unit' => 'cm', 'out_x' => 'cm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'formula' => ['label' => 'Rearranged formula'],
            'si' => ['label' => 'Result in common units'],
            'F' => ['label' => 'Force at that extension'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>E = ½ k x²</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
