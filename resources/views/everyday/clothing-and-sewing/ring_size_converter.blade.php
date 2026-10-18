<x-calc.page
    title="Ring Size Converter - SolveKit"
    description="Free ring size converter: US, UK, European (ISO 8653) and Swiss ring sizes from a ring's inside diameter or circumference, or from any size."
    lede="Convert a ring size, or find yours from a measurement."
    about="ISO 8653 sizes are the inside circumference in millimeters (size 54 = 54 mm). US and Canadian sizes go up 0.032 in (0.8128 mm) in diameter per size from 11.63 mm at size 0, so size 7 is 17.3 mm across. UK and Australian letters (BS 6820) start at A = 37.5 mm and rise 1.25 mm a letter. Swiss sizes are the ISO size minus 40."
    :calc="['engine' => 'ev-clothing', 'tool' => 'ring', 'fields' => ['from', 'value_mm', 'size', 'letter']]"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'A size or a measurement.'],
        ['name' => 'Enter it', 'text' => 'Measure a ring that fits on the inside.'],
    ]"
    :faqs="[
        ['question' => 'What is a US size 7 in UK size?', 'answer' => 'N½ (ISO 54½).'],
        ['question' => 'How do I measure my ring size?', 'answer' => 'Measure the inside diameter of a ring that fits, or wrap a strip of paper around the finger.'],
        ['question' => 'What is ring size 54?', 'answer' => 'About US 7 (inside circumference 54 mm).'],
    ]"
>
    <x-calc.select name="from" label="I know" :options="['circumference' => 'Inside circumference (mm)', 'diameter' => 'Inside diameter (mm)', 'us' => 'US / Canada size', 'uk' => 'UK / Australia letter', 'iso' => 'ISO / European size']" selected="us" />

    <div data-show-when="from:circumference,diameter" hidden>
        <x-calc.field name="value_mm" label="Measurement" value="54.4" min="30" max="90" step="0.1" suffix="mm" />
    </div>

    <div data-show-when="from:us,iso">
        <x-calc.field name="size" label="Size" value="7" min="0" step="0.25" />
    </div>

    <div data-show-when="from:uk" hidden>
        <x-calc.field name="letter" label="Letter" value="N½" type="text" placeholder="N or N½" />
    </div>

    <x-calc.result label="Ring size" />

    <x-calc.options :examples="[
        'US 7' => ['from' => 'us', 'value_mm' => '', 'size' => 7, 'letter' => ''],
        'Diameter 18.2 mm' => ['from' => 'diameter', 'value_mm' => 18.2, 'size' => '', 'letter' => ''],
        'UK L' => ['from' => 'uk', 'value_mm' => '', 'size' => '', 'letter' => 'L'],
        'EU 60' => ['from' => 'iso', 'value_mm' => '', 'size' => 60, 'letter' => ''],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'uk' => ['label' => 'UK'],
            'iso' => ['label' => 'ISO 8653'],
            'swiss' => ['label' => 'Swiss'],
            'tip' => ['label' => 'Tip'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>US: d = 11.63 + 0.8128 × size (mm)</li>
            <li>UK: C = 37.5 + 1.25 × letter index (mm)</li>
            <li>ISO = C (mm)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
