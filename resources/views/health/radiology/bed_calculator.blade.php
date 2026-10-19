<x-calc.page
    title="BED Calculator - SolveKit"
    description="Free BED calculator: biologically effective dose and EQD2 for a radiotherapy fractionation from dose per fraction, number of fractions and α/β."
    lede="Calculate BED and EQD2."
    about="The linear-quadratic model compares fractionation schemes: BED = n × d × (1 + d ÷ α/β) and EQD2 = BED ÷ (1 + 2 ÷ α/β), the equivalent total dose in 2 Gy fractions. α/β is about 10 Gy for most tumours and early-reacting tissue, 3 Gy for late-reacting tissue and about 1.5 Gy for prostate cancer. It ignores treatment time and repopulation. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-misc', 'tool' => 'bed', 'fields' => ['dose', 'fractions', 'ab', 'ab_custom']]"
    :how-to="[
        ['name' => 'Enter the fractionation', 'text' => ''],
        ['name' => 'Choose α/β', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the BED of 40 Gy in 15 fractions (α/β 10)?', 'answer' => '50.7 Gy (EQD2 42.3 Gy; total physical dose 40.0 Gy).'],
        ['question' => 'And for late effects (α/β 3)?', 'answer' => '75.7 Gy.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="dose" label="Dose per fraction" value="2.67" min="0" step="any" suffix="Gy" />
        <x-calc.field name="fractions" label="Fractions" value="15" min="0" step="1" />
        <x-calc.select name="ab" label="α/β" :options="['10' => '10 Gy (tumour, early effects)', '3' => '3 Gy (late effects)', '2' => '2 Gy', '1.5' => '1.5 Gy (prostate)', 'custom' => 'Other']" selected="10" />
    </div>

    <div data-show-when="ab:custom" hidden>
        <x-calc.field name="ab_custom" label="α/β" value="4" min="0" step="any" suffix="Gy" />
    </div>

    <x-calc.result label="BED" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['dose' => 2.67, 'fractions' => 15, 'ab' => '10', 'ab_custom' => 4],
        'Late' => ['dose' => 2.67, 'fractions' => 15, 'ab' => '3', 'ab_custom' => 4],
        'SBRT' => ['dose' => 12, 'fractions' => 4, 'ab' => '10', 'ab_custom' => 4],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'eqd2' => ['label' => 'EQD2'],
            'formula' => ['label' => 'Formula'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>BED = nd(1 + d ÷ α/β)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
