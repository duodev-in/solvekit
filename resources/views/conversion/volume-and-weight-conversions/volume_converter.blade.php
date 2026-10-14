@php
    $units = config('units.volume');
@endphp

<x-calc.page
    title="Volume Converter - SolveKit"
    description="Professional volume converter to convert between liters, gallons, cubic units, and other volume measurements. Fast and accurate conversions."
    lede="Convert between metric, US, imperial and cubic volume units."
    about="Every unit converts through the liter. US and imperial units have different sizes: a US gallon is exactly 3.785411784 L and an imperial gallon is exactly 4.54609 L, so pick the system your recipe or label uses."
    :calc="['engine' => 'units', 'units' => $units, 'list' => array_keys($units), 'min' => 0]"
    :how-to="[
        ['name' => 'Enter a volume', 'text' => 'Type the amount you want to convert.'],
        ['name' => 'Choose the units', 'text' => 'Pick the unit you have and the unit you want. US and imperial units are listed separately.'],
        ['name' => 'Read or copy the result', 'text' => 'Every other unit is listed beside the result. Click a row to copy it.'],
    ]"
    :faqs="[
        ['question' => 'How many liters are in a gallon?', 'answer' => 'A US gallon is 3.785 L. An imperial (UK) gallon is 4.546 L.'],
        ['question' => 'How many cups are in a liter?', 'answer' => 'One liter is 4.227 US cups or 4 metric cups.'],
        ['question' => 'How many gallons are in a cubic foot?', 'answer' => 'One cubic foot is 7.48052 US gallons, or 28.317 liters.'],
        ['question' => 'Is a US fluid ounce the same as an imperial one?', 'answer' => 'No. A US fluid ounce is 29.574 mL and an imperial fluid ounce is 28.413 mL.'],
    ]"
>
    <x-calc.unit-pair :units="$units" from="gal_us" to="l" value="5" min="0" label="Volume" />

    <x-calc.result label="Liters">
        <p class="text-xs text-slate-500" data-ref="ratio"></p>
    </x-calc.result>

    <x-calc.options :examples="[
        'Soda can 12 fl oz' => ['value' => 12, 'from' => 'floz_us'],
        'Bathtub 80 gal' => ['value' => 80, 'from' => 'gal_us'],
        'Pint of beer (UK)' => ['value' => 1, 'from' => 'pt_uk'],
    ]" />

    <x-slot:panel>
        <x-calc.unit-list :units="$units" heading="5 gal in other units" />
    </x-slot:panel>

    <x-slot:formula>
        <p class="font-mono text-slate-800">result = value × (from unit in liters) ÷ (to unit in liters)</p>
        <ul class="grid grid-cols-2 gap-x-6 gap-y-1 font-mono text-[13px]">
            <li>1 US gal = 231 in³ = 3.785411784 L</li>
            <li>1 imp gal = 4.54609 L</li>
            <li>1 US gal = 4 qt = 8 pt = 16 cups</li>
            <li>1 US cup = 8 US fl oz</li>
            <li>1 ft³ = 28.316846592 L</li>
            <li>1 m³ = 1,000 L</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
