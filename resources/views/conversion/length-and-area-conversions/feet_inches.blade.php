<x-calc.page
    title="Feet &amp; Inches Calculator - SolveKit"
    description="Professional feet and inches calculator to convert imperial measurements to metric units. Convert feet and inches to centimeters, meters, and total inches."
    lede="Convert a feet-and-inches measurement to centimeters, meters and total inches."
    about="Feet are multiplied by 12 and added to the inches to get a total in inches. An inch is exactly 2.54 cm, so the total is multiplied by 2.54 for centimeters. Inches over 11 simply carry into feet."
    :calc="['engine' => 'feet-inches']"
    :how-to="[
        ['name' => 'Enter feet and inches', 'text' => 'Fill in either field or both, e.g. 5 ft 9 in.'],
        ['name' => 'Read the metric result', 'text' => 'Centimeters are shown first; meters, millimeters and decimal feet are listed beside it.'],
    ]"
    :faqs="[
        ['question' => 'How many centimeters is 5 feet 9 inches?', 'answer' => '5 ft 9 in is 69 inches, which is 175.26 cm.'],
        ['question' => 'How many centimeters are in an inch?', 'answer' => 'Exactly 2.54 cm, by international definition since 1959.'],
        ['question' => 'Can I enter more than 11 inches?', 'answer' => 'Yes. Extra inches carry into feet, so 4 ft 18 in is treated as 5 ft 6 in.'],
    ]"
>
    <div class="grid grid-cols-2 gap-3">
        <x-calc.field name="feet" label="Feet" value="5" min="0" suffix="ft" placeholder="Feet" />
        <x-calc.field name="inches" label="Inches" value="9" min="0" suffix="in" placeholder="Inches" />
    </div>

    <x-calc.result label="Centimeters" />

    <x-calc.options :examples="[
        '5 ft 4 in' => ['feet' => 5, 'inches' => 4],
        '6 ft' => ['feet' => 6, 'inches' => 0],
        '8 ft ceiling' => ['feet' => 8, 'inches' => 0],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Same length in" :rows="[
            'inches' => ['label' => 'Total inches', 'unit' => 'in'],
            'meters' => ['label' => 'Meters', 'unit' => 'm'],
            'millimeters' => ['label' => 'Millimeters', 'unit' => 'mm'],
            'feet' => ['label' => 'Decimal feet', 'unit' => 'ft'],
            'yards' => ['label' => 'Yards', 'unit' => 'yd'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>total inches = feet × 12 + inches</li>
            <li>centimeters = total inches × 2.54</li>
            <li>meters = centimeters ÷ 100</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
