<x-calc.page
    title="Percentage Calculator - SolveKit"
    description="Free percentage calculator: find X% of a number, what percent one number is of another, or the whole from a part and its percentage, with exact fractions and the working."
    lede="Work out any percentage."
    about="A percentage is a number out of 100: p% of a whole is p ÷ 100 × whole. The same relation answers three questions: the part (15% of 80 = 12), the percentage (12 is 15% of 80) and the whole (12 is 15% of 80). Numbers are kept exact, so 1/3 or 0.1 never pick up rounding errors. Also known as percent calculator and percent of a number calculator."
    :calc="['engine' => 'mt-percent', 'tool' => 'percentage', 'fields' => ['mode', 'a', 'b']]"
    :how-to="[
        ['name' => 'Choose the question', 'text' => ''],
        ['name' => 'Enter the two numbers', 'text' => 'Fractions like 1/3 work too.'],
    ]"
    :faqs="[
        ['question' => 'What is 15% of 80?', 'answer' => '12.'],
        ['question' => '12 is what percent of 80?', 'answer' => '15%.'],
        ['question' => '30 is 12% of what?', 'answer' => '250.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Question" :options="['of' => 'What is p% of X?', 'is' => 'A is what % of B?', 'whole' => 'A is p% of what?']" selected="of" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="a" label="First number (p or A)" value="15" type="text" inputmode="decimal" />
        <x-calc.field name="b" label="Second number (X, B or A)" value="80" type="text" inputmode="decimal" />
    </div>

    <x-calc.result label="Answer" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'of', 'a' => '15', 'b' => '80'],
        'Percent of' => ['mode' => 'is', 'a' => '12', 'b' => '80'],
        'Whole' => ['mode' => 'whole', 'a' => '12', 'b' => '30'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'fraction' => ['label' => 'Exact value'],
            'formula' => ['label' => 'With your numbers'],
            'other' => ['label' => 'Also'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>part = p ÷ 100 × whole</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
