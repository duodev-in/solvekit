<x-calc.page
    title="5/3/1 Calculator - SolveKit"
    description="Free 5/3/1 calculator: Jim Wendler’s four-week cycle with weights rounded to your plates."
    lede="Plan a 5/3/1 cycle."
    about="Wendler’s 5/3/1 works from a training max of 90% of your 1RM, with 5s, 3s and 5/3/1 weeks then a deload."
    :calc="['engine' => 'sp-misc', 'tool' => 'five_three_one', 'fields' => ['rm', 'tm', 'step', 'unit'], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the training max for a 100 kg 1RM?', 'answer' => '90 kg.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="rm" label="One-rep max" value="100" min="1" step="any" />
        <x-calc.field name="tm" label="Training max (% of 1RM)" value="90" min="50" step="any" />
        <x-calc.field name="step" label="Round to (smallest jump)" value="2.5" min="0.25" step="any" />
        <x-calc.select name="unit" label="Weights in" :options="['kg' => 'kg', 'lb' => 'lb']" selected="kg" />
    </div>

    <x-calc.result label="Training max" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['rm' => 100, 'tm' => 90, 'step' => 2.5, 'unit' => 'kg'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'rule' => ['label' => 'Rule'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Four-week cycle (sets × reps @ weight)" name="plan" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
