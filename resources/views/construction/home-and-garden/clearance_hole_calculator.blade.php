<x-calc.page
    title="Clearance Hole Calculator - SolveKit"
    description="Free clearance hole calculator: drill size for a screw or bolt to pass through, close or free fit for inch screws and fine, medium or coarse for metric (ISO 273)."
    lede="Find the drill size for a bolt or screw to pass through."
    about="Metric clearance holes follow ISO 273: fine, medium and coarse series (an M6 is 6.4, 6.6 or 7 mm). Inch close- and free-fit drills are from the Little Machine Shop tap and clearance drill chart."
    :calc="['engine' => 'con-mech', 'tool' => 'clearance_hole', 'fields' => ['system', 'inch', 'inch_fit', 'metric', 'metric_fit'], 'data' => collect(config('construction_data'))->only(['threads_inch', 'threads_metric'])->all()]"
    :how-to="[
        ['name' => 'Choose inch or metric', 'text' => 'And the screw size.'],
        ['name' => 'Choose the fit', 'text' => 'Close for accurate location, free for easy assembly.'],
    ]"
    :faqs="[
        ['question' => 'What clearance hole for ¼ in bolt?', 'answer' => 'F (0.257 in) close fit or H (0.266 in) free fit.'],
        ['question' => 'What clearance hole for M6?', 'answer' => '6.6 mm medium (ISO 273).'],
        ['question' => 'What clearance for #10?', 'answer' => '#9 (0.196 in) close or #7 (0.201 in) free.'],
    ]"
>
    <x-calc.segmented name="system" legend="Screw" :options="['inch' => 'Inch', 'metric' => 'Metric']" selected="inch" />

    <div data-show-when="system:inch">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.select name="inch" label="Size" :options="collect(config('construction_data.threads_inch'))->filter(fn ($t) => isset($t['clearance']))->mapWithKeys(fn ($t, $k) => [$k => $k.' ('.$t['major'].' in)'])->all()" selected="1/4" />
            <x-calc.select name="inch_fit" label="Fit" :options="['close' => 'Close', 'free' => 'Free']" selected="free" />
        </div>
    </div>

    <div data-show-when="system:metric" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.select name="metric" label="Size" :options="collect(config('construction_data.threads_metric'))->mapWithKeys(fn ($t, $k) => [$k => $k])->all()" selected="M6" />
            <x-calc.select name="metric_fit" label="Fit" :options="['fine' => 'Fine', 'medium' => 'Medium', 'coarse' => 'Coarse']" selected="medium" />
        </div>
    </div>

    <x-calc.result label="Clearance drill" />

    <x-calc.options :examples="[
        '¼ in free fit' => ['system' => 'inch', 'inch' => '1/4', 'inch_fit' => 'free'],
        '#10 close fit' => ['system' => 'inch', 'inch' => '#10', 'inch_fit' => 'close'],
        'M6 medium' => ['system' => 'metric', 'metric' => 'M6', 'metric_fit' => 'medium'],
        'M10 fine' => ['system' => 'metric', 'metric' => 'M10', 'metric_fit' => 'fine'],
    ]" />

    <x-slot:panel>
        <div data-show-when="system:inch">
            <x-calc.rows heading="Details" :rows="[
                'close' => ['label' => 'Close fit'],
                'free' => ['label' => 'Free fit'],
                'clearance' => ['label' => 'Clearance'],
                'mm' => ['label' => 'Millimeters'],
            ]" />
        </div>
        <div data-show-when="system:metric" hidden>
            <x-calc.rows heading="Details" :rows="[
                'fine' => ['label' => 'Fine'],
                'medium' => ['label' => 'Medium'],
                'coarse' => ['label' => 'Coarse'],
                'inch' => ['label' => 'Inches'],
            ]" />
        </div>
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>ISO 273 fine / medium / coarse series</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
