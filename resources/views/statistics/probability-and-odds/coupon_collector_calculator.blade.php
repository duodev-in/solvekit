<x-calc.page
    title="Coupon Collector Calculator - SolveKit"
    description="Free coupon collector calculator: the expected number of draws to collect every item of a set, and the chance of finishing within a budget."
    lede="Find draws to complete a set."
    about="Collecting a full set of n random items takes about n ln n draws on average, because the last few items are rare to find."
    :calc="['engine' => 'st-prob', 'tool' => 'coupon', 'fields' => ['n', 'have', 'draws'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'How many draws complete a set of 50?', 'answer' => 'About 224.96 on average.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="n" label="Different items in the set" value="50" min="1" step="any" />
        <x-calc.field name="have" label="Different items already collected" value="0" min="0" step="any" />
        <x-calc.field name="draws" label="Draws you can make (optional)" value="200" min="0" step="any" />
    </div>

    <x-calc.result label="Expected draws to complete the set" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['n' => 50, 'have' => 0, 'draws' => 200],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'within' => ['label' => 'P(complete within your draws)'],
            'sd' => ['label' => 'Standard deviation of draws'],
            'last' => ['label' => 'Expected draws for the last item'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
