<x-calc.page
    title="Relativistic Kinetic Energy Calculator - SolveKit"
    description="Free relativistic kinetic energy calculator: K = (γ − 1)mc² compared with ½mv²."
    lede="Find relativistic kinetic energy."
    about="At high speed kinetic energy grows without limit as v approaches c. The classical ½mv² underestimates it more and more."
    :calc="['engine' => 'ph-astro', 'tool' => 'relativistic_ke', 'fields' => ['m', 'v', 'out'], 'unitFields' => ['m' => collect(config('units.particle_mass'))->only(['kg', 'g', 'u', 'me', 'mevc2'])->all(), 'v' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'particle_energy', 'particle_mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the KE of 1 kg at 0.8c?', 'answer' => '5.9917 × 10¹⁶ J.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="m" label="Rest mass" value="1" min="0" placeholder="Rest mass">
            <label for="calc-m-unit" class="sr-only">Rest mass unit</label>
            <select id="calc-m-unit" name="m-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.particle_mass'))->only(['kg', 'g', 'u', 'me', 'mevc2']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="v" label="Speed" value="0.8" placeholder="Speed">
            <label for="calc-v-unit" class="sr-only">Speed unit</label>
            <select id="calc-v-unit" name="v-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['j' => 'J', 'kj' => 'kJ', 'mj' => 'MJ', 'gj' => 'GJ', 'wh' => 'Wh', 'kwh' => 'kWh', 'cal' => 'cal', 'kcal' => 'kcal', 'btu' => 'BTU', 'ftlbf' => 'ft·lbf', 'ev' => 'eV']" selected="j" />
    </div>

    <x-calc.result label="Relativistic kinetic energy" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'j', 'm' => 1, 'm-unit' => 'kg', 'v' => 0.8, 'v-unit' => 'c'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'classical' => ['label' => 'Classical ½mv²'],
            'total' => ['label' => 'Total energy γmc²'],
            'gamma' => ['label' => 'Lorentz factor γ'],
            'ev' => ['label' => 'In electronvolts'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
