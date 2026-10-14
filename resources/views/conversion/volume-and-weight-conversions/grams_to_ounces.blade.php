@php
    $units = config('units.mass');
@endphp

<x-calc.page
    title="Grams to Ounces Converter - SolveKit"
    description="Professional grams to ounces converter for metric to imperial weight conversions. Convert grams (g) to ounces (oz) with precision for cooking and measurements."
    lede="Convert grams to ounces, or ounces to grams."
    about="An avoirdupois ounce is exactly 28.349523125 grams, so grams are divided by that number to get ounces and ounces are multiplied by it to get grams."
    :calc="['engine' => 'units', 'units' => $units, 'list' => ['lb', 'kg', 'mg'], 'quickRef' => ['g:oz' => [1, 10, 50, 100, 250, 500, 1000], 'oz:g' => [0.5, 1, 2, 4, 8, 12, 16]], 'min' => 0]"
    :how-to="[
        ['name' => 'Choose a direction', 'text' => 'Grams to ounces, or ounces to grams.'],
        ['name' => 'Enter the weight', 'text' => 'The result, pounds and kilograms update as you type.'],
    ]"
    :faqs="[
        ['question' => 'How many grams are in an ounce?', 'answer' => 'One ounce is 28.3495 grams.'],
        ['question' => 'How many ounces is 100 grams?', 'answer' => '100 g is 3.527 oz.'],
        ['question' => 'Is this the same ounce used for gold?', 'answer' => 'No. Precious metals use the troy ounce, 31.1035 g. This converter uses the everyday avoirdupois ounce.'],
        ['question' => 'Can I convert grams to fluid ounces?', 'answer' => 'Only with a density, because fluid ounces measure volume. Use the mg to mL or Gallons to Pounds tools for that.'],
    ]"
>
    <x-calc.segmented name="direction" legend="Direction" :options="['g:oz' => 'Grams → Ounces', 'oz:g' => 'Ounces → Grams']" selected="g:oz" />

    <x-calc.field name="value" label="Weight" value="250" min="0" suffix="g" suffix-ref="value-suffix" placeholder="Enter a weight" />

    <x-calc.result label="Ounces" />

    <x-calc.options :examples="[
        'Chocolate bar 100 g' => ['value' => 100, 'direction' => 'g:oz'],
        'Steak 8 oz' => ['value' => 8, 'direction' => 'oz:g'],
    ]" />

    <x-slot:panel>
        <x-calc.unit-list :grow="false" :units="$units" :keys="['lb', 'kg', 'mg']" heading="250 g in other units" />
        <x-calc.quick-ref />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>ounces = grams ÷ 28.349523125</li>
            <li>grams = ounces × 28.349523125</li>
            <li>1 lb = 16 oz = 453.59237 g</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
