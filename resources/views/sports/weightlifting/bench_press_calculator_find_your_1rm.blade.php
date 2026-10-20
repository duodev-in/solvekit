<x-calc.page
    title="Bench Press Calculator - Find Your 1RM - SolveKit"
    description="Free bench press 1RM calculator: estimated one-rep max from a set of reps."
    lede="Estimate your bench press max."
    about="A set to failure predicts your one-rep max. Seven published formulas are averaged."
    :calc="['engine' => 'sp-misc', 'tool' => 'bench_1rm', 'fields' => ['w', 'r', 'unit'], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What 1RM does 80 kg × 5 suggest?', 'answer' => '92.39 kg.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="w" label="Weight lifted" value="80" min="1" step="any" />
        <x-calc.field name="r" label="Reps completed (1–12 best)" value="5" min="1" step="any" />
        <x-calc.select name="unit" label="Weights in" :options="['kg' => 'kg', 'lb' => 'lb']" selected="kg" />
    </div>

    <x-calc.result label="Estimated bench press 1RM" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['w' => 80, 'r' => 5, 'unit' => 'kg'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'epley' => ['label' => 'Epley'],
            'brzycki' => ['label' => 'Brzycki'],
            'range' => ['label' => 'Range of formulas'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
