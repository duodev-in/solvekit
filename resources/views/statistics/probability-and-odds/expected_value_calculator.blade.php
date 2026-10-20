<x-calc.page
    title="Expected Value Calculator - SolveKit"
    description="Free expected value calculator: the long-run average of outcomes with probabilities, with variance and standard deviation."
    lede="Find the expected value."
    about="The expected value weights each outcome by its probability: E[X] = Σ x·p. It is the average result over many repetitions."
    :calc="['engine' => 'st-prob', 'tool' => 'expected_value', 'fields' => ['list'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is the expected value of the example game?', 'answer' => '10.'],
    ]"
>
    <x-calc.textarea name="list" label="Outcomes: value, probability (one per line)" value="100, 0.1
20, 0.3
-10, 0.6" rows="3" />

    <x-calc.result label="Expected value" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['list' => '100, 0.1
20, 0.3
-10, 0.6'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'variance' => ['label' => 'Variance'],
            'sd' => ['label' => 'Standard deviation'],
            'check' => ['label' => 'Sum of probabilities'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
