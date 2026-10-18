<x-calc.page
    title="Tire Size Calculator - SolveKit"
    description="Free tire size calculator: diameter, width, sidewall, circumference and revolutions per mile from a tire size such as 225/45R17, and the speedometer difference between two sizes."
    lede="Decode a tire size and compare two sizes."
    about="In 225/45R17, 225 is the width in mm, 45 the sidewall height as a percentage of the width, and 17 the rim in inches (ISO/ETRTO). Diameter = rim + 2 × width × aspect. Flotation sizes such as 31x10.50R15 give the diameter and width in inches. A taller tire makes the speedometer read low; revolutions per mile are unloaded (under load they rise by about 2–3%)."
    :calc="['engine' => 'ev-transport', 'tool' => 'tire_size', 'fields' => ['tire', 'compare']]"
    :how-to="[
        ['name' => 'Enter the size', 'text' => 'From the tire\'s sidewall.'],
        ['name' => 'Add a second size', 'text' => 'To compare diameters.'],
    ]"
    :faqs="[
        ['question' => 'How tall is a 225/45R17 tire?', 'answer' => '24.97 in (634 mm).'],
        ['question' => 'Is 235/40R18 a good swap for 225/45R17?', 'answer' => 'It is 1.7% taller, within the usual 3% guideline; the speedometer reads about 1 mph low at 60.'],
        ['question' => 'What does R mean?', 'answer' => 'Radial construction.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="tire" label="Tire size" value="225/45R17" type="text" placeholder="225/45R17" />
        <x-calc.field name="compare" label="Compare with (optional)" value="235/40R18" type="text" placeholder="235/40R18" />
    </div>

    <x-calc.result label="Diameter" />

    <x-calc.options :examples="[
        '225/45R17 vs 235/40R18' => ['tire' => '225/45R17', 'compare' => '235/40R18'],
        'Truck 265/70R17 vs 285/70R17' => ['tire' => '265/70R17', 'compare' => '285/70R17'],
        'Flotation 33x12.50R15' => ['tire' => '33x12.50R15', 'compare' => ''],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'width' => ['label' => 'Width'],
            'sidewall' => ['label' => 'Sidewall'],
            'circumference' => ['label' => 'Circumference'],
            'revs' => ['label' => 'Revolutions'],
            'compare' => ['label' => 'Comparison'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>diameter = rim + 2 × width × aspect ÷ 100</li>
            <li>revs per mile = 63,360 ÷ (π × diameter in)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
