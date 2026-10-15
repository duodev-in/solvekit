@php
    $units = config('units.density');
@endphp

<x-calc.page
    title="Density Conversion Calculator - SolveKit"
    description="Professional density conversion calculator for mass per unit volume. Convert between kg/m³, g/cm³, lb/ft³, and other density units for materials and substances."
    lede="Convert between kg/m³, g/cm³, lb/ft³, specific gravity, API gravity and other density units."
    about="Every unit converts through kg/m³. Specific gravity, API gravity and Baumé degrees compare a liquid with water at 60 °F (999.016 kg/m³); API = 141.5 ÷ SG − 131.5, and the two Baumé scales cover liquids lighter and heavier than water."
    :calc="['engine' => 'units', 'units' => $units, 'list' => array_keys($units)]"
    :how-to="[
        ['name' => 'Enter a density', 'text' => 'Type the amount you want to convert.'],
        ['name' => 'Choose the units', 'text' => 'Pick the unit you have and the unit you want, or swap them.'],
        ['name' => 'Read or copy the result', 'text' => 'Every other unit is listed beside the result. Click a row to copy it.'],
    ]"
    :faqs="[
        ['question' => 'Are g/cm³, g/mL and kg/L the same?', 'answer' => 'Yes. 1 g/cm³ = 1 g/mL = 1 kg/L = 1,000 kg/m³.'],
        ['question' => 'What is API gravity?', 'answer' => 'A petroleum scale: API = 141.5 ÷ SG − 131.5. Water is 10 °API; light crude is above 31.1 °API.'],
        ['question' => 'How dense is water?', 'answer' => 'About 1,000 kg/m³ (999.97 at 4 °C, 998.2 at 20 °C).'],
    ]"
>
    <x-calc.unit-pair :units="$units" from="gcm3" to="lbft3" value="1" label="Density" />

    <x-calc.result label="Pounds per cubic foot">
        <p class="text-xs text-slate-500" data-ref="ratio"></p>
    </x-calc.result>

    <x-calc.options :examples="[
        'Water 1 g/cm³' => ['value' => 1, 'from' => 'gcm3'],
        'Light crude 35 °API' => ['value' => 35, 'from' => 'api'],
        'Steel 7,850 kg/m³' => ['value' => 7850, 'from' => 'kgm3'],
    ]" />

    <x-slot:panel>
        <x-calc.unit-list :units="$units" heading="1 g/cm³ in other units" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>1 g/cm³ = 1,000 kg/m³</li>
            <li>1 lb/ft³ = 16.018 kg/m³</li>
            <li>SG = 141.5 ÷ (API + 131.5)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
