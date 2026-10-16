<x-calc.page
    title="Crude Protein Calculator - SolveKit"
    description="Free crude protein calculator: protein from Kjeldahl or Dumas nitrogen with FAO nitrogen-to-protein (Jones) factors."
    lede="Work out crude protein from nitrogen content."
    about="Crude protein = nitrogen × a conversion factor. The general factor is 6.25; specific Jones factors for foods are from FAO's Food energy: methods of analysis (2003), Table 2.1. Using 6.25 for every food can be off by −2% to +9%."
    :calc="['engine' => 'chem-organic', 'tool' => 'crude_protein', 'fields' => ['food', 'nitrogen', 'factor'], 'data' => ['jones' => config('chemistry_data.jones')]]"
    :how-to="[
        ['name' => 'Enter the nitrogen', 'text' => 'From Kjeldahl or Dumas analysis.'],
        ['name' => 'Pick the food', 'text' => 'For its specific factor.'],
    ]"
    :faqs="[
        ['question' => 'Why multiply by 6.25?', 'answer' => 'Average protein is about 16% nitrogen, and 100 ÷ 16 = 6.25.'],
        ['question' => 'Why do factors differ?', 'answer' => 'Proteins in milk, wheat and nuts contain different amounts of nitrogen.'],
        ['question' => 'Is crude protein the true protein?', 'answer' => 'Not exactly; non-protein nitrogen is counted too.'],
    ]"
>
    <x-calc.select name="food" label="Food" :options="collect(config('chemistry_data.jones'))->map(fn ($j) => $j['name'].' ('.$j['factor'].')')->put('custom', 'Custom factor')->all()" selected="general" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="nitrogen" label="Nitrogen" value="2.5" min="0" max="30" suffix="%" />
        <div data-show-when="food:custom" hidden>
            <x-calc.field name="factor" label="Factor" value="6.25" min="0" />
        </div>
    </div>

    <x-calc.result label="Crude protein" />

    <x-calc.options :examples="[
        'General 2.5% N' => ['food' => 'general', 'nitrogen' => 2.5],
        'Milk 0.5% N' => ['food' => 'milk', 'nitrogen' => 0.5],
        'Soybean 6% N' => ['food' => 'beans_soybean', 'nitrogen' => 6],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'factor' => ['label' => 'Factor used'],
            'general' => ['label' => 'With 6.25'],
            'per100' => ['label' => 'Per 100 g'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>crude protein = N × factor</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
