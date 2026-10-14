<x-calc.page
    title="Pounds and Ounces Converter - SolveKit"
    description="Professional pounds and ounces converter for imperial weight measurements. Convert between pounds, ounces, and metric units with precision."
    lede="Convert a weight in pounds and ounces to kilograms, grams and stone."
    about="Pounds are multiplied by 16 and added to the ounces for a total in ounces. An ounce is exactly 28.349523125 g, so the total converts straight to grams and kilograms. Ounces over 15 carry into pounds."
    :calc="['engine' => 'pounds-ounces']"
    :how-to="[
        ['name' => 'Enter pounds and ounces', 'text' => 'Fill in either field or both, e.g. a baby weighing 7 lb 8 oz.'],
        ['name' => 'Read the result', 'text' => 'Kilograms are shown first, with grams, total ounces and stone beside them.'],
    ]"
    :faqs="[
        ['question' => 'How many ounces are in a pound?', 'answer' => 'Sixteen.'],
        ['question' => 'What is 7 lb 8 oz in kilograms?', 'answer' => '3.402 kg.'],
        ['question' => 'How many pounds are in a stone?', 'answer' => 'Fourteen. 11 st 6 lb is 160 lb, about 72.6 kg.'],
    ]"
>
    <div class="grid grid-cols-2 gap-3">
        <x-calc.field name="pounds" label="Pounds" value="7" min="0" suffix="lb" placeholder="Pounds" />
        <x-calc.field name="ounces" label="Ounces" value="8" min="0" suffix="oz" placeholder="Ounces" />
    </div>

    <x-calc.result label="Kilograms" />

    <x-calc.options :examples="[
        'Newborn 7 lb 8 oz' => ['pounds' => 7, 'ounces' => 8],
        'Turkey 14 lb' => ['pounds' => 14, 'ounces' => 0],
        'Parcel 2 lb 12 oz' => ['pounds' => 2, 'ounces' => 12],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Same weight in" :rows="[
            'g' => ['label' => 'Grams', 'unit' => 'g'],
            'oz' => ['label' => 'Total ounces', 'unit' => 'oz'],
            'lb' => ['label' => 'Decimal pounds', 'unit' => 'lb'],
            'st' => ['label' => 'Stone and pounds', 'unit' => ''],
            't' => ['label' => 'Metric tons', 'unit' => 't'],
        ]" />
        <x-calc.steps />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>total ounces = pounds × 16 + ounces</li>
            <li>grams = total ounces × 28.349523125</li>
            <li>1 st = 14 lb</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
