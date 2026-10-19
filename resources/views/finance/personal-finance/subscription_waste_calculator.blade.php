<x-calc.page
    title="Subscription Waste Calculator - SolveKit"
    description="Free Subscription Waste Calculator: waste = unused subscriptions × monthly cost × 12. Counts what forgotten subscriptions cost a year."
    lede="Work out the wasted a year from subscriptions you pay for, average monthly cost and of which you rarely use."
    about="Counts what forgotten subscriptions cost a year. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'subscription_waste', 'fields' => ['subs', 'cost', 'unused']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Subscriptions you pay for, Average monthly cost, Of which you rarely use.'],
        ['name' => 'Read the result', 'text' => 'The wasted a year appears as you type, with total spent a year below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the wasted a year?', 'answer' => 'Waste = unused subscriptions × monthly cost × 12.'],
        ['question' => 'What is the wasted a year for subscriptions you pay for 8, average monthly cost $14, of which you rarely use 3?', 'answer' => '$504.00. Total spent a year: $1,344.00.'],
        ['question' => 'And for subscriptions you pay for 5, average monthly cost $11, of which you rarely use 2?', 'answer' => '$264.00. Total spent a year: $660.00.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Since 2024 the US FTC “click to cancel” efforts aim to make cancelling easier.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="subs" label="Subscriptions you pay for" value="8" step="any" />
        <x-calc.field name="cost" label="Average monthly cost" value="14" step="0.01" suffix="$" />
        <x-calc.field name="unused" label="Of which you rarely use" value="3" step="any" />
    </div>

    <x-calc.result label="Wasted a year" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['subs' => 8, 'cost' => 14, 'unused' => 3],
        'Example B' => ['subs' => 5, 'cost' => 11, 'unused' => 2],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Total spent a year'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>waste = unused subscriptions × monthly cost × 12</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
