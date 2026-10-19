<x-calc.page
    title="Cash Back Calculator - SolveKit"
    description="Free Cash Back Calculator: cash back = spend × rate − annual fee. Net cash back after any annual fee."
    lede="Work out the cash back a year from monthly spend, cash back rate and annual card fee."
    about="Net cash back after any annual fee. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'cash_back', 'fields' => ['spend', 'rate', 'fee']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Monthly spend, Cash back rate, Annual card fee.'],
        ['name' => 'Read the result', 'text' => 'The cash back a year appears as you type, with monthly below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the cash back a year?', 'answer' => 'Cash back = spend × rate − annual fee.'],
        ['question' => 'What is the cash back a year for monthly spend $1,500, cash back rate 1.5%, annual card fee $0?', 'answer' => '$270.00. Monthly: $22.50.'],
        ['question' => 'And for monthly spend $3,200, cash back rate 2%, annual card fee $95?', 'answer' => '$673.00. Monthly: $64.00.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Paying interest wipes out cash back quickly.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="spend" label="Monthly spend" value="1500" step="0.01" suffix="$" />
        <x-calc.field name="rate" label="Cash back rate" value="1.5" step="any" suffix="%" />
        <x-calc.field name="fee" label="Annual card fee" value="0" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Cash back a year" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['spend' => 1500, 'rate' => 1.5, 'fee' => 0],
        'Example B' => ['spend' => 3200, 'rate' => 2, 'fee' => 95],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Monthly'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>cash back = spend × rate − annual fee</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
