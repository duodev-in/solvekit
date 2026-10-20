<x-calc.page
    title="Parrondo's Paradox Calculator - SolveKit"
    description="Free Parrondo's paradox calculator: how two losing games combine into a winning one, computed exactly round by round."
    lede="Explore Parrondo's paradox."
    about="Game A and game B each lose money on their own, yet alternating them can win. The trick is that game B’s odds depend on the current capital, and game A shuffles the capital."
    :calc="['engine' => 'st-prob', 'tool' => 'parrondo', 'fields' => ['pattern', 'rounds', 'eps'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is the expected capital after 100 rounds of AABB?', 'answer' => '1.3917 (game A alone −1, game B alone −1.3923).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="pattern" label="Play" :options="['A' => 'Game A only', 'B' => 'Game B only', 'AB' => 'Alternate A, B', 'AABB' => 'A, A, B, B repeated', 'random' => 'A or B at random each round']" selected="AABB" />
        <x-calc.field name="rounds" label="Rounds" value="100" min="1" step="any" />
        <x-calc.field name="eps" label="Bias ε" value="0.005" min="0" step="any" />
    </div>

    <x-calc.result label="Expected capital after the last round" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['pattern' => 'AABB', 'rounds' => 100, 'eps' => 0.005],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Expected capital (blue: your pattern; dashed: A and B alone)" name="capital" />
        <x-calc.rows heading="Details" :rows="[
            'a' => ['label' => 'Game A alone'],
            'b' => ['label' => 'Game B alone'],
            'verdict' => ['label' => 'Result'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
