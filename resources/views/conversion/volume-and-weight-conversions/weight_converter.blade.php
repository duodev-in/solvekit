@php
    $units = config('units.mass');
@endphp

<x-calc.page
    title="Weight Converter - SolveKit"
    description="Professional weight converter to convert between grams, pounds, kilograms, ounces, and other weight units. Fast and accurate conversions."
    lede="Convert between metric and imperial weight units."
    about="Every unit converts through the gram. The pound is defined as exactly 0.45359237 kg and the ounce as 1/16 lb, so imperial and metric results are exact to the precision shown."
    :calc="['engine' => 'units', 'units' => $units, 'list' => array_keys($units), 'min' => 0]"
    :how-to="[
        ['name' => 'Enter a weight', 'text' => 'Type the amount you want to convert.'],
        ['name' => 'Choose the units', 'text' => 'Pick the unit you have and the unit you want, or swap them.'],
        ['name' => 'Read or copy the result', 'text' => 'Every other unit is listed beside the result. Click a row to copy it.'],
    ]"
    :faqs="[
        ['question' => 'How many pounds are in a kilogram?', 'answer' => 'One kilogram is 2.20462 pounds. A pound is exactly 0.45359237 kg.'],
        ['question' => 'How many grams are in an ounce?', 'answer' => 'One ounce is exactly 28.349523125 grams.'],
        ['question' => 'What is the difference between a US ton, a long ton and a metric ton?', 'answer' => 'A US (short) ton is 2,000 lb, a long ton is 2,240 lb and a metric ton is 1,000 kg (about 2,204.6 lb).'],
        ['question' => 'How much is a stone?', 'answer' => 'A stone is 14 pounds, about 6.35 kg. It is still used for body weight in the UK and Ireland.'],
    ]"
>
    <x-calc.unit-pair :units="$units" from="lb" to="kg" value="150" min="0" label="Weight" />

    <x-calc.result label="Kilograms">
        <p class="text-xs text-slate-500" data-ref="ratio"></p>
    </x-calc.result>

    <x-calc.options :examples="[
        'Bag of sugar 1 kg' => ['value' => 1, 'from' => 'kg'],
        'Body weight 11 st' => ['value' => 11, 'from' => 'st'],
        'Letter 0.5 oz' => ['value' => 0.5, 'from' => 'oz'],
    ]" />

    <x-slot:panel>
        <x-calc.unit-list :units="$units" heading="150 lb in other units" />
    </x-slot:panel>

    <x-slot:formula>
        <p class="font-mono text-slate-800">result = value × (from unit in grams) ÷ (to unit in grams)</p>
        <ul class="grid grid-cols-2 gap-x-6 gap-y-1 font-mono text-[13px]">
            <li>1 oz = 28.349523125 g</li>
            <li>1 lb = 453.59237 g</li>
            <li>1 st = 14 lb</li>
            <li>1 US ton = 2,000 lb</li>
            <li>1 long ton = 2,240 lb</li>
            <li>1 t = 1,000 kg</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
