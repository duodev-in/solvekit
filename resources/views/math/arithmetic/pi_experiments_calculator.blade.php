<x-calc.page
    title="Pi Experiments Calculator - SolveKit"
    description="Free π experiments calculator: estimate π by random points in a quarter circle or by Buffon's needle, and watch the estimate converge."
    lede="Estimate π by experiment."
    about="Drop random points in a square: the share landing inside the quarter circle tends to π/4. Buffon's needle (1777) drops needles on parallel lines; the chance of crossing gives π. Errors shrink only like 1/√n, so a million trials give about three correct digits."
    :calc="['engine' => 'mt-arith', 'tool' => 'pi_experiment', 'fields' => ['method', 'trials', 'seed', 'spacing']]"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Whole numbers can be as long as you like; decimals and fractions stay exact.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What does 100,000 random points give?', 'answer' => '3.14564.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.select name="method" label="Experiment" :options="['points' => 'Random points', 'buffon' => 'Buffon\'s needle']" selected="points" />
        <x-calc.field name="trials" label="Trials" value="100000" min="10" max="2000000" step="1" />
        <x-calc.field name="seed" label="Random seed" value="7" step="1" />
    </div>

    <div data-show-when="method:buffon" hidden>
        <x-calc.field name="spacing" label="Line spacing (needle length 1)" value="2" min="1" step="any" />
    </div>

    <x-calc.result label="Estimate of π" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['method' => 'points', 'trials' => 100000, 'seed' => 7, 'spacing' => 2],
        'Buffon' => ['method' => 'buffon', 'trials' => 200000, 'seed' => 3, 'spacing' => 2],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Estimate as trials grow" name="curve" />
        <x-calc.rows heading="Details" :rows="[
            'hits' => ['label' => 'Hits'],
            'error' => ['label' => 'Error'],
            'method' => ['label' => 'Method'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>π ≈ 4 × inside ÷ total</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
