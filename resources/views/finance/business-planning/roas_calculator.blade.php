<x-calc.page
    title="ROAS Calculator - SolveKit"
    description="Free ROAS Calculator: ROAS = revenue ÷ ad spend. ROAS is revenue earned per dollar of advertising."
    lede="Work out the return on ad spend from revenue from ads, ad spend and gross margin (optional)."
    about="ROAS is revenue earned per dollar of advertising. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'roas', 'fields' => ['revenue', 'spend', 'margin']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Revenue from ads, Ad spend, Gross margin (optional).'],
        ['name' => 'Read the result', 'text' => 'The return on ad spend appears as you type, with as a percentage, break-even ROAS below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the return on ad spend?', 'answer' => 'ROAS = revenue ÷ ad spend; break-even ROAS = 1 ÷ margin.'],
        ['question' => 'What is the return on ad spend for revenue from ads $15,000, ad spend $3,000, gross margin 40%?', 'answer' => '5×. As a percentage: 500%.'],
        ['question' => 'And for revenue from ads $4,200, ad spend $1,500, gross margin 30%?', 'answer' => '2.8×. As a percentage: 280%.'],
        ['question' => 'What does the result tell me?', 'answer' => 'With a 40% margin, ads break even at a ROAS of 2.5.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="revenue" label="Revenue from ads" value="15000" step="0.01" suffix="$" />
        <x-calc.field name="spend" label="Ad spend" value="3000" step="0.01" suffix="$" />
        <x-calc.field name="margin" label="Gross margin (optional)" value="40" step="any" suffix="%" />
    </div>

    <x-calc.result label="Return on ad spend" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['revenue' => 15000, 'spend' => 3000, 'margin' => 40],
        'Example B' => ['revenue' => 4200, 'spend' => 1500, 'margin' => 30],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'As a percentage'],
            'r2' => ['label' => 'Break-even ROAS'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>ROAS = revenue ÷ ad spend</li>
            <li>break-even ROAS = 1 ÷ margin</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
