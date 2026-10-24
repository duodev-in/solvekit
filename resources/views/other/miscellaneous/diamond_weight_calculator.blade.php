<x-calc.page
    title="Diamond Weight Calculator - SolveKit"
    description="Free diamond weight calculator: estimated carat weight of a round diamond from its measurements."
    lede="Estimate a diamond’s carat weight."
    about="A diamond’s weight can be estimated from its dimensions and a shape factor. Also known as Carat Weight Calculator, Diamond Carat Calculator and mm to carat conversion."
    :calc="['engine' => 'ot-misc', 'tool' => 'diamond_weight', 'fields' => ['shape', 'diameter', 'width', 'depth', 'factor'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What does a 6.5 mm round diamond, 4 mm deep, weigh?', 'answer' => 'About 1.031 ct.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="shape" label="Shape" :options="['round' => 'Round brilliant (factor 0.0061)', 'custom' => 'Other shape (enter your factor)']" selected="round" />
        <x-calc.field name="diameter" label="Average diameter or length (mm)" value="6.5" min="0" step="any" />
        <div data-show-when="shape:custom">
            <x-calc.field name="width" label="Width (mm, other shapes)" value="6.5" min="0" step="any" />
        </div>
        <x-calc.field name="depth" label="Depth (mm)" value="4" min="0" step="any" />
        <div data-show-when="shape:custom">
            <x-calc.field name="factor" label="Shape factor" value="0.0062" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Estimated weight" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['shape' => 'round', 'diameter' => 6.5, 'width' => 6.5, 'depth' => 4, 'factor' => 0.0062],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'grams' => ['label' => 'In grams'],
            'points' => ['label' => 'In points'],
            'note' => ['label' => 'Accuracy'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
