@php
    $units = config('units.volume');
    $listed = ['gal_us', 'gal_uk', 'l', 'qt_us', 'pt_us', 'cup_us', 'floz_us', 'qt_uk', 'pt_uk', 'm3', 'ft3', 'in3'];
@endphp

<x-calc.page
    title="Gallon Calculator - SolveKit"
    description="Professional gallon calculator to convert liters, quarts, pints, and fluid ounces to gallons. Comprehensive gallon conversions for all your needs."
    lede="Convert liters, quarts, pints and other volumes to US or imperial gallons."
    about="Pick US gallons (3.785 L) or imperial gallons (4.546 L) as the target. Every volume converts through the liter, and the panel lists the same amount in both gallon systems and their smaller units."
    :calc="['engine' => 'units', 'units' => $units, 'list' => $listed, 'min' => 0]"
    :how-to="[
        ['name' => 'Enter a volume', 'text' => 'Type the amount and choose its unit.'],
        ['name' => 'Choose US or imperial gallons', 'text' => 'Set the target to US gallons or imperial gallons.'],
    ]"
    :faqs="[
        ['question' => 'How many quarts are in a gallon?', 'answer' => 'Four. Both US and imperial gallons hold 4 quarts, 8 pints, but the imperial units are about 20% larger.'],
        ['question' => 'How many fluid ounces are in a gallon?', 'answer' => 'A US gallon is 128 US fl oz. An imperial gallon is 160 imperial fl oz.'],
        ['question' => 'How much bigger is an imperial gallon?', 'answer' => 'An imperial gallon is 1.20095 US gallons.'],
    ]"
>
    <x-calc.unit-pair :units="$units" from="l" to="gal_us" value="20" min="0" label="Volume" />

    <x-calc.result label="US gallons">
        <p class="text-xs text-slate-500" data-ref="ratio"></p>
    </x-calc.result>

    <x-calc.options :examples="[
        'Fuel tank 50 L' => ['value' => 50, 'from' => 'l'],
        'Paint 3 qt' => ['value' => 3, 'from' => 'qt_us'],
        'Milk 4 imp pt' => ['value' => 4, 'from' => 'pt_uk'],
    ]" />

    <x-slot:panel>
        <x-calc.unit-list :units="$units" :keys="$listed" heading="20 L in other units" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>US gallons = liters ÷ 3.785411784</li>
            <li>imperial gallons = liters ÷ 4.54609</li>
            <li>1 gal = 4 qt = 8 pt (in either system)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
