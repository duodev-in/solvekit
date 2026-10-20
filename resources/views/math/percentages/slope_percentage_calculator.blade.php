<x-calc.page
    title="Slope Percentage Calculator - SolveKit"
    description="Free slope percentage calculator: grade in percent from rise and run, and conversion between percent slope, angle and ratio."
    lede="Convert between slope percent, angle and ratio."
    about="Slope percentage (grade) = rise ÷ run × 100. A 100% slope is 45°, not vertical. The angle is arctan(grade ÷ 100), and the ratio 1 : n means 1 unit up for n across."
    :calc="['engine' => 'mt-percent', 'tool' => 'slope', 'fields' => ['mode', 'rise', 'run', 'angle', 'percent']]"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => ''],
        ['name' => 'Enter it', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the grade of a 3 m rise over 40 m?', 'answer' => '7.5% (4.2891533°).'],
        ['question' => 'What angle is a 100% slope?', 'answer' => '45°.'],
    ]"
>
    <x-calc.segmented name="mode" legend="From" :options="['riserun' => 'Rise and run', 'angle' => 'Angle', 'percent' => 'Percent']" selected="riserun" />

    <div data-show-when="mode:riserun">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="rise" label="Rise" value="3" type="text" inputmode="decimal" />
            <x-calc.field name="run" label="Run" value="40" type="text" inputmode="decimal" />
        </div>
    </div>

    <div data-show-when="mode:angle" hidden>
        <x-calc.field name="angle" label="Angle" value="5" step="any" suffix="°" />
    </div>

    <div data-show-when="mode:percent" hidden>
        <x-calc.field name="percent" label="Slope" value="8" step="any" suffix="%" />
    </div>

    <x-calc.result label="Slope" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'riserun', 'rise' => '3', 'run' => '40', 'angle' => 5, 'percent' => 8],
        'Hundred' => ['mode' => 'percent', 'rise' => '3', 'run' => '40', 'angle' => 5, 'percent' => 100],
        'Angle' => ['mode' => 'angle', 'rise' => '3', 'run' => '40', 'angle' => 5, 'percent' => 8],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'angle' => ['label' => 'Angle'],
            'ratio' => ['label' => 'Ratio'],
            'formula' => ['label' => 'Formula'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>grade = rise ÷ run × 100</li>
            <li>θ = arctan(grade ÷ 100)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
