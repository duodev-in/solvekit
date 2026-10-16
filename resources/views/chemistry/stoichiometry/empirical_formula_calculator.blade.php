<x-calc.page
    title="Empirical Formula Calculator - SolveKit"
    description="Free empirical formula calculator: simplest whole-number formula from element masses or percentages, and the molecular formula from molar mass."
    lede="Find the empirical and molecular formula from element percentages or masses."
    about="Each amount is divided by the element's atomic weight to give moles, then by the smallest to give a ratio. The ratios are multiplied by the smallest whole number (1 to 12) that makes each one within 0.08 of an integer. With a molar mass, the molecular formula is the empirical formula times M ÷ M(empirical)."
    :calc="['engine' => 'chem-stoich', 'tool' => 'empirical', 'fields' => ['amounts', 'molar_mass'], 'data' => ['elements' => app(\App\Services\ChemistryData::class)->elements(['name', 'weight'])]]"
    :how-to="[
        ['name' => 'Enter each element', 'text' => 'Symbol and percent or mass, one per line.'],
        ['name' => 'Add the molar mass', 'text' => 'For the molecular formula.'],
    ]"
    :faqs="[
        ['question' => 'What is the difference between empirical and molecular formulas?', 'answer' => 'The empirical formula is the simplest ratio (CH₂O); the molecular formula is the real count (C₆H₁₂O₆).'],
        ['question' => 'Can I use grams instead of percent?', 'answer' => 'Yes, any masses work because only the ratios matter.'],
        ['question' => 'Why multiply by 2 or 3?', 'answer' => 'Ratios like 1.5 or 1.33 mean the formula needs ×2 or ×3 to become whole numbers.'],
    ]"
>
    <x-calc.textarea name="amounts" label="Element and amount, one per line" value="C 40.0
H 6.71
O 53.3" help="Percent or grams, e.g. C 40.0" rows="4" />

    <x-calc.field name="molar_mass" label="Molar mass (optional)" value="180.16" min="0" suffix="g/mol" placeholder="Optional" />

    <x-calc.result label="Empirical formula" />

    <x-calc.options :decimals="false" :examples="[
        'Glucose (C 40.0%)' => ['amounts' => 'C 40.0
H 6.71
O 53.3', 'molar_mass' => 180.16],
        'Iron oxide' => ['amounts' => 'Fe 69.94
O 30.06', 'molar_mass' => ''],
        'Benzene (C 92.3%)' => ['amounts' => 'C 92.26
H 7.74', 'molar_mass' => 78.11],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'molecular' => ['label' => 'Molecular formula'],
            'mass' => ['label' => 'Empirical formula mass'],
            'multiplier' => ['label' => 'Multiplier used'],
        ]" />
        <x-calc.quick-ref heading="Mole ratios" name="ratios" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>moles = amount ÷ atomic weight</li>
            <li>ratio = moles ÷ smallest</li>
            <li>molecular = empirical × (M ÷ M empirical)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
