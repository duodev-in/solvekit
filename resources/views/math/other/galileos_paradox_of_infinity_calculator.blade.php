<x-calc.page
    title="Galileo's Paradox of Infinity Calculator - SolveKit"
    description="Galileo's paradox calculator: how few numbers are squares, yet squares and numbers can be paired one-to-one."
    lede="Explore Galileo's paradox."
    about="Up to a million only 1,000 numbers are perfect squares, 0.1%, and the share keeps shrinking. Yet pairing each n with n² matches every number with exactly one square. Galileo concluded that less and equal stop making sense for infinite sets; Cantor later made one-to-one pairing the definition of equal size."
    :calc="['engine' => 'mt-other', 'tool' => 'galileo', 'fields' => ['n']]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => ''],
        ['name' => 'Read the result', 'text' => 'The working explains each step.'],
    ]"
    :faqs="[
        ['question' => 'How many squares are there up to 1,000,000?', 'answer' => '1,000.'],
    ]"
>
    <x-calc.field name="n" label="Count up to n" value="1000000" type="text" inputmode="numeric" />

    <x-calc.result label="Perfect squares" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['n' => '1000000'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'share' => ['label' => 'Share of squares'],
            'nonsquares' => ['label' => 'Non-squares'],
            'pairing' => ['label' => 'Pairing'],
            'lesson' => ['label' => 'Why'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>⌊√n⌋ squares up to n</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
