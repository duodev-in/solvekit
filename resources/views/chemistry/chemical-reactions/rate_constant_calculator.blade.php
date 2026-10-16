<x-calc.page
    title="Rate Constant Calculator - SolveKit"
    description="Free rate constant calculator: k for zero-, first- and second-order reactions from concentrations and time, or from the half-life."
    lede="Work out a rate constant from concentrations or the half-life."
    about="The integrated rate laws link concentration and time: [A] = [A]₀ − kt (zero order), ln[A] = ln[A]₀ − kt (first order) and 1/[A] = 1/[A]₀ + kt (second order). Only first-order half-lives are independent of concentration."
    :calc="['engine' => 'chem-reactions', 'tool' => 'rate_constant', 'fields' => ['order', 'mode', 'a0', 'at', 'time', 'half_life']]"
    :how-to="[
        ['name' => 'Pick the order', 'text' => 'Zero, first or second.'],
        ['name' => 'Enter the data', 'text' => 'Two concentrations and the time, or a half-life.'],
    ]"
    :faqs="[
        ['question' => 'How do I know the reaction order?', 'answer' => 'From experiments: plot [A], ln[A] or 1/[A] against time and see which is straight.'],
        ['question' => 'What are the units of k?', 'answer' => 'M/s for zero order, 1/s for first order and 1/(M·s) for second order.'],
        ['question' => 'Why is first-order half-life constant?', 'answer' => 'It equals ln 2 ÷ k and does not depend on concentration.'],
    ]"
>
    <x-calc.segmented name="order" legend="Reaction order" :options="['0' => 'Zero', '1' => 'First', '2' => 'Second']" selected="1" />

    <x-calc.segmented name="mode" legend="From" :options="['concentrations' => 'Concentrations and time', 'halflife' => 'Half-life']" selected="concentrations" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="a0" label="Initial [A]₀" value="1" min="0" suffix="M" />
        <div data-show-when="mode:concentrations">
            <x-calc.field name="at" label="[A] at time t" value="0.5" min="0" suffix="M" />
        </div>
    </div>

    <div data-show-when="mode:concentrations">
        <x-calc.field name="time" label="Time t" value="100" min="0" suffix="s" />
    </div>

    <div data-show-when="mode:halflife" hidden>
        <x-calc.field name="half_life" label="Half-life" value="50" min="0" suffix="s" />
    </div>

    <x-calc.result label="Rate constant k" />

    <x-calc.options :examples="[
        'First order, half gone in 100 s' => ['order' => '1', 'mode' => 'concentrations', 'a0' => 1, 'at' => 0.5, 'time' => 100],
        'Second order, t½ = 50 s' => ['order' => '2', 'mode' => 'halflife', 'a0' => 0.1, 'half_life' => 50],
        'Zero order' => ['order' => '0', 'mode' => 'concentrations', 'a0' => 1, 'at' => 0.6, 'time' => 200],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'half' => ['label' => 'Half-life'],
            'units' => ['label' => 'Units of k'],
            'rate' => ['label' => 'Initial rate'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>zero: k = ([A]₀ − [A]) ÷ t</li>
            <li>first: k = ln([A]₀ ÷ [A]) ÷ t</li>
            <li>second: k = (1/[A] − 1/[A]₀) ÷ t</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
