<x-calc.page
    title="Cost of Hiring an Expert vs. Hiring a Fresher Calculator - SolveKit"
    description="Free expert vs fresher hiring calculator: cost per unit of output including training, ramp-up and mentoring."
    lede="Compare hiring an expert or a fresher."
    about="A fresher costs less per month but needs training and time to reach full speed."
    :calc="['engine' => 'ot-misc', 'tool' => 'expert_fresher', 'fields' => ['months', 'expertSalary', 'expertRamp', 'fresherSalary', 'fresherRamp', 'fresherFull', 'training', 'mentoring'], 'data' => ['units' => collect(config('units'))->only([])->all()], 'currency' => 'USD']"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'Which is cheaper in the example?', 'answer' => 'The expert.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="months" label="Period to compare (months)" value="12" min="1" step="any" />
        <x-calc.field name="expertSalary" label="Expert: monthly cost (salary and benefits)" value="9000" min="0" step="any" suffix="$" />
        <x-calc.field name="expertRamp" label="Expert: months to full productivity" value="1" min="0" step="any" />
        <x-calc.field name="fresherSalary" label="Fresher: monthly cost" value="4000" min="0" step="any" suffix="$" />
        <x-calc.field name="fresherRamp" label="Fresher: months to full productivity" value="6" min="0" step="any" />
        <x-calc.field name="fresherFull" label="Fresher at full speed (% of an expert)" value="70" min="1" step="any" />
        <x-calc.field name="training" label="Training cost for the fresher (one-off)" value="5000" min="0" step="any" suffix="$" />
        <x-calc.field name="mentoring" label="Mentor time for the fresher (% of an expert, during ramp-up)" value="15" min="0" step="any" />
    </div>

    <x-calc.result label="Cost per unit of expert output" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['months' => 12, 'expertSalary' => 9000, 'expertRamp' => 1, 'fresherSalary' => 4000, 'fresherRamp' => 6, 'fresherFull' => 70, 'training' => 5000, 'mentoring' => 15],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'expertCost' => ['label' => 'Expert: cost and output'],
            'fresherCost' => ['label' => 'Fresher: cost and output'],
            'verdict' => ['label' => 'Cheaper per unit of work'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
