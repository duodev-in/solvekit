<x-calc.page
    title="Mean Sac Diameter Calculator - SolveKit"
    description="Free mean sac diameter calculator: MSD from three gestational sac diameters and the estimated gestational age in early pregnancy."
    lede="Calculate the mean sac diameter."
    about="Mean sac diameter is the average of three perpendicular measurements of the gestational sac. Before an embryo is visible, gestational age (days) ≈ MSD (mm) + 30. In the SRU consensus (Doubilet et al., N Engl J Med 2013), an MSD of 25 mm or more with no embryo is diagnostic of pregnancy failure. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-pregnancy', 'tool' => 'msd', 'fields' => ['d1', 'd2', 'd3']]"
    :how-to="[
        ['name' => 'Enter the three diameters', 'text' => 'Inner edge to inner edge.'],
    ]"
    :faqs="[
        ['question' => 'What is the MSD for 12, 10 and 11 mm?', 'answer' => '11.0 mm (About 5 weeks 6 days (MSD + 30 days)).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="d1" label="Length" value="12" min="0" step="any" suffix="mm" />
        <x-calc.field name="d2" label="Width" value="10" min="0" step="any" suffix="mm" />
        <x-calc.field name="d3" label="Depth" value="11" min="0" step="any" suffix="mm" />
    </div>

    <x-calc.result label="Mean sac diameter" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['d1' => 12, 'd2' => 10, 'd3' => 11],
        'Larger' => ['d1' => 20, 'd2' => 18, 'd3' => 19],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'ga' => ['label' => 'Gestational age'],
            'note' => ['label' => 'Note'],
            'source' => ['label' => 'Formula'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>MSD = (d₁ + d₂ + d₃) ÷ 3</li>
            <li>GA ≈ MSD + 30 days</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
