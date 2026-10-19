<x-calc.page
    title="Money Counter Calculator - SolveKit"
    description="Free money counter: total cash from counts of each note and coin, for a till, cash drawer or savings jar."
    lede="Count notes and coins."
    about="Total = Σ denomination × count. Enter each denomination in your currency's main unit (0.25 for a quarter) and how many you have; the default rows are US bills and coins. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-life', 'tool' => 'money_counter', 'fields' => ['counts']]"
    :how-to="[
        ['name' => 'Enter each denomination', 'text' => ''],
        ['name' => 'Enter the counts', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the total of the example drawer?', 'answer' => '$734.87.'],
    ]"
>
    <x-calc.rows-editor name="counts" label="Denominations and counts" :columns="['value' => 'Denomination', 'count' => 'Count']" :rows="[[100, 2], [50, 3], [20, 12], [10, 7], [5, 9], [1, 23], [0.25, 18], [0.1, 15], [0.05, 9], [0.01, 42]]" />

    <x-calc.result label="Total" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['counts' => '100 2
50 3
20 12
10 7
5 9
1 23
0.25 18
0.1 15
0.05 9
0.01 42'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'notes' => ['label' => 'Bills'],
            'coins' => ['label' => 'Coins'],
            'pieces' => ['label' => 'Pieces'],
            'largest' => ['label' => 'Largest denomination'],
        ]" />
        <x-calc.quick-ref heading="By denomination" name="lines" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>total = Σ value × count</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
