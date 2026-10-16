<x-calc.page
    title="Germination Rate Calculator - SolveKit"
    description="Free germination rate calculator: germination percentage from a seed test and how many seeds to sow."
    lede="Work out a germination rate from a seed test, and how many seeds to sow."
    about="Germination rate is the share of seeds that sprouted. To end up with a target number of plants, divide that target by the rate."
    :calc="['engine' => 'garden', 'tool' => 'germination', 'fields' => ['sown', 'sprouted', 'target']]"
    :how-to="[
        ['name' => 'Test some seeds', 'text' => 'Put 10 to 20 seeds on a damp paper towel in a bag for a week.'],
        ['name' => 'Count the sprouts', 'text' => 'Enter seeds tested and sprouted.'],
    ]"
    :faqs="[
        ['question' => 'What is a good germination rate?', 'answer' => 'Above 80% is good for most vegetable seed; packets often state the tested rate.'],
        ['question' => 'How do I do a paper towel test?', 'answer' => 'Fold seeds in a damp towel, keep it warm in a bag and count sprouts after 5 to 10 days.'],
        ['question' => 'Can I still use seeds with a low rate?', 'answer' => 'Yes, just sow more of them.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="sown" label="Seeds tested" value="20" min="1" step="1" />
        <x-calc.field name="sprouted" label="Seeds sprouted" value="17" min="0" step="1" />
        <x-calc.field name="target" label="Plants wanted (optional)" value="50" min="0" step="1" />
    </div>

    <x-calc.result label="Germination rate" />

    <x-calc.options :examples="[
        'Test 10 seeds' => ['sown' => 10, 'sprouted' => 8, 'target' => 24],
        'Old seed 20 / 9' => ['sown' => 20, 'sprouted' => 9, 'target' => 30],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'needed' => ['label' => 'Seeds to sow'],
            'failed' => ['label' => 'Seeds that failed'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>rate = sprouted ÷ sown</li>
            <li>seeds to sow = plants wanted ÷ rate</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
