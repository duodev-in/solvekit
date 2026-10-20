<x-calc.page
    title="Debye Length Calculator - SolveKit"
    description="Free Debye length calculator: screening length in plasmas and in electrolyte solutions."
    lede="Find the Debye length."
    about="Mobile charges gather around any charge and screen it out beyond the Debye length. In a plasma it grows with temperature and falls with density; in salt water it is under a nanometre."
    :calc="['engine' => 'ph-em', 'tool' => 'debye', 'fields' => ['kind', 'Te', 'ne', 'I', 'er', 'T', 'out'], 'unitFields' => ['T' => collect(config('units.temperature'))->only(['c', 'f', 'k', 'r'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed', 'temperature'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the Debye length of a 10 eV, 10¹⁸ m⁻³ plasma?', 'answer' => '23.5082 µm.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="kind" label="Medium" :options="['plasma' => 'Plasma', 'solution' => 'Electrolyte solution']" selected="plasma" />
        <div data-show-when="kind:plasma">
            <x-calc.field name="Te" label="Electron temperature (eV)" value="10" min="0" step="any" />
        </div>
        <div data-show-when="kind:plasma">
            <x-calc.field name="ne" label="Electron density (per m³)" value="1000000000000000000" min="0" step="any" />
        </div>
        <div data-show-when="kind:solution">
            <x-calc.field name="I" label="Ionic strength (mol/L)" value="0.1" min="0" step="any" />
        </div>
        <div data-show-when="kind:solution">
            <x-calc.field name="er" label="Relative permittivity of the solvent" value="78.5" min="1" step="any" />
        </div>
        <div data-show-when="kind:solution">
            <x-calc.field name="T" label="Temperature" value="25" placeholder="Temperature">
                <label for="calc-T-unit" class="sr-only">Temperature unit</label>
                <select id="calc-T-unit" name="T-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.temperature'))->only(['c', 'f', 'k', 'r']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.select name="out" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'cm' => 'cm', 'mm' => 'mm', 'um' => 'µm', 'nm' => 'nm', 'mi' => 'mi', 'yd' => 'yd', 'ft' => 'ft', 'in' => 'in', 'nmi' => 'nmi']" selected="um" />
    </div>

    <x-calc.result label="Debye length" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'um', 'kind' => 'plasma', 'Te' => 10, 'ne' => 1000000000000000000, 'I' => 0.1, 'er' => 78.5, 'T' => 25, 'T-unit' => 'c'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'ND' => ['label' => 'Particles in a Debye sphere'],
            'note' => ['label' => 'Meaning'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
