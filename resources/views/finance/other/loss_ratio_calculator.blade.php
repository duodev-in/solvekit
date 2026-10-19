<x-calc.page
    title="Loss Ratio Calculator - SolveKit"
    description="Free Loss Ratio Calculator: loss ratio = losses ÷ earned premiums. The share of premiums paid out in claims."
    lede="Work out the loss ratio from incurred losses and adjustment expenses and earned premiums."
    about="The share of premiums paid out in claims. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'loss_ratio', 'fields' => ['losses', 'premiums']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Incurred losses and adjustment expenses, Earned premiums.'],
        ['name' => 'Read the result', 'text' => 'The loss ratio appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the loss ratio?', 'answer' => 'Loss ratio = losses ÷ earned premiums.'],
        ['question' => 'What is the loss ratio for incurred losses and adjustment expenses $700,000, earned premiums $1,000,000?', 'answer' => '70%.'],
        ['question' => 'And for incurred losses and adjustment expenses $52,000, earned premiums $80,000?', 'answer' => '65%.'],
        ['question' => 'What does the result tell me?', 'answer' => 'The ACA requires health insurers to spend at least 80–85% of premiums on care (medical loss ratio).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="losses" label="Incurred losses and adjustment expenses" value="700000" step="0.01" suffix="$" />
        <x-calc.field name="premiums" label="Earned premiums" value="1000000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Loss ratio" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['losses' => 700000, 'premiums' => 1000000],
        'Example B' => ['losses' => 52000, 'premiums' => 80000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>loss ratio = losses ÷ earned premiums</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
