<x-calc.page
    title="Average Rating Calculator - SolveKit"
    description="Free average rating calculator: the star rating from counts of 1–5 star reviews, and how many 5-star reviews reach a target."
    lede="Find an average star rating."
    about="An average rating is a weighted mean: each star level times its count, divided by the number of ratings."
    :calc="['engine' => 'st-desc', 'tool' => 'avg_rating', 'fields' => ['s5', 's4', 's3', 's2', 's1', 'target'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is the example’s average rating?', 'answer' => '4.234.'],
        ['question' => 'How many more 5-star ratings reach 4.5?', 'answer' => '109.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="s5" label="5-star ratings" value="120" min="0" step="any" />
        <x-calc.field name="s4" label="4-star ratings" value="45" min="0" step="any" />
        <x-calc.field name="s3" label="3-star ratings" value="20" min="0" step="any" />
        <x-calc.field name="s2" label="2-star ratings" value="8" min="0" step="any" />
        <x-calc.field name="s1" label="1-star ratings" value="12" min="0" step="any" />
        <x-calc.field name="target" label="Target average (optional)" value="4.5" min="1" step="any" />
    </div>

    <x-calc.result label="Average rating" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['s5' => 120, 's4' => 45, 's3' => 20, 's2' => 8, 's1' => 12, 'target' => 4.5],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Ratings by stars" name="bars" />
        <x-calc.rows heading="Details" :rows="[
            'total' => ['label' => 'Ratings'],
            'share5' => ['label' => 'Share of 5-star'],
            'need' => ['label' => '5-star ratings needed for the target'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
