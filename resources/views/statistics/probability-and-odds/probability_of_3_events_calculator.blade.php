<x-calc.page
    title="Probability of 3 Events Calculator - SolveKit"
    description="Free probability of 3 events calculator: all three, at least one, exactly one or none, for independent events."
    lede="Combine three probabilities."
    about="For independent events multiply the probabilities; P(at least one) is easiest as 1 − P(none)."
    :calc="['engine' => 'st-prob', 'tool' => 'three_events', 'fields' => ['pA', 'pB', 'pC'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is P(at least one) for 0.5, 0.4 and 0.3?', 'answer' => '0.79.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="pA" label="P(A)" value="0.5" min="0" step="any" />
        <x-calc.field name="pB" label="P(B)" value="0.4" min="0" step="any" />
        <x-calc.field name="pC" label="P(C)" value="0.3" min="0" step="any" />
    </div>

    <x-calc.result label="P(all three)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['pA' => 0.5, 'pB' => 0.4, 'pC' => 0.3],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'any' => ['label' => 'P(at least one)'],
            'one' => ['label' => 'P(exactly one)'],
            'two' => ['label' => 'P(exactly two)'],
            'none' => ['label' => 'P(none)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="All eight outcomes (independent events)" name="table" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
