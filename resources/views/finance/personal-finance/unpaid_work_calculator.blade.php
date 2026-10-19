<x-calc.page
    title="Unpaid Work Calculator - SolveKit"
    description="Free Unpaid Work Calculator: value = hours × market wage × 52. Puts a value on housework, childcare and caring by pricing hours at what you would pay someone else."
    lede="Work out the value a year from hours of unpaid work a week and market wage for the work."
    about="Puts a value on housework, childcare and caring by pricing hours at what you would pay someone else. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'unpaid_work', 'fields' => ['hours', 'wage']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Hours of unpaid work a week, Market wage for the work.'],
        ['name' => 'Read the result', 'text' => 'The value a year appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the value a year?', 'answer' => 'Value = hours × market wage × 52.'],
        ['question' => 'What is the value a year for hours of unpaid work a week 25, market wage for the work $20?', 'answer' => '$26,000.00.'],
        ['question' => 'And for hours of unpaid work a week 40, market wage for the work $18?', 'answer' => '$37,440.00.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Statistical agencies value it in household satellite accounts.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="hours" label="Hours of unpaid work a week" value="25" min="0" step="any" suffix="hours" />
        <x-calc.field name="wage" label="Market wage for the work" value="20" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Value a year" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['hours' => 25, 'wage' => 20],
        'Example B' => ['hours' => 40, 'wage' => 18],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>value = hours × market wage × 52</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
