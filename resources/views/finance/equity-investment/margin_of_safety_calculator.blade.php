<x-calc.page
    title="Margin of Safety Calculator - SolveKit"
    description="Free Margin of Safety Calculator: MOS = (intrinsic value − price) ÷ intrinsic value. Margin of safety is how far the price is below your estimate of value, a cushion against errors."
    lede="Work out the margin of safety from intrinsic value per share and market price."
    about="Margin of safety is how far the price is below your estimate of value, a cushion against errors. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'margin_of_safety', 'fields' => ['value', 'price']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Intrinsic value per share, Market price.'],
        ['name' => 'Read the result', 'text' => 'The margin of safety appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the margin of safety?', 'answer' => 'MOS = (intrinsic value − price) ÷ intrinsic value.'],
        ['question' => 'What is the margin of safety for intrinsic value per share $80, market price $60?', 'answer' => '25%.'],
        ['question' => 'And for intrinsic value per share $45, market price $41?', 'answer' => '8.889%.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Value investors often look for 25–50%.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="value" label="Intrinsic value per share" value="80" step="0.01" suffix="$" />
        <x-calc.field name="price" label="Market price" value="60" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Margin of safety" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['value' => 80, 'price' => 60],
        'Example B' => ['value' => 45, 'price' => 41],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>MOS = (intrinsic value − price) ÷ intrinsic value</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
