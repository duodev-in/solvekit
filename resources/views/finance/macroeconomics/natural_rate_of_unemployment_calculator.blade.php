<x-calc.page
    title="Natural Rate of Unemployment Calculator - SolveKit"
    description="Free Natural Rate of Unemployment Calculator: u* = (frictional + structural) ÷ labor force. The natural rate is unemployment with no cyclical component."
    lede="Work out the natural rate of unemployment from frictionally unemployed, structurally unemployed and labor force."
    about="The natural rate is unemployment with no cyclical component. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'natural_rate_of_unemployment', 'fields' => ['frictional', 'structural', 'labor']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Frictionally unemployed, Structurally unemployed, Labor force.'],
        ['name' => 'Read the result', 'text' => 'The natural rate of unemployment appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the natural rate of unemployment?', 'answer' => 'U* = (frictional + structural) ÷ labor force.'],
        ['question' => 'What is the natural rate of unemployment for frictionally unemployed 4,000,000, structurally unemployed 3,000,000, labor force 168,000,000?', 'answer' => '4.167%.'],
        ['question' => 'And for frictionally unemployed 120, structurally unemployed 80, labor force 4,000?', 'answer' => '5%.'],
        ['question' => 'What does the result tell me?', 'answer' => 'CBO estimates for the US have been around 4–4.5%.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="frictional" label="Frictionally unemployed" value="4000000" step="any" />
        <x-calc.field name="structural" label="Structurally unemployed" value="3000000" step="any" />
        <x-calc.field name="labor" label="Labor force" value="168000000" step="any" />
    </div>

    <x-calc.result label="Natural rate of unemployment" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['frictional' => 4000000, 'structural' => 3000000, 'labor' => 168000000],
        'Example B' => ['frictional' => 120, 'structural' => 80, 'labor' => 4000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>u* = (frictional + structural) ÷ labor force</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
