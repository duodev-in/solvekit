<x-calc.page
    title="MIPI Calculator (Mantle Cell Lymphoma International Prognostic Index) - SolveKit"
    description="Free MIPI calculator: the Mantle Cell Lymphoma International Prognostic Index from age, ECOG, LDH and white cell count, with the simplified MIPI."
    lede="Calculate the MIPI."
    about="Hoster et al. (Blood 2008): MIPI = 0.03535 × age + 0.6978 (if ECOG 2–4) + 1.367 × log₁₀(LDH ÷ upper limit) + 0.9393 × log₁₀(WBC per µL). Under 5.7 is low risk, 5.7–6.2 intermediate and 6.2 or more high. The simplified MIPI uses points for the same four factors. Group results are from the original cohort. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-labs', 'tool' => 'mipi', 'fields' => ['age', 'ecog', 'ldh_ratio', 'wbc']]"
    :how-to="[
        ['name' => 'Enter age and ECOG', 'text' => ''],
        ['name' => 'Enter LDH ratio and white count', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the MIPI for age 62, ECOG 1, LDH 0.9 × normal and WBC 7.5?', 'answer' => '5.77: Intermediate risk (5.7–6.2).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="age" label="Age" value="62" min="0" step="1" suffix="years" />
        <x-calc.select name="ecog" label="ECOG performance status" :options="['0' => '0', '1' => '1', '2' => '2', '3' => '3', '4' => '4']" selected="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="ldh_ratio" label="LDH ÷ upper limit of normal" value="0.9" min="0" step="0.05" />
        <x-calc.field name="wbc" label="White cell count" value="7.5" min="0" step="any" suffix="× 10⁹/L" />
    </div>

    <x-calc.result label="MIPI" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['age' => 62, 'ecog' => '1', 'ldh_ratio' => 0.9, 'wbc' => 7.5],
        'High' => ['age' => 74, 'ecog' => '2', 'ldh_ratio' => 1.6, 'wbc' => 16],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'simple' => ['label' => 'Simplified MIPI'],
            'survival' => ['label' => 'Survival'],
            'source' => ['label' => 'Source'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>MIPI = 0.03535 A + 0.6978 E + 1.367 log LDH + 0.9393 log WBC</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
