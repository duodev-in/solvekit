<x-calc.page
    title="Water Hardness Calculator - SolveKit"
    description="Free water hardness calculator: convert between mg/L CaCO3, ppm, grains per gallon, German, French and English degrees, or from calcium and magnesium."
    lede="Convert water hardness between units, or work it out from calcium and magnesium."
    about="Hardness is expressed as the equivalent mass of calcium carbonate. Conversions use IUPAC molar masses: 1 gpg = 17.118 mg/L, 1 °dH = 17.848 mg/L, 1 °fH = 10 mg/L and 1 °e = 14.254 mg/L. From ions, hardness = 2.497 × Ca + 4.118 × Mg (mg/L). Classes follow the USGS."
    :calc="['engine' => 'chem-mix', 'tool' => 'water_hardness', 'fields' => ['mode', 'value', 'from', 'calcium', 'magnesium'], 'data' => ['elements' => app(\App\Services\ChemistryData::class)->elements(['weight'])]]"
    :how-to="[
        ['name' => 'Enter the hardness', 'text' => 'In any unit, or as calcium and magnesium.'],
        ['name' => 'Read every unit', 'text' => 'And the hardness class.'],
    ]"
    :faqs="[
        ['question' => 'What is hard water?', 'answer' => 'Above about 120 mg/L as CaCO₃ by the USGS scale.'],
        ['question' => 'How do I convert gpg to ppm?', 'answer' => 'Multiply by 17.118.'],
        ['question' => 'Why is it expressed as CaCO₃?', 'answer' => 'So calcium and magnesium can be added up on one scale.'],
    ]"
>
    <x-calc.segmented name="mode" legend="From" :options="['value' => 'A hardness value', 'ions' => 'Calcium and magnesium']" selected="value" />

    <div data-show-when="mode:value">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="value" label="Hardness" value="150" min="0" />
            <x-calc.select name="from" label="Unit" :options="['mgl' => 'mg/L CaCO₃ (ppm)', 'mmol' => 'mmol/L', 'gpg' => 'gpg', 'dh' => '°dH', 'fh' => '°fH', 'e' => '°e (Clark)']" selected="mgl" />
        </div>
    </div>

    <div data-show-when="mode:ions" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="calcium" label="Calcium" value="40" min="0" suffix="mg/L" />
            <x-calc.field name="magnesium" label="Magnesium" value="10" min="0" suffix="mg/L" />
        </div>
    </div>

    <x-calc.result label="Water hardness" />

    <x-calc.options :examples="[
        '150 mg/L' => ['mode' => 'value', 'value' => 150, 'from' => 'mgl'],
        '10 gpg' => ['mode' => 'value', 'value' => 10, 'from' => 'gpg'],
        '14 °dH' => ['mode' => 'value', 'value' => 14, 'from' => 'dh'],
        'Ca 40, Mg 10 mg/L' => ['mode' => 'ions', 'calcium' => 40, 'magnesium' => 10],
    ]" />

    <x-slot:panel>
        <x-calc.quick-ref heading="In every unit" name="units" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>hardness = 2.497 Ca + 4.118 Mg</li>
            <li>1 gpg = 17.118 mg/L; 1 °dH = 17.848 mg/L; 1 °fH = 10 mg/L</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
