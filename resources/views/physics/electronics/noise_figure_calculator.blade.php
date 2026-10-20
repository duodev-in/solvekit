<x-calc.page
    title="Noise Figure Calculator - SolveKit"
    description="Free cascaded noise figure calculator: Friis formula for a chain of amplifiers and mixers."
    lede="Find cascaded noise figure."
    about="The first stage dominates a receiver’s noise: later stages are divided by the gain in front of them. That is why a good low-noise amplifier goes first."
    :calc="['engine' => 'ph-elec', 'tool' => 'noise_figure', 'fields' => ['stages'], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the noise figure of the example chain?', 'answer' => '1.593 dB.'],
    ]"
>
    <x-calc.textarea name="stages" label="Stages in order: gain dB, noise figure dB (one per line)" value="20, 1.5
10, 5
30, 10" rows="3" />

    <x-calc.result label="Cascaded noise figure" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['stages' => '20, 1.5
10, 5
30, 10'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'T' => ['label' => 'Equivalent noise temperature'],
            'G' => ['label' => 'Total gain'],
            'first' => ['label' => 'Share from the first stage'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
