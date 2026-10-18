<x-calc.page
    title="Thread Pitch Calculator - SolveKit"
    description="Free thread pitch calculator: convert threads per inch to pitch in millimeters and back, with the standard threads that match."
    lede="Convert threads per inch to metric pitch and back."
    about="Pitch (mm) = 25.4 ÷ threads per inch. The list shows the standard UNC, UNF and ISO metric threads within 3% of the pitch, since some inch and metric threads are nearly interchangeable in pitch but not in diameter or form."
    :calc="['engine' => 'con-mech', 'tool' => 'thread_pitch', 'fields' => ['mode', 'tpi', 'pitch'], 'data' => collect(config('construction_data'))->only(['threads_inch', 'threads_metric'])->all()]"
    :how-to="[
        ['name' => 'Enter TPI or pitch', 'text' => 'Count threads over an inch, or read a metric pitch.'],
    ]"
    :faqs="[
        ['question' => 'What is 20 TPI in mm?', 'answer' => '1.27 mm.'],
        ['question' => 'What TPI is 1.5 mm?', 'answer' => '16.93 TPI.'],
        ['question' => 'Is 1.25 mm close to 20 TPI?', 'answer' => 'Yes, 1.27 mm; but the diameters and thread forms differ.'],
    ]"
>
    <x-calc.segmented name="mode" legend="From" :options="['tpi' => 'Threads per inch', 'mm' => 'Pitch in mm']" selected="tpi" />

    <div data-show-when="mode:tpi">
        <x-calc.field name="tpi" label="Threads per inch" value="20" min="0" />
    </div>

    <div data-show-when="mode:mm" hidden>
        <x-calc.field name="pitch" label="Pitch" value="1.25" min="0" suffix="mm" />
    </div>

    <x-calc.result label="Pitch" />

    <x-calc.options :examples="[
        '20 TPI' => ['mode' => 'tpi', 'tpi' => 20],
        '1.5 mm' => ['mode' => 'mm', 'pitch' => 1.5],
        '13 TPI' => ['mode' => 'tpi', 'tpi' => 13],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'pitch_in' => ['label' => 'Inches per thread'],
            'pitch_mm' => ['label' => 'Millimeters'],
            'tpi' => ['label' => 'Threads per inch'],
        ]" />
        <x-calc.quick-ref heading="Standard threads with this pitch" name="near" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>P (mm) = 25.4 ÷ TPI</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
