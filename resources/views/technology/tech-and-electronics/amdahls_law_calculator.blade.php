<x-calc.page
    title="Amdahl's Law Calculator - SolveKit"
    description="Free Amdahl's law calculator: speedup from parallel processors, the maximum possible speedup and processors needed for a target."
    lede="Find the speedup from parallel processing."
    about="Amdahl's law shows that the part of a job that cannot run in parallel limits the speedup, however many processors you add."
    :calc="['engine' => 'tc-elec', 'tool' => 'amdahl', 'fields' => ['p', 'n', 'target'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'How fast is a 90% parallel job on 8 cores?', 'answer' => '4.7059× (at most 10×).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="p" label="Parallel part of the work (%)" value="90" min="0" step="any" />
        <x-calc.field name="n" label="Processors or cores" value="8" min="1" step="any" />
        <x-calc.field name="target" label="Target speedup (optional)" value="5" min="1" step="any" />
    </div>

    <x-calc.result label="Speedup" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['p' => 90, 'n' => 8, 'target' => 5],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Speedup by number of processors" name="curve" />
        <x-calc.rows heading="Details" :rows="[
            'max' => ['label' => 'Maximum possible speedup'],
            'efficiency' => ['label' => 'Efficiency per processor'],
            'needed' => ['label' => 'Processors for the target'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
