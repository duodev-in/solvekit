<x-calc.page
    title="NNT Calculator - SolveKit"
    description="Free NNT calculator: number needed to treat (or harm) from event rates in control and treatment groups, with absolute and relative risk reduction, odds ratio and 95% confidence intervals."
    lede="Calculate the number needed to treat."
    about="The number needed to treat (Laupacis et al. 1988) is the number of people who must be treated for one extra person to benefit: NNT = 1 ÷ absolute risk reduction, rounded up. If the treatment increases the event rate, it is a number needed to harm (NNH). The confidence interval follows Altman (BMJ 1998). For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-misc', 'tool' => 'nnt', 'fields' => ['ce', 'cn', 'te', 'tn']]"
    :how-to="[
        ['name' => 'Enter events and totals for the control group', 'text' => ''],
        ['name' => 'Enter them for the treatment group', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the NNT when events fall from 30/200 to 18/200?', 'answer' => 'NNT 17 (Absolute risk reduction 6.0% (control 15.0%, treatment 9.0%)).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="ce" label="Control group events" value="30" min="0" step="1" />
        <x-calc.field name="cn" label="Control group total" value="200" min="0" step="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="te" label="Treatment group events" value="18" min="0" step="1" />
        <x-calc.field name="tn" label="Treatment group total" value="200" min="0" step="1" />
    </div>

    <x-calc.result label="Number needed to treat" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['ce' => 30, 'cn' => 200, 'te' => 18, 'tn' => 200],
        'Harm' => ['ce' => 10, 'cn' => 500, 'te' => 25, 'tn' => 500],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'arr' => ['label' => 'Absolute risk reduction'],
            'ci' => ['label' => 'NNT 95% CI'],
            'rr' => ['label' => 'Relative risk'],
            'or' => ['label' => 'Odds ratio'],
            'method' => ['label' => 'Method'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>NNT = 1 ÷ (CER − EER)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
