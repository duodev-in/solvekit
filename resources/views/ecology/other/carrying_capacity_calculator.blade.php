<x-calc.page
    title="Carrying Capacity Calculator - SolveKit"
    description="Free carrying capacity calculator: carrying capacity K from the resources available, or fitted to population counts over time with the logistic growth model."
    lede="Work out an environment's carrying capacity."
    about="Carrying capacity K is the largest population an environment can support. From resources, K = resource available ÷ need per individual. From counts over time, the logistic model N(t) = K ÷ (1 + ((K − N₀) ÷ N₀) e^(−rt)) is fitted by least squares, giving K and the growth rate r. Real populations can overshoot or vary."
    :calc="['engine' => 'eco-science', 'tool' => 'carrying_capacity', 'fields' => ['mode', 'resource', 'need', 'population', 'counts']]"
    :how-to="[
        ['name' => 'Choose resources or counts', 'text' => 'Counts need four or more points.'],
        ['name' => 'Read K', 'text' => 'And the growth rate for counts.'],
    ]"
    :faqs="[
        ['question' => 'What is carrying capacity?', 'answer' => 'The largest population an environment can sustain indefinitely.'],
        ['question' => 'How is K estimated from data?', 'answer' => 'By fitting the logistic growth curve to counts over time.'],
        ['question' => 'Can a population exceed K?', 'answer' => 'Briefly, which often leads to a crash or oscillation.'],
    ]"
>
    <x-calc.segmented name="mode" legend="From" :options="['resource' => 'Resources', 'fit' => 'Population counts']" selected="fit" />

    <div data-show-when="mode:resource" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
            <x-calc.field name="resource" label="Resource available" value="50000" />
            <x-calc.field name="need" label="Need per individual" value="25" />
            <x-calc.field name="population" label="Current population (optional)" value="1200" min="0" step="1" />
        </div>
    </div>

    <div data-show-when="mode:fit">
        <x-calc.textarea name="counts" label="Counts over time" value="0 20
2 45
4 95
6 180
8 290
10 380
12 430
14 460" help="One per line: time and population" rows="6" />
    </div>

    <x-calc.result label="Carrying capacity K" />

    <x-calc.options :examples="[
        'Population counts' => ['mode' => 'fit', 'counts' => '0 20
2 45
4 95
6 180
8 290
10 380
12 430
14 460'],
        'Deer and browse' => ['mode' => 'resource', 'resource' => 50000, 'need' => 25, 'population' => 1200],
        'Yeast culture' => ['mode' => 'fit', 'counts' => '0 10
2 29
4 71
6 175
8 351
10 513
12 594
14 640
16 655'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Logistic fit" name="curve" />
        <x-calc.rows heading="Details" :rows="[
            'k' => ['label' => 'K'],
            'now' => ['label' => 'Current level'],
            'room' => ['label' => 'Growth room'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>K = resource ÷ need</li>
            <li>N(t) = K ÷ (1 + ((K − N₀) ÷ N₀) e^(−rt))</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
