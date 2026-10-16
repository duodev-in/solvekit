<x-calc.page
    title="Neutralization Calculator - SolveKit"
    description="Free neutralization calculator: volume of base needed to neutralize an acid, the pH at the equivalence point and the salt formed."
    lede="Work out how much base neutralizes an acid."
    about="At neutralization the moles of H⁺ from the acid equal the moles of OH⁻ (or H⁺ accepted) from the base. Every acidic hydrogen is counted, so H₂SO₄ needs twice as much NaOH as HCl. The pH at the equivalence point comes from the exact acid–base solver: it is 7 only for a strong acid with a strong base."
    :calc="['engine' => 'chem-mix', 'tool' => 'neutralization', 'fields' => ['acid', 'base', 'acid_concentration', 'acid_volume', 'base_concentration'], 'unitFields' => ['acid_volume' => collect(config('units.volume'))->only(['ml', 'l'])->all()], 'data' => ['acids' => config('chemistry_data.acids'), 'bases' => config('chemistry_data.bases'), 'elements' => app(\App\Services\ChemistryData::class)->elements(['name', 'weight'])]]"
    :how-to="[
        ['name' => 'Pick the acid and base', 'text' => 'From the data table.'],
        ['name' => 'Enter the concentrations and acid volume', 'text' => 'Volumes in mL or L.'],
    ]"
    :faqs="[
        ['question' => 'How much NaOH neutralizes 25 mL of 0.1 M HCl?', 'answer' => '25 mL of 0.1 M NaOH.'],
        ['question' => 'Why is the equivalence pH above 7 for acetic acid?', 'answer' => 'The acetate ion formed is a weak base.'],
        ['question' => 'Does this cover every proton of phosphoric acid?', 'answer' => 'Yes, all three, which is full neutralization.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="acid" label="Acid" :options="collect(config('chemistry_data.acids'))->mapWithKeys(fn ($a, $k) => ['acid:'.$k => $a['name'].' ('.$a['formula'].')'])->all()" selected="acid:hydrochloric_acid" />
        <x-calc.select name="base" label="Base" :options="collect(config('chemistry_data.bases'))->mapWithKeys(fn ($b, $k) => ['base:'.$k => $b['name'].' ('.$b['formula'].')'])->all()" selected="base:sodium_hydroxide" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="acid_concentration" label="Acid concentration" value="0.1" min="0" suffix="M" />
        <x-calc.field name="acid_volume" label="Acid volume" value="25" min="0" placeholder="Acid volume">
            <label for="calc-acid_volume-unit" class="sr-only">Acid volume unit</label>
            <select id="calc-acid_volume-unit" name="acid_volume-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.volume'))->only(['ml', 'l']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ml')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="base_concentration" label="Base concentration" value="0.1" min="0" suffix="M" />
    </div>

    <x-calc.result label="Base to neutralize" />

    <x-calc.options :examples="[
        'HCl + NaOH' => ['acid' => 'acid:hydrochloric_acid', 'base' => 'base:sodium_hydroxide', 'acid_concentration' => 0.1, 'acid_volume' => 25, 'acid_volume-unit' => 'ml', 'base_concentration' => 0.1],
        'H₂SO₄ + NaOH' => ['acid' => 'acid:sulfuric_acid', 'base' => 'base:sodium_hydroxide', 'acid_concentration' => 0.1, 'acid_volume' => 25, 'acid_volume-unit' => 'ml', 'base_concentration' => 0.1],
        'Acetic acid + NaOH' => ['acid' => 'acid:acetic_acid', 'base' => 'base:sodium_hydroxide', 'acid_concentration' => 0.1, 'acid_volume' => 25, 'acid_volume-unit' => 'ml', 'base_concentration' => 0.1],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'moles' => ['label' => 'Acid'],
            'equivalents' => ['label' => 'Equivalents'],
            'ph' => ['label' => 'Equivalence pH'],
            'salt' => ['label' => 'Salt formed'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>n(H⁺) = C acid × V acid × acidic H</li>
            <li>V base = n(H⁺) ÷ (C base × OH⁻ per base)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
