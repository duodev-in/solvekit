<x-calc.page
    title="Bench Press Pyramid Calculator - SolveKit"
    description="Free bench press pyramid calculator: set-by-set weights and reps from your 1RM."
    lede="Build a pyramid workout."
    about="A pyramid raises the weight as reps fall, then may come back down."
    :calc="['engine' => 'sp-misc', 'tool' => 'bench_pyramid', 'fields' => ['rm', 'type', 'step', 'unit'], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the top set for a 100 kg 1RM?', 'answer' => '85 kg × 4.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="rm" label="One-rep max" value="100" min="1" step="any" />
        <x-calc.select name="type" label="Pyramid" :options="['up' => 'Ascending (light to heavy)', 'down' => 'Descending (heavy to light)', 'tri' => 'Triangle (up then down)']" selected="up" />
        <x-calc.field name="step" label="Round to" value="2.5" min="0.25" step="any" />
        <x-calc.select name="unit" label="Weights in" :options="['kg' => 'kg', 'lb' => 'lb']" selected="kg" />
    </div>

    <x-calc.result label="Top set" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['rm' => 100, 'type' => 'up', 'step' => 2.5, 'unit' => 'kg'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'volume' => ['label' => 'Total volume'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Sets" name="sets" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
