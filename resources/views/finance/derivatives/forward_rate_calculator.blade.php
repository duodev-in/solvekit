<x-calc.page
    title="Forward Rate Calculator - SolveKit"
    description="Free Forward Rate Calculator: f = [(1 + r₂)^t₂ ÷ (1 + r₁)^t₁]^(1/(t₂ − t₁)) − 1. The implied forward rate is the rate between two future dates locked in by today's spot rates (annual compounding)."
    lede="Work out the forward rate from your figures."
    about="The implied forward rate is the rate between two future dates locked in by today's spot rates (annual compounding). Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'forward_rate', 'fields' => ['r1', 't1', 'r2', 't2']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Spot rate for the shorter term, Shorter term, Spot rate for the longer term, Longer term.'],
        ['name' => 'Read the result', 'text' => 'The forward rate appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the forward rate?', 'answer' => 'F = [(1 + r₂)^t₂ ÷ (1 + r₁)^t₁]^(1/(t₂ − t₁)) − 1.'],
        ['question' => 'What is the forward rate for spot rate for the shorter term 4%, shorter term 1 years, spot rate for the longer term 4.5%, longer term 2 years?', 'answer' => '5.002%.'],
        ['question' => 'And for spot rate for the shorter term 5%, shorter term 0.5 years, spot rate for the longer term 4.6%, longer term 1 years?', 'answer' => '4.202%.'],
        ['question' => 'What does the result tell me?', 'answer' => 'With an upward-sloping curve, forward rates are above spot rates.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="r1" label="Spot rate for the shorter term" value="4" step="any" suffix="%" />
        <x-calc.field name="t1" label="Shorter term" value="1" min="0" step="any" suffix="years" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="r2" label="Spot rate for the longer term" value="4.5" step="any" suffix="%" />
        <x-calc.field name="t2" label="Longer term" value="2" min="0" step="any" suffix="years" />
    </div>

    <x-calc.result label="Forward rate" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['r1' => 4, 't1' => 1, 'r2' => 4.5, 't2' => 2],
        'Example B' => ['r1' => 5, 't1' => 0.5, 'r2' => 4.6, 't2' => 1],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>f = [(1 + r₂)^t₂ ÷ (1 + r₁)^t₁]^(1/(t₂ − t₁)) − 1</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
