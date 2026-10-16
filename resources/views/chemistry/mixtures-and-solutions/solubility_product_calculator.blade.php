<x-calc.page
    title="Solubility Product (Ksp) Calculator - SolveKit"
    description="Free Ksp calculator: molar solubility from Ksp (with a common ion) or Ksp from solubility, for 132 salts at 25 °C."
    lede="Work out molar solubility from Ksp, or Ksp from solubility."
    about="For a salt MₓAᵧ, Ksp = [M]ˣ[A]ʸ at saturation, so with molar solubility s, Ksp = (xs)ˣ(ys)ʸ. With a common ion already present the equation is solved exactly. Ksp values are at 25 °C from the CRC Handbook; activity effects are ignored, which is accurate for dilute solutions."
    :calc="['engine' => 'chem-mix', 'tool' => 'ksp', 'fields' => ['salt', 'formula', 'ksp_value', 'mode', 'solubility', 'common', 'common_concentration'], 'data' => ['ksp' => config('chemistry_data.ksp'), 'elements' => app(\App\Services\ChemistryData::class)->elements(['name', 'weight'])]]"
    :how-to="[
        ['name' => 'Pick the salt', 'text' => 'Or enter a formula and Ksp.'],
        ['name' => 'Choose what to find', 'text' => 'Solubility or Ksp.'],
        ['name' => 'Add a common ion', 'text' => 'Optional, to see the common-ion effect.'],
    ]"
    :faqs="[
        ['question' => 'What is the solubility of AgCl?', 'answer' => 'About 1.33 × 10⁻⁵ mol/L, or 1.9 mg/L, at 25 °C.'],
        ['question' => 'What is the common-ion effect?', 'answer' => 'Adding one of the salt\'s ions lowers its solubility.'],
        ['question' => 'Why can solubility not be compared by Ksp alone?', 'answer' => 'Salts with different ion ratios have different Ksp formulas; compare the molar solubility instead.'],
    ]"
>
    <x-calc.select name="salt" label="Salt" :options="collect(config('chemistry_data.ksp'))->map(fn ($s) => $s['name'].' ('.$s['formula'].')')->put('custom', 'Custom')->all()" selected="silver_i_chloride" />

    <div data-show-when="salt:custom" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="formula" label="Salt formula" value="CaF2" type="text" help="e.g. H2SO4, Ca(OH)2, CuSO4·5H2O" />
            <x-calc.field name="ksp_value" label="Ksp" value="3.45e-11" min="0" />
        </div>
    </div>

    <x-calc.segmented name="mode" legend="Find" :options="['from_ksp' => 'Solubility', 'from_solubility' => 'Ksp']" selected="from_ksp" />

    <div data-show-when="mode:from_solubility" hidden>
        <x-calc.field name="solubility" label="Molar solubility" value="1.33e-05" min="0" suffix="mol/L" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="common" label="Common ion" :options="['none' => 'None', 'cation' => 'Cation present', 'anion' => 'Anion present']" selected="none" />
        <div data-show-when="common:cation,anion" hidden>
            <x-calc.field name="common_concentration" label="Its concentration" value="0.1" min="0" suffix="mol/L" />
        </div>
    </div>

    <x-calc.result label="Result" />

    <x-calc.options :examples="[
        'Silver chloride' => ['salt' => 'silver_i_chloride', 'mode' => 'from_ksp', 'common' => 'none'],
        'AgCl in 0.1 M NaCl' => ['salt' => 'silver_i_chloride', 'mode' => 'from_ksp', 'common' => 'anion', 'common_concentration' => 0.1],
        'Calcium phosphate' => ['salt' => 'calcium_phosphate', 'mode' => 'from_ksp', 'common' => 'none'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'ions' => ['label' => 'Ions'],
            'grams' => ['label' => 'Mass dissolved'],
            'pksp' => ['label' => 'pKsp'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Ksp = (x s)ˣ (y s)ʸ</li>
            <li>with common ion: Ksp = (x s + C)ˣ (y s)ʸ</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
