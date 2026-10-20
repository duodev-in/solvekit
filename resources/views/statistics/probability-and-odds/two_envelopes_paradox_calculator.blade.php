<x-calc.page
    title="Two Envelopes Paradox Calculator - SolveKit"
    description="Free two envelopes paradox calculator: why always switching gains nothing, and how a threshold strategy can, with a simulation."
    lede="Resolve the two envelopes paradox."
    about="One envelope holds twice the other. An argument says switching gains 25% on average, but switching cannot always help. The flaw is treating the amount you hold as fixed."
    :calc="['engine' => 'st-prob', 'tool' => 'two_envelopes', 'fields' => ['strategy', 'max', 'threshold', 'trials', 'seed'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What does always switching average in the example?', 'answer' => '75.75, the same as never switching.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="strategy" label="Strategy" :options="['always' => 'Always switch', 'never' => 'Never switch', 'threshold' => 'Switch only if the amount is below a threshold']" selected="always" />
        <x-calc.field name="max" label="Smaller amount is random from 1 to" value="100" min="1" step="any" />
        <div data-show-when="strategy:threshold">
            <x-calc.field name="threshold" label="Threshold" value="60" min="0" step="any" />
        </div>
        <x-calc.field name="trials" label="Simulated trials" value="10000" min="1" step="any" />
        <x-calc.field name="seed" label="Simulation seed (same seed, same run)" value="1" min="1" step="any" />
    </div>

    <x-calc.result label="Average amount won" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['strategy' => 'always', 'max' => 100, 'threshold' => 60, 'trials' => 10000, 'seed' => 1],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'exact' => ['label' => 'Exact average for this strategy'],
            'baseline' => ['label' => 'Average without switching'],
            'gain' => ['label' => 'Gain from the strategy'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
