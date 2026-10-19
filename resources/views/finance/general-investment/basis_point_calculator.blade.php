<x-calc.page
    title="Basis Point Calculator - SolveKit"
    description="Free Basis Point Calculator: 1 basis point = 0.01% = 0.0001. A basis point is one hundredth of a percentage point, used for rates and fees."
    lede="Work out the as a percentage from basis points and amount (optional)."
    about="A basis point is one hundredth of a percentage point, used for rates and fees. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'basis_point', 'fields' => ['bp', 'amount']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Basis points, Amount (optional).'],
        ['name' => 'Read the result', 'text' => 'The as a percentage appears as you type, with as a decimal, on the amount below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the as a percentage?', 'answer' => '1 basis point = 0.01% = 0.0001.'],
        ['question' => 'What is the as a percentage for basis points 25, amount $100,000?', 'answer' => '0.25%. As a decimal: 0.0025.'],
        ['question' => 'And for basis points 150, amount $2,500,000?', 'answer' => '1.5%. As a decimal: 0.015.'],
        ['question' => 'What does the result tell me?', 'answer' => 'A 25 bp rate cut lowers 5.50% to 5.25%.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="bp" label="Basis points" value="25" step="any" />
        <x-calc.field name="amount" label="Amount (optional)" value="100000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="As a percentage" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['bp' => 25, 'amount' => 100000],
        'Example B' => ['bp' => 150, 'amount' => 2500000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'As a decimal'],
            'r2' => ['label' => 'On the amount'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>1 basis point = 0.01% = 0.0001</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
