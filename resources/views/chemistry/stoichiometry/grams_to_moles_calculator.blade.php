<x-calc.page
    title="Grams to Moles Calculator - SolveKit"
    description="Free grams to moles calculator: convert mass to moles and moles to mass for any chemical formula."
    lede="Convert grams to moles, or moles to grams."
    about="Moles = mass ÷ molar mass. The molar mass is worked out from the formula with IUPAC atomic weights."
    :calc="['engine' => 'chem-stoich', 'tool' => 'grams_moles', 'fields' => ['direction', 'formula', 'mass', 'moles'], 'unitFields' => ['mass' => collect(config('units.mass'))->only(['g', 'mg', 'kg'])->all()], 'data' => ['elements' => app(\App\Services\ChemistryData::class)->elements(['name', 'weight'])]]"
    :how-to="[
        ['name' => 'Pick the direction', 'text' => 'Grams to moles or back.'],
        ['name' => 'Enter the formula', 'text' => 'Then the mass or moles.'],
    ]"
    :faqs="[
        ['question' => 'How do I convert grams to moles?', 'answer' => 'Divide the mass by the molar mass.'],
        ['question' => 'How many moles are in 10 g of NaCl?', 'answer' => '0.171 mol (10 ÷ 58.44).'],
        ['question' => 'What is a mole?', 'answer' => '6.022 × 10²³ particles of a substance.'],
    ]"
>
    <x-calc.segmented name="direction" legend="Convert" :options="['mass' => 'Grams → moles', 'moles' => 'Moles → grams']" selected="mass" />

    <x-calc.field name="formula" label="Chemical formula" value="NaCl" type="text" help="e.g. H2SO4, Ca(OH)2, CuSO4·5H2O" />

    <div data-show-when="direction:mass">
        <x-calc.field name="mass" label="Mass" value="10" min="0" placeholder="Mass">
            <label for="calc-mass-unit" class="sr-only">Mass unit</label>
            <select id="calc-mass-unit" name="mass-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['g', 'mg', 'kg']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'g')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div data-show-when="direction:moles" hidden>
        <x-calc.field name="moles" label="Moles" value="0.5" min="0" suffix="mol" />
    </div>

    <x-calc.result label="Result" />

    <x-calc.options :examples="[
        '10 g NaCl' => ['direction' => 'mass', 'formula' => 'NaCl', 'mass' => 10, 'mass-unit' => 'g'],
        '0.5 mol glucose' => ['direction' => 'moles', 'formula' => 'C6H12O6', 'moles' => 0.5],
        '1 kg water' => ['direction' => 'mass', 'formula' => 'H2O', 'mass' => 1, 'mass-unit' => 'kg'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'mmol' => ['label' => 'In millimoles'],
            'particles' => ['label' => 'Particles'],
            'weight' => ['label' => 'Molar mass'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>n = m ÷ M</li>
            <li>m = n × M</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
