<x-calc.page
    title="Constant of Proportionality Calculator - SolveKit"
    description="Free constant of proportionality calculator: k = y ÷ x from pairs, with a check that the relationship is proportional."
    lede="Find the constant of proportionality."
    about="Two quantities are proportional when y = kx: every ratio y ÷ x is the same constant k."
    :calc="['engine' => 'st-desc', 'tool' => 'proportionality', 'fields' => ['data'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is k for the example table?', 'answer' => '3.5.'],
    ]"
>
    <x-calc.textarea name="data" label="x, y pairs (one per line)" value="2, 7
4, 14
6, 21
10, 35" rows="4" />

    <x-calc.result label="Constant of proportionality k" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['data' => '2, 7
4, 14
6, 21
10, 35'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="y against x" name="line" />
        <x-calc.rows heading="Details" :rows="[
            'equation' => ['label' => 'Equation'],
            'proportional' => ['label' => 'Proportional?'],
            'ratios' => ['label' => 'Each y ÷ x'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
