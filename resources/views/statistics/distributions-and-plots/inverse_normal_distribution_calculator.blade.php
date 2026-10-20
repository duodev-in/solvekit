<x-calc.page
    title="Inverse Normal Distribution Calculator - SolveKit"
    description="Free inverse normal calculator: the value x for a left, right or central area under a normal curve."
    lede="Find x from a normal probability."
    about="The inverse normal function turns a probability into the matching value: the x with that area to its left."
    :calc="['engine' => 'st-dist', 'tool' => 'inverse_normal', 'fields' => ['p', 'mean', 'sd', 'tail'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What z has 95% of the area to its left?', 'answer' => '1.6448536.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="p" label="Probability (area)" value="0.95" min="0" step="any" />
        <x-calc.field name="mean" label="Mean μ" value="0" step="any" />
        <x-calc.field name="sd" label="Standard deviation σ" value="1" min="0" step="any" />
        <x-calc.select name="tail" label="Area" :options="['left' => 'Left of x: P(X ≤ x)', 'right' => 'Right of x: P(X ≥ x)', 'centre' => 'Centred between −x and x (symmetric)']" selected="left" />
    </div>

    <x-calc.result label="x" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['p' => 0.95, 'mean' => 0, 'sd' => 1, 'tail' => 'left'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Normal curve with the area shaded" name="dist" />
        <x-calc.rows heading="Details" :rows="[
            'z' => ['label' => 'z-score'],
            'check' => ['label' => 'Check'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
