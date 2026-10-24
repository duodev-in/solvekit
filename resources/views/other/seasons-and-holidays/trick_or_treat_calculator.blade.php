<x-calc.page
    title="Trick-or-Treat Calculator - SolveKit"
    description="Free trick-or-treat calculator: candy and bags to buy for Halloween visitors."
    lede="Plan Halloween candy."
    about="Multiply the expected visitors by the pieces each, and add a little spare."
    :calc="['engine' => 'ot-misc', 'tool' => 'trick_treat', 'fields' => ['visitors', 'pieces', 'perBag', 'bagPrice', 'spare'], 'data' => ['units' => collect(config('units'))->only([])->all()], 'currency' => 'USD']"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'How many bags for 80 trick-or-treaters?', 'answer' => '2.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="visitors" label="Expected trick-or-treaters" value="80" min="0" step="any" />
        <x-calc.field name="pieces" label="Pieces per child" value="2" min="1" step="any" />
        <x-calc.field name="perBag" label="Pieces in one bag of candy" value="100" min="1" step="any" />
        <x-calc.field name="bagPrice" label="Price per bag" value="12" min="0" step="any" suffix="$" />
        <x-calc.field name="spare" label="Spare (%)" value="15" min="0" step="any" />
    </div>

    <x-calc.result label="Bags to buy" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['visitors' => 80, 'pieces' => 2, 'perBag' => 100, 'bagPrice' => 12, 'spare' => 15],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'pieces' => ['label' => 'Pieces needed'],
            'cost' => ['label' => 'Cost'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
