@php
    $groups = collect(config('substances'))->only(['liquids', 'cooking']);
    $substances = $groups->flatMap(fn ($group) => $group['items'])->all();
@endphp

<x-calc.page
    title="Quarts to Pounds Converter - SolveKit"
    description="Professional quarts to pounds converter for cooking and baking. Convert volume to weight using ingredient density for accurate recipe measurements."
    lede="Convert US quarts of a liquid or ingredient to pounds, or pounds back to US quarts."
    about="Weight is volume times density. A US quart is 946.35 mL, so it weighs 2.086 lb for every 1 g/mL of density. Liquids are at about 20 °C; dry ingredients use loose bulk densities, so spooned or packed measures will differ."
    :calc="['engine' => 'substance', 'volumeUnits' => config('units.volume'), 'massUnits' => config('units.mass'), 'volume' => 'qt_us', 'mass' => 'lb', 'substances' => $substances, 'rows' => ['mass' => ['oz', 'kg', 'g'], 'volume' => ['cup_us', 'l', 'ml']], 'compare' => ['water', 'milk', 'honey', 'vegetable_oil', 'flour', 'sugar', 'butter', 'rice']]"
    :how-to="[
        ['name' => 'Choose a direction', 'text' => 'Quarts to pounds, or pounds to Quarts.'],
        ['name' => 'Pick the substance', 'text' => 'Its density fills in, or type your own.'],
        ['name' => 'Enter the amount', 'text' => 'The result updates as you type.'],
    ]"
    :faqs="[
        ['question' => 'How much does a quart of water weigh?', 'answer' => 'About 2.09 lb at room temperature.'],
        ['question' => 'Why does the ingredient change the weight?', 'answer' => 'A quart is a fixed volume. Denser ingredients such as honey weigh more than light ones such as flour.'],
        ['question' => 'Are these US or imperial US quarts?', 'answer' => 'US US quarts. An imperial quart is about 20% larger.'],
    ]"
>
    <x-calc.segmented name="direction" legend="Direction" :options="['v2m' => 'Quarts → Pounds', 'm2v' => 'Pounds → Quarts']" selected="v2m" />

    <x-calc.substance :groups="$groups" selected="flour" />

    <x-calc.field name="value" label="Amount" value="2" min="0" suffix="qt" suffix-ref="value-suffix" placeholder="Enter an amount" />

    <x-calc.result label="Pounds" />

    <x-calc.options :examples="[
        'Honey 1 qt' => ['value' => 1, 'substance' => 'honey', 'direction' => 'v2m'],
        'Butter 1 lb' => ['value' => 1, 'substance' => 'butter', 'direction' => 'm2v'],
    ]" />

    <x-slot:panel>
        <x-calc.quick-ref heading="Same amount in" name="also" :generated="true" />
        <x-calc.quick-ref heading="Other substances" name="compare" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>grams = Quarts × 946.352946 mL × density (g/mL)</li>
            <li>pounds = grams ÷ 453.59237</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
