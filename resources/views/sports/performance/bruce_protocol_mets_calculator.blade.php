<x-calc.page
    title="Bruce Protocol METs Calculator - SolveKit"
    description="Free Bruce protocol calculator: VO₂max and METs from treadmill time."
    lede="Find METs from a Bruce test."
    about="The Bruce treadmill test raises speed and incline every three minutes. Total time predicts VO₂max."
    :calc="['engine' => 'sp-fit', 'tool' => 'bruce', 'fields' => ['T', 'sex'], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What VO₂max does 10 minutes suggest for a man?', 'answer' => '34.07 ml/kg/min.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="T" label="Time on the treadmill (minutes, decimals allowed)" value="10" min="0" step="any" />
        <x-calc.select name="sex" label="Sex" :options="['male' => 'Male', 'female' => 'Female']" selected="male" />
    </div>

    <x-calc.result label="Estimated VO₂max" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['T' => 10, 'sex' => 'male'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'mets' => ['label' => 'METs'],
            'stage' => ['label' => 'Stage reached'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
