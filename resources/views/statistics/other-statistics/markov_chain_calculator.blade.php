<x-calc.page
    title="Markov Chain Calculator - SolveKit"
    description="Free Markov chain calculator: state probabilities after n steps and the long-run steady state from a transition matrix."
    lede="Step a Markov chain."
    about="In a Markov chain the next state depends only on the current one, through a matrix of transition probabilities."
    :calc="['engine' => 'st-inf', 'tool' => 'markov', 'fields' => ['matrix', 'start', 'steps'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is the steady state of the example?', 'answer' => '0.625, 0.3125, 0.0625.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.textarea name="matrix" label="Transition matrix: row i gives the probabilities of moving from state i" value="0.9, 0.075, 0.025
0.15, 0.8, 0.05
0.25, 0.25, 0.5" rows="3" />
        <x-calc.textarea name="start" label="Starting distribution (or the number of the starting state)" value="1" rows="3" />
        <x-calc.field name="steps" label="Steps" value="3" min="0" step="any" />
    </div>

    <x-calc.result label="Distribution after the steps" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['matrix' => '0.9, 0.075, 0.025
0.15, 0.8, 0.05
0.25, 0.25, 0.5', 'start' => '1', 'steps' => 3],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'steady' => ['label' => 'Steady state (long run)'],
            'most' => ['label' => 'Most likely state now'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Distribution step by step" name="table" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
