<x-calc.page
    title="Period Products Cost Calculator - SolveKit"
    description="Free period products cost calculator: the yearly and lifetime cost of pads and tampons, compared with a reusable menstrual cup."
    lede="Work out what period products cost over a year and a lifetime."
    about="Products a year = products a day × period days × periods a year (about 13 for a 28-day cycle). Lifetime cost multiplies by the years left. Menstrual cups can last up to about 10 years, depending on the maker."
    :calc="['engine' => 'ev-home', 'tool' => 'period', 'fields' => ['per_day', 'days', 'cycles', 'price', 'years', 'cup_price', 'cup_life']]"
    :how-to="[
        ['name' => 'Enter your use', 'text' => 'Products a day and days a period.'],
        ['name' => 'Enter the price', 'text' => 'Pack price ÷ products in the pack.'],
    ]"
    :faqs="[
        ['question' => 'How many tampons or pads a year?', 'answer' => 'About 260 at 4 a day for 5 days, 13 times a year.'],
        ['question' => 'How much over a lifetime?', 'answer' => 'About $2,275 at 25¢ each over 35 years.'],
        ['question' => 'Is a cup cheaper?', 'answer' => 'Usually: $120 over 35 years for four $30 cups.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="per_day" label="Products a day" value="4" min="0" step="1" />
        <x-calc.field name="days" label="Days a period" value="5" min="1" step="1" />
        <x-calc.field name="cycles" label="Periods a year" value="13" min="1" max="16" step="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="price" label="Price per product" value="0.25" min="0" step="0.01" suffix="$" />
        <x-calc.field name="years" label="Years" value="35" min="1" step="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="cup_price" label="Menstrual cup price (optional)" value="30" min="0" step="0.01" suffix="$" />
        <x-calc.field name="cup_life" label="Cup lasts" value="10" min="1" step="1" suffix="years" />
    </div>

    <x-calc.result label="Cost a year" />

    <x-calc.options :decimals="false" :examples="[
        '4 a day, 25¢' => ['per_day' => 4, 'days' => 5, 'cycles' => 13, 'price' => 0.25, 'years' => 35, 'cup_price' => 30, 'cup_life' => 10],
        'Heavier flow' => ['per_day' => 6, 'days' => 6, 'cycles' => 13, 'price' => 0.3, 'years' => 30, 'cup_price' => 35, 'cup_life' => 8],
        'One year only' => ['per_day' => 3, 'days' => 5, 'cycles' => 12, 'price' => 0.2, 'years' => 1, 'cup_price' => '', 'cup_life' => 10],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'lifetime' => ['label' => 'Lifetime'],
            'cup' => ['label' => 'Reusable cup'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>products = a day × days × periods</li>
            <li>cost = products × price</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
