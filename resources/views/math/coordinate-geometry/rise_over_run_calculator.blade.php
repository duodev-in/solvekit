<x-calc.page
    title="Rise Over Run Calculator - SolveKit"
    description="Free rise over run calculator: slope, angle and grade from the rise and run."
    lede="Turn rise and run into a slope."
    about="Slope = rise ÷ run. A ramp rising 3 over a run of 12 has slope 1/4 (25% grade, 14.04°). Building codes often limit wheelchair ramps to 1 : 12."
    :calc="['engine' => 'mt-coord', 'tool' => 'slope', 'fields' => ['rise', 'run'], 'given' => 'rise_run']"
    :how-to="[
        ['name' => 'Enter the coordinates', 'text' => 'Fractions such as 3/4 stay exact; decimals work too.'],
        ['name' => 'Read the result', 'text' => 'The working is shown step by step, with a graph where it helps.'],
    ]"
    :faqs="[
        ['question' => 'What slope has a rise of 3 over a run of 12?', 'answer' => '1/4.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="rise" label="Rise" value="3" type="text" inputmode="decimal" />
        <x-calc.field name="run" label="Run" value="12" type="text" inputmode="decimal" />
    </div>

    <x-calc.result label="Slope m" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['rise' => '3', 'run' => '12'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Graph" name="graph" />
        <x-calc.rows heading="Details" :rows="[
            'slope' => ['label' => 'Slope'],
            'angle' => ['label' => 'Angle'],
            'grade' => ['label' => 'Grade'],
            'ratio' => ['label' => 'Ratio'],
            'length' => ['label' => 'Slope length'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>m = rise ÷ run</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
