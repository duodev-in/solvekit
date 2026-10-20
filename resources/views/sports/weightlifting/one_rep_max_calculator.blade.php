<x-calc.page
    title="One-Rep Max Calculator - SolveKit"
    description="Free one-rep max calculator: 1RM from weight and reps by seven formulas, with a percentage table."
    lede="Estimate your one-rep max."
    about="One-rep max formulas (Epley, Brzycki and others) agree closely for sets of up to about ten reps."
    :calc="['engine' => 'sp-misc', 'tool' => 'one_rm', 'fields' => ['w', 'r', 'unit'], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What 1RM does 100 kg × 5 give?', 'answer' => '115.5 kg.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="w" label="Weight lifted" value="100" min="1" step="any" />
        <x-calc.field name="r" label="Reps completed (1–12 best)" value="5" min="1" step="any" />
        <x-calc.select name="unit" label="Weights in" :options="['kg' => 'kg', 'lb' => 'lb']" selected="kg" />
    </div>

    <x-calc.result label="Estimated one-rep max" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['w' => 100, 'r' => 5, 'unit' => 'kg'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'epley' => ['label' => 'Epley'],
            'brzycki' => ['label' => 'Brzycki'],
            'lombardi' => ['label' => 'Lombardi'],
            'lander' => ['label' => 'Lander'],
            'mayhew' => ['label' => 'Mayhew'],
            'oconner' => ['label' => 'O’Conner'],
            'wathan' => ['label' => 'Wathan'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Percentages of your 1RM" name="pct" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
