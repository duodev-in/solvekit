<x-calc.page
    title="Margin and Markup Calculator - SolveKit"
    description="Free Margin and Markup Calculator: markup = margin ÷ (1 − margin). Converts a margin to the matching markup (and shows the reverse)."
    lede="Work out the equivalent markup from the margin."
    about="Converts a margin to the matching markup (and shows the reverse). Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'margin_and_markup', 'fields' => ['margin']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Margin.'],
        ['name' => 'Read the result', 'text' => 'The equivalent markup appears as you type, with if this were a markup, the margin would be below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the equivalent markup?', 'answer' => 'Markup = margin ÷ (1 − margin); margin = markup ÷ (1 + markup).'],
        ['question' => 'What is the equivalent markup for margin 30%?', 'answer' => '42.86%. If this were a markup, the margin would be: 23.08%.'],
        ['question' => 'And for margin 50%?', 'answer' => '100%. If this were a markup, the margin would be: 33.33%.'],
        ['question' => 'What does the result tell me?', 'answer' => '30% margin = 42.9% markup.'],
    ]"
>
    <x-calc.field name="margin" label="Margin" value="30" step="any" suffix="%" />

    <x-calc.result label="Equivalent markup" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['margin' => 30],
        'Example B' => ['margin' => 50],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'If this were a markup, the margin would be'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>markup = margin ÷ (1 − margin)</li>
            <li>margin = markup ÷ (1 + markup)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
