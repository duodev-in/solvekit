<x-calc.page
    title="Height in Inches Calculator - SolveKit"
    description="Professional height calculator to convert inches to feet and inches, centimeters, and meters. Perfect for height conversions and human measurements."
    lede="Convert a height in inches to feet and inches, centimeters and meters."
    about="Inches are divided by 12: the whole number is feet and the remainder is inches. The value is rounded to a tenth of an inch first, so a height never reads as 12 inches. One inch is exactly 2.54 cm."
    :calc="['engine' => 'height-in-inches']"
    :how-to="[
        ['name' => 'Enter a height in inches', 'text' => 'Any value from 0 to 120 inches.'],
        ['name' => 'Read the result', 'text' => 'Feet and inches are shown first, with centimeters and meters beside it.'],
    ]"
    :faqs="[
        ['question' => 'How tall is 70 inches?', 'answer' => '70 inches is 5 feet 10 inches, or 177.8 cm.'],
        ['question' => 'How many inches is 6 feet?', 'answer' => '6 feet is 72 inches, or 182.88 cm.'],
        ['question' => 'How are inches converted to centimeters?', 'answer' => 'Multiply by 2.54. One inch is exactly 2.54 cm.'],
    ]"
>
    <x-calc.field name="value" label="Height" value="69" min="0" max="120" suffix="in" placeholder="Height in inches" help="Between 0 and 120 inches." />

    <x-calc.result label="Feet and inches" />

    <x-calc.options :decimals="true" :examples="[
        '5 ft (60 in)' => ['value' => 60],
        '5 ft 6 in (66 in)' => ['value' => 66],
        '6 ft 2 in (74 in)' => ['value' => 74],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Same height in" :rows="[
            'cm' => ['label' => 'Centimeters', 'unit' => 'cm'],
            'm' => ['label' => 'Meters', 'unit' => 'm'],
            'ft' => ['label' => 'Decimal feet', 'unit' => 'ft'],
        ]" />
        <x-calc.quick-ref heading="Common heights" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>feet = whole part of (inches ÷ 12)</li>
            <li>remaining inches = inches − feet × 12</li>
            <li>centimeters = inches × 2.54</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
