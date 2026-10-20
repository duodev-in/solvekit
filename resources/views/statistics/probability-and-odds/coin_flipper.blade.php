<x-calc.page
    title="Coin Flipper - SolveKit"
    description="Free online coin flipper: flip one coin or thousands with fair cryptographic randomness, with counts and the longest streak."
    lede="Flip coins."
    about="Each flip uses the browser’s cryptographic random source, so heads and tails are exactly equally likely. Change any value to flip again."
    :calc="['engine' => 'st-prob', 'tool' => 'coin_flipper', 'fields' => ['flips'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'Is the coin flipper fair?', 'answer' => 'Yes. It uses unbiased cryptographic random numbers, not a predictable formula.'],
    ]"
>
    <x-calc.field name="flips" label="Number of flips" value="10" min="1" step="any" />

    <x-calc.result label="Flips" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['flips' => 10],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'heads' => ['label' => 'Heads'],
            'tails' => ['label' => 'Tails'],
            'share' => ['label' => 'Share of heads'],
            'streak' => ['label' => 'Longest streak'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
