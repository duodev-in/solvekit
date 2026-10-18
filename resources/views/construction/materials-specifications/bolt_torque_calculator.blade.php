<x-calc.page
    title="Bolt Torque Calculator - SolveKit"
    description="Free bolt torque calculator: tightening torque and clamp load for inch (SAE J429) and metric (ISO 898-1) bolts from the proof load and nut factor."
    lede="Work out the tightening torque for a bolt."
    about="Torque T = K × D × F: the nut factor K (about 0.20 for plain dry steel, about 0.15 lubricated, a common published value), the nominal diameter D and the clamp load F. F is a percentage of the proof load, often 75% for reusable joints; proof load = proof stress (SAE J429 or ISO 898-1) × tensile stress area. Real torque–tension varies; follow the joint designer's or maker's values when given."
    :calc="['engine' => 'con-mech', 'tool' => 'bolt_torque', 'fields' => ['system', 'inch', 'metric', 'series', 'sae_grade', 'iso_class', 'percent', 'nut_factor'], 'data' => collect(config('construction_data'))->only(['threads_inch', 'threads_metric', 'bolt_grades'])->all()]"
    :how-to="[
        ['name' => 'Choose the thread and grade', 'text' => 'Inch or metric.'],
        ['name' => 'Set the preload and nut factor', 'text' => '75% and 0.20 dry are common.'],
    ]"
    :faqs="[
        ['question' => 'What torque for a ½-13 grade 5 bolt?', 'answer' => 'About 75 lb·ft dry at 75% of proof load.'],
        ['question' => 'What is the nut factor?', 'answer' => 'An experimental constant covering friction; about 0.2 for dry steel.'],
        ['question' => 'Why not tighten to yield?', 'answer' => 'Preload near 75% of proof keeps the bolt elastic and reusable.'],
    ]"
>
    <x-calc.segmented name="system" legend="Thread" :options="['inch' => 'Inch (UNC/UNF)', 'metric' => 'Metric (ISO)']" selected="inch" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="system:inch">
            <x-calc.select name="inch" label="Size" :options="collect(config('construction_data.threads_inch'))->mapWithKeys(fn ($t, $k) => [$k => $k.' ('.$t['major'].' in)'])->all()" selected="1/2" />
        </div>
        <div data-show-when="system:metric" hidden>
            <x-calc.select name="metric" label="Size" :options="collect(config('construction_data.threads_metric'))->mapWithKeys(fn ($t, $k) => [$k => $k])->all()" selected="M12" />
        </div>
        <x-calc.segmented name="series" legend="Series" :options="['coarse' => 'Coarse', 'fine' => 'Fine']" selected="coarse" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="system:inch">
            <x-calc.select name="sae_grade" label="SAE grade" :options="['2' => 'Grade 2', '5' => 'Grade 5', '8' => 'Grade 8']" selected="5" />
        </div>
        <div data-show-when="system:metric" hidden>
            <x-calc.select name="iso_class" label="Property class" :options="collect(config('construction_data.bolt_grades.iso'))->mapWithKeys(fn ($c, $k) => [$k => 'Class '.$k])->all()" selected="8.8" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="percent" label="Preload, % of proof load" value="75" min="1" max="100" suffix="%" />
        <x-calc.field name="nut_factor" label="Nut factor K" value="0.2" min="0.05" max="0.5" step="0.01" />
    </div>

    <x-calc.result label="Tightening torque" />

    <x-calc.options :examples="[
        '½-13 grade 5, dry' => ['system' => 'inch', 'inch' => '1/2', 'series' => 'coarse', 'sae_grade' => '5', 'percent' => 75, 'nut_factor' => 0.2],
        'M12 class 8.8, oiled' => ['system' => 'metric', 'metric' => 'M12', 'series' => 'coarse', 'iso_class' => '8.8', 'percent' => 75, 'nut_factor' => 0.15],
        '⅜-24 grade 8' => ['system' => 'inch', 'inch' => '3/8', 'series' => 'fine', 'sae_grade' => '8', 'percent' => 75, 'nut_factor' => 0.2],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'nm' => ['label' => 'Newton meters'],
            'preload' => ['label' => 'Clamp load'],
            'proof' => ['label' => 'Proof load'],
            'area' => ['label' => 'Stress area'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>T = K × D × F</li>
            <li>F = % × proof stress × As</li>
            <li>As = 0.7854 (d − 0.9743 ÷ n)² (inch); π ÷ 4 (d − 0.9382 P)² (metric)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
