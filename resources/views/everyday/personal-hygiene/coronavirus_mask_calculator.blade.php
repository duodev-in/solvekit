<x-calc.page
    title="Coronavirus Mask Calculator - SolveKit"
    description="Free coronavirus mask calculator: how many disposable masks a household needs and what they cost, compared with reusable masks."
    lede="Work out how many face masks you need and what they cost."
    about="Masks needed = people × masks a day × days. Disposable masks are meant for single use; reusable cloth masks can be washed and reused until worn. Follow current public health advice on when masks are recommended."
    :calc="['engine' => 'ev-care', 'tool' => 'masks', 'fields' => ['people', 'per_day', 'days', 'price', 'cloth', 'cloth_price', 'cloth_days']]"
    :how-to="[
        ['name' => 'Enter people and days', 'text' => 'And masks a day each.'],
        ['name' => 'Enter prices', 'text' => 'Disposable and reusable.'],
    ]"
    :faqs="[
        ['question' => 'How many masks for a family of 4 for a month?', 'answer' => '120 disposable masks at one a day each.'],
        ['question' => 'Are reusable masks cheaper?', 'answer' => 'Usually over a few weeks: compare the figures.'],
        ['question' => 'How often should I change a disposable mask?', 'answer' => 'When it is damp, dirty or damaged, and after a day of use.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="people" label="People" value="4" min="1" step="1" />
        <x-calc.field name="per_day" label="Masks a day each" value="1" min="0.1" step="0.5" />
        <x-calc.field name="days" label="Days" value="30" min="1" step="1" />
    </div>

    <x-calc.field name="price" label="Price per disposable mask" value="0.3" min="0" step="0.01" suffix="$" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="cloth" label="Reusable masks each (optional)" value="3" min="0" step="1" />
        <x-calc.field name="cloth_price" label="Price per reusable mask" value="8" min="0" step="0.01" suffix="$" />
        <x-calc.field name="cloth_days" label="Reusable mask lasts" value="180" min="1" step="1" suffix="days" />
    </div>

    <x-calc.result label="Masks needed" />

    <x-calc.options :decimals="false" :examples="[
        'Family of 4, a month' => ['people' => 4, 'per_day' => 1, 'days' => 30, 'price' => 0.3, 'cloth' => 3, 'cloth_price' => 8, 'cloth_days' => 180],
        'Health worker' => ['people' => 1, 'per_day' => 3, 'days' => 90, 'price' => 0.6, 'cloth' => '', 'cloth_price' => '', 'cloth_days' => 180],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'cost' => ['label' => 'Cost'],
            'boxes' => ['label' => 'Boxes'],
            'reusable' => ['label' => 'Reusable instead'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>masks = people × a day × days</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
