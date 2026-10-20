<x-calc.page
    title="Bertrand's Paradox - SolveKit"
    description="Free Bertrand's paradox calculator: the chance a random chord is longer than the triangle side is 1/3, 1/2 or 1/4 depending on how the chord is chosen."
    lede="Explore Bertrand's paradox."
    about="Joseph Bertrand (1889) asked how likely a random chord of a circle is to be longer than the side of the inscribed equilateral triangle. Three natural ways of choosing a chord give three different answers."
    :calc="['engine' => 'st-prob', 'tool' => 'bertrand', 'fields' => ['method', 'trials', 'seed'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What does the random-endpoints method give?', 'answer' => '1/3 (simulated 0.3403 (3,403 of 10,000)).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="method" label="How the chord is chosen" :options="['endpoints' => 'Two random points on the circle', 'radius' => 'A random point on a random radius', 'midpoint' => 'A random midpoint inside the circle']" selected="endpoints" />
        <x-calc.field name="trials" label="Simulated trials" value="10000" min="1" step="any" />
        <x-calc.field name="seed" label="Simulation seed (same seed, same run)" value="1" min="1" step="any" />
    </div>

    <x-calc.result label="P(chord longer than the triangle side)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['method' => 'endpoints', 'trials' => 10000, 'seed' => 1],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="First 40 chords (longer ones in blue)" name="chords" />
        <x-calc.rows heading="Details" :rows="[
            'exact' => ['label' => 'Exact answer for this method'],
            'sim' => ['label' => 'Simulated share'],
            'others' => ['label' => 'The other methods'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
