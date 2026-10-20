<x-calc.page
    title="Coulomb's Law Calculator - SolveKit"
    description="Free Coulomb's law calculator: electrostatic force between two charges, solved for any value."
    lede="Solve F = kq₁q₂ ÷ r²."
    about="Charges attract or repel with a force proportional to both charges and inversely to the square of the distance. Like charges repel; unlike charges attract."
    :calc="['engine' => 'ph-em', 'tool' => 'coulomb', 'fields' => ['solve', 'F', 'q1', 'q2', 'r', 'out_F', 'out_q1', 'out_q2', 'out_r'], 'unitFields' => ['F' => collect(config('units.force'))->only(['n', 'kn', 'millinewton', 'meganewton', 'lbf', 'kgf', 'dyn', 'kip'])->all(), 'q1' => collect(config('units.charge'))->only(['c', 'mc', 'uc', 'nc', 'ah', 'mah', 'e'])->all(), 'q2' => collect(config('units.charge'))->only(['c', 'mc', 'uc', 'nc', 'ah', 'mah', 'e'])->all(), 'r' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['charge', 'energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Choose what to solve for', 'text' => 'The other quantities stay as inputs, each with its own unit.'],
        ['name' => 'Enter the values', 'text' => 'The result is shown in the unit you pick, with the rearranged formula and your numbers in the working.'],
    ]"
    :faqs="[
        ['question' => 'What force acts between two 10 µC charges 10 cm apart?', 'answer' => '89.8755 N.'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['F' => 'Force (positive = repulsive)', 'q1' => 'Charge 1', 'q2' => 'Charge 2', 'r' => 'Distance']" selected="F" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:q1,q2,r" hidden>
            <x-calc.field name="F" label="Force (positive = repulsive)" value="8.98755" placeholder="Force (positive = repulsive)">
                <label for="calc-F-unit" class="sr-only">Force (positive = repulsive) unit</label>
                <select id="calc-F-unit" name="F-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.force'))->only(['n', 'kn', 'millinewton', 'meganewton', 'lbf', 'kgf', 'dyn', 'kip']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'n')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:F,q2,r">
            <x-calc.field name="q1" label="Charge 1" value="10" placeholder="Charge 1">
                <label for="calc-q1-unit" class="sr-only">Charge 1 unit</label>
                <select id="calc-q1-unit" name="q1-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.charge'))->only(['c', 'mc', 'uc', 'nc', 'ah', 'mah', 'e']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'uc')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:F,q1,r">
            <x-calc.field name="q2" label="Charge 2" value="10" placeholder="Charge 2">
                <label for="calc-q2-unit" class="sr-only">Charge 2 unit</label>
                <select id="calc-q2-unit" name="q2-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.charge'))->only(['c', 'mc', 'uc', 'nc', 'ah', 'mah', 'e']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'uc')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:F,q1,q2">
            <x-calc.field name="r" label="Distance" value="10" placeholder="Distance">
                <label for="calc-r-unit" class="sr-only">Distance unit</label>
                <select id="calc-r-unit" name="r-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:F">
            <x-calc.select name="out_F" label="Show the result in" :options="['n' => 'N', 'kn' => 'kN', 'millinewton' => 'mN', 'meganewton' => 'MN', 'lbf' => 'lbf', 'kgf' => 'kgf', 'dyn' => 'dyn', 'kip' => 'kip']" selected="n" />
        </div>
        <div data-show-when="solve:q1" hidden>
            <x-calc.select name="out_q1" label="Show the result in" :options="['c' => 'C', 'mc' => 'mC', 'uc' => 'µC', 'nc' => 'nC', 'ah' => 'Ah', 'mah' => 'mAh', 'e' => 'e']" selected="uc" />
        </div>
        <div data-show-when="solve:q2" hidden>
            <x-calc.select name="out_q2" label="Show the result in" :options="['c' => 'C', 'mc' => 'mC', 'uc' => 'µC', 'nc' => 'nC', 'ah' => 'Ah', 'mah' => 'mAh', 'e' => 'e']" selected="uc" />
        </div>
        <div data-show-when="solve:r" hidden>
            <x-calc.select name="out_r" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'cm' => 'cm', 'mm' => 'mm', 'um' => 'µm', 'nm' => 'nm', 'mi' => 'mi', 'yd' => 'yd', 'ft' => 'ft', 'in' => 'in', 'nmi' => 'nmi']" selected="cm" />
        </div>
    </div>

    <x-calc.result label="Force (positive = repulsive)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['solve' => 'F', 'F' => 8.98755, 'F-unit' => 'n', 'out_F' => 'n', 'q1' => 10, 'q1-unit' => 'uc', 'out_q1' => 'uc', 'q2' => 10, 'q2-unit' => 'uc', 'out_q2' => 'uc', 'r' => 10, 'r-unit' => 'cm', 'out_r' => 'cm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'formula' => ['label' => 'Rearranged formula'],
            'si' => ['label' => 'Result in common units'],
            'kind' => ['label' => 'Interaction'],
            'k' => ['label' => 'Coulomb constant k'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>F = k q₁ q₂ ÷ r²</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
