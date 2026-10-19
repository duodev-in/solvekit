<x-calc.page
    title="Taylor Rule Calculator - SolveKit"
    description="Free Taylor Rule Calculator: i = r* + π + 0.5(π − π*) + 0.5(y − y*) (Taylor, 1993). The Taylor rule suggests a central bank policy rate from inflation and the output gap."
    lede="Work out the policy rate from your figures."
    about="The Taylor rule suggests a central bank policy rate from inflation and the output gap. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'taylor_rule', 'fields' => ['neutral', 'inflation', 'target', 'gap']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Neutral real rate (r*), Inflation, Inflation target, Output gap.'],
        ['name' => 'Read the result', 'text' => 'The policy rate appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the policy rate?', 'answer' => 'I = r* + π + 0.5(π − π*) + 0.5(y − y*) (Taylor, 1993).'],
        ['question' => 'What is the policy rate for neutral real rate 1%, inflation 3%, inflation target 2%, output gap 0.5%?', 'answer' => '4.75%.'],
        ['question' => 'And for neutral real rate 0.5%, inflation 2.2%, inflation target 2%, output gap -1%?', 'answer' => '2.3%.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Central banks use it as a guide, not a formula.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="neutral" label="Neutral real rate (r*)" value="1" step="any" suffix="%" />
        <x-calc.field name="inflation" label="Inflation" value="3" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="target" label="Inflation target" value="2" step="any" suffix="%" />
        <x-calc.field name="gap" label="Output gap" value="0.5" step="any" suffix="%" />
    </div>

    <x-calc.result label="Policy rate" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['neutral' => 1, 'inflation' => 3, 'target' => 2, 'gap' => 0.5],
        'Example B' => ['neutral' => 0.5, 'inflation' => 2.2, 'target' => 2, 'gap' => -1],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>i = r* + π + 0.5(π − π*) + 0.5(y − y*) (Taylor, 1993)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
