<x-calc.page
    title="Hamming Distance Calculator - SolveKit"
    description="Free Hamming distance calculator: the number of positions where two equal-length strings differ."
    lede="Find the Hamming distance."
    about="Hamming distance counts the positions where two strings of the same length differ."
    :calc="['engine' => 'tc-text', 'tool' => 'hamming_distance', 'fields' => ['a', 'b'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What is the distance between 1011101 and 1001001?', 'answer' => '2.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="a" label="First string" value="1011101" type="text" inputmode="text" />
        <x-calc.field name="b" label="Second string" value="1001001" type="text" inputmode="text" />
    </div>

    <x-calc.result label="Hamming distance" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => '1011101', 'b' => '1001001'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'positions' => ['label' => 'Positions that differ'],
            'length' => ['label' => 'Length'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
