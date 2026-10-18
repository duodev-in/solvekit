<x-calc.page
    title="Thread Calculator - SolveKit"
    description="Free thread calculator: basic dimensions of UNC, UNF and ISO metric threads: major, pitch and minor diameters, tap drill and tensile stress area."
    lede="Look up the basic dimensions of a screw thread."
    about="Basic dimensions of the 60° thread profile (ASME B1.1 unified, ISO 68-1 metric): pitch diameter d − 0.649519 P, basic minor diameter d − 1.082532 P and fundamental triangle height 0.866025 P. Inch tap drills for about 75% thread are from the Little Machine Shop chart; metric tap drill ≈ D − P. These are basic sizes, before tolerance classes."
    :calc="['engine' => 'con-mech', 'tool' => 'thread', 'fields' => ['system', 'inch', 'metric', 'series'], 'data' => collect(config('construction_data'))->only(['threads_inch', 'threads_metric'])->all()]"
    :how-to="[
        ['name' => 'Choose inch or metric', 'text' => 'And the size and series.'],
    ]"
    :faqs="[
        ['question' => 'What tap drill for ¼-20?', 'answer' => '#7 (0.201 in).'],
        ['question' => 'What tap drill for M8?', 'answer' => '6.8 mm (8 − 1.25).'],
        ['question' => 'What is the minor diameter of ½-13?', 'answer' => '0.4167 in basic.'],
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

    <x-calc.result label="Thread" />

    <x-calc.options :examples="[
        '¼-20 UNC' => ['system' => 'inch', 'inch' => '1/4', 'series' => 'coarse'],
        '½-20 UNF' => ['system' => 'inch', 'inch' => '1/2', 'series' => 'fine'],
        'M8 coarse' => ['system' => 'metric', 'metric' => 'M8', 'series' => 'coarse'],
        'M12 × 1.5 fine' => ['system' => 'metric', 'metric' => 'M12', 'series' => 'fine'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'major' => ['label' => 'Major diameter'],
            'pitch_d' => ['label' => 'Pitch diameter'],
            'minor' => ['label' => 'Minor diameter'],
            'height' => ['label' => 'Thread height'],
            'tap' => ['label' => 'Tap drill'],
            'area' => ['label' => 'Tensile stress area'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>d₂ = d − 0.649519 P</li>
            <li>D₁ = d − 1.082532 P</li>
            <li>H = 0.866025 P</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
