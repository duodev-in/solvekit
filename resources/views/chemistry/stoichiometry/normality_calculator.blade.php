<x-calc.page
    title="Normality Calculator - SolveKit"
    description="Free normality calculator: normality from molarity or mass and volume, with equivalent weight and meq/L."
    lede="Work out normality from molarity or from mass and volume."
    about="Normality is molarity times the equivalents per formula unit: H⁺ ions for acids, OH⁻ for bases, or electrons transferred in a redox reaction. 1 M H₂SO₄ is 2 N as an acid."
    :calc="['engine' => 'chem-stoich', 'tool' => 'normality', 'fields' => ['mode', 'molarity', 'formula', 'mass', 'volume', 'equivalents'], 'unitFields' => ['mass' => collect(config('units.mass'))->only(['g', 'mg', 'kg'])->all(), 'volume' => collect(config('units.volume'))->only(['ml', 'l'])->all()], 'data' => ['elements' => app(\App\Services\ChemistryData::class)->elements(['name', 'weight'])]]"
    :how-to="[
        ['name' => 'Enter the molarity', 'text' => 'Or the mass and volume.'],
        ['name' => 'Set the equivalents', 'text' => '2 for H₂SO₄, 3 for H₃PO₄, 1 for HCl.'],
    ]"
    :faqs="[
        ['question' => 'What is normality?', 'answer' => 'Equivalents per liter of solution.'],
        ['question' => 'Is 1 M HCl 1 N?', 'answer' => 'Yes, HCl gives one H⁺.'],
        ['question' => 'Why is normality used less today?', 'answer' => 'It depends on the reaction, so IUPAC prefers molarity with stated stoichiometry.'],
    ]"
>
    <x-calc.segmented name="mode" legend="From" :options="['molarity' => 'Molarity', 'mass' => 'Mass and volume']" selected="molarity" />

    <div data-show-when="mode:molarity">
        <x-calc.field name="molarity" label="Molarity" value="1" min="0" suffix="M" />
    </div>

    <div data-show-when="mode:mass" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="formula" label="Formula" value="H2SO4" type="text" help="e.g. H2SO4, Ca(OH)2, CuSO4·5H2O" />
            <x-calc.field name="mass" label="Mass" value="49.04" min="0" placeholder="Mass">
                <label for="calc-mass-unit" class="sr-only">Mass unit</label>
                <select id="calc-mass-unit" name="mass-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.mass'))->only(['g', 'mg', 'kg']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'g')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <div data-show-when="mode:mass" hidden>
        <x-calc.field name="volume" label="Solution volume" value="1" min="0" placeholder="Solution volume">
            <label for="calc-volume-unit" class="sr-only">Solution volume unit</label>
            <select id="calc-volume-unit" name="volume-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.volume'))->only(['ml', 'l']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'l')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.field name="equivalents" label="Equivalents per formula unit" value="2" min="1" step="1" help="H⁺, OH⁻ or electrons per formula" />

    <x-calc.result label="Normality" />

    <x-calc.options :examples="[
        '1 M H₂SO₄' => ['mode' => 'molarity', 'molarity' => 1, 'equivalents' => 2],
        '0.5 M H₃PO₄' => ['mode' => 'molarity', 'molarity' => 0.5, 'equivalents' => 3],
        '4 g NaOH in 1 L' => ['mode' => 'mass', 'formula' => 'NaOH', 'mass' => 4, 'mass-unit' => 'g', 'volume' => 1, 'volume-unit' => 'l', 'equivalents' => 1],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'molarity' => ['label' => 'Molarity'],
            'equivalent' => ['label' => 'Equivalent weight'],
            'meq' => ['label' => 'In meq/L'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>N = M × equivalents</li>
            <li>equivalent weight = M ÷ equivalents</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
