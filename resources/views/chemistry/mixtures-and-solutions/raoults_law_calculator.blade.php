<x-calc.page
    title="Raoult's Law Calculator - SolveKit"
    description="Free Raoult's law calculator: vapor pressure of an ideal solution of two volatile liquids, or a solvent with a non-volatile solute."
    lede="Work out the vapor pressure of an ideal solution."
    about="For an ideal solution each component's partial pressure is its mole fraction times its pure vapor pressure. With a non-volatile solute only the solvent evaporates, so the vapor pressure drops in proportion to the solute's mole fraction. Real mixtures such as ethanol and water deviate from this."
    :calc="['engine' => 'chem-mix', 'tool' => 'raoult', 'fields' => ['mode', 'x1', 'p1', 'p2', 'solute_moles', 'solvent_moles', 'p_solvent'], 'unitFields' => ['p1' => collect(config('units.pressure'))->only(['kpa', 'atm', 'bar', 'mmhg', 'pa', 'psi'])->all(), 'p2' => collect(config('units.pressure'))->only(['kpa', 'atm', 'bar', 'mmhg', 'pa', 'psi'])->all(), 'p_solvent' => collect(config('units.pressure'))->only(['kpa', 'atm', 'bar', 'mmhg', 'pa', 'psi'])->all()]]"
    :how-to="[
        ['name' => 'Choose the solution', 'text' => 'Two liquids, or a solute in a solvent.'],
        ['name' => 'Enter mole fractions and vapor pressures', 'text' => 'Pure vapor pressures at the same temperature.'],
    ]"
    :faqs="[
        ['question' => 'What is Raoult\'s law?', 'answer' => 'P = x P°: a component\'s vapor pressure is lowered in proportion to its mole fraction.'],
        ['question' => 'Why is the vapor richer in one liquid?', 'answer' => 'The more volatile liquid makes up a larger share of the vapor than of the liquid.'],
        ['question' => 'How much does salt lower water\'s vapor pressure?', 'answer' => '1 mol of solute in 1 kg of water lowers it by about 1.8%.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Solution" :options="['volatile' => 'Two volatile liquids', 'nonvolatile' => 'Non-volatile solute']" selected="volatile" />

    <div data-show-when="mode:volatile">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
            <x-calc.field name="x1" label="Mole fraction of liquid 1" value="0.5" min="0" max="1" />
            <x-calc.field name="p1" label="Pure P°, liquid 1" value="12.7" min="0" placeholder="Pure P°, liquid 1">
                <label for="calc-p1-unit" class="sr-only">Pure P°, liquid 1 unit</label>
                <select id="calc-p1-unit" name="p1-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.pressure'))->only(['kpa', 'atm', 'bar', 'mmhg', 'pa', 'psi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kpa')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
            <x-calc.field name="p2" label="Pure P°, liquid 2" value="3.8" min="0" placeholder="Pure P°, liquid 2">
                <label for="calc-p2-unit" class="sr-only">Pure P°, liquid 2 unit</label>
                <select id="calc-p2-unit" name="p2-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.pressure'))->only(['kpa', 'atm', 'bar', 'mmhg', 'pa', 'psi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kpa')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <div data-show-when="mode:nonvolatile" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
            <x-calc.field name="solute_moles" label="Solute" value="1" min="0" suffix="mol" />
            <x-calc.field name="solvent_moles" label="Solvent" value="55.51" min="0" suffix="mol" />
            <x-calc.field name="p_solvent" label="Pure solvent P°" value="3.169" min="0" placeholder="Pure solvent P°">
                <label for="calc-p_solvent-unit" class="sr-only">Pure solvent P° unit</label>
                <select id="calc-p_solvent-unit" name="p_solvent-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.pressure'))->only(['kpa', 'atm', 'bar', 'mmhg', 'pa', 'psi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kpa')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <x-calc.result label="Vapor pressure" />

    <x-calc.options :examples="[
        'Benzene + toluene (25 °C)' => ['mode' => 'volatile', 'x1' => 0.5, 'p1' => 12.7, 'p1-unit' => 'kpa', 'p2' => 3.8, 'p2-unit' => 'kpa'],
        '1 mol sugar in 1 kg water' => ['mode' => 'nonvolatile', 'solute_moles' => 1, 'solvent_moles' => 55.51, 'p_solvent' => 3.169, 'p_solvent-unit' => 'kpa'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'x1' => ['label' => 'Liquid mole fractions'],
            'p1' => ['label' => 'Partial pressure 1'],
            'p2' => ['label' => 'Partial pressure 2'],
            'y1' => ['label' => 'Vapor mole fraction 1'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>P total = x₁P₁° + x₂P₂°</li>
            <li>y₁ = x₁P₁° ÷ P total</li>
            <li>non-volatile: P = x solvent × P°</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
