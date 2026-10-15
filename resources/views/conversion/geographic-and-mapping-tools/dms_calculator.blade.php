<x-calc.page
    title="Degrees Minutes Seconds Calculator - SolveKit"
    description="Professional DMS calculator for navigation, surveying and astronomy. Convert between decimal degrees and degrees minutes seconds format with precision."
    lede="Convert between decimal degrees and degrees, minutes and seconds."
    about="A degree has 60 minutes and a minute has 60 seconds, so decimal degrees = degrees + minutes ÷ 60 + seconds ÷ 3,600. Seconds are rounded before splitting, so a value never shows 60 seconds, and south or west angles keep their negative sign."
    :calc="['engine' => 'dms']"
    :how-to="[
        ['name' => 'Choose a direction', 'text' => 'Decimal to DMS, or DMS to decimal.'],
        ['name' => 'Say what the angle is', 'text' => 'Latitude and longitude get N/S and E/W letters and are range-checked.'],
        ['name' => 'Enter the angle', 'text' => 'Other angle units are listed beside the result.'],
    ]"
    :faqs="[
        ['question' => 'How do I convert 40.7484° to DMS?', 'answer' => '40° 44′ 54.24″: 0.7484 × 60 = 44.904 minutes, and 0.904 × 60 = 54.24 seconds.'],
        ['question' => 'How do I write a southern latitude in decimal?', 'answer' => 'Make it negative: 33° 52′ S is −33.8667°.'],
        ['question' => 'Why can minutes not be 60?', 'answer' => '60 minutes is a whole degree, so it carries over: 12° 60′ is 13° 0′.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.segmented name="mode" legend="Direction" :options="['to-dms' => 'Decimal → DMS', 'to-decimal' => 'DMS → Decimal']" selected="to-dms" />
        <x-calc.select name="axis" label="This angle is a" :options="['lat' => 'Latitude', 'lon' => 'Longitude', 'angle' => 'General angle']" selected="lat" />
    </div>

    <div data-show-when="mode:to-dms">
        <x-calc.field name="decimal" type="text" label="Decimal degrees" value="40.748440" placeholder="e.g. 40.7484 or -73.9857" inputmode="decimal" />
    </div>

    <div data-show-when="mode:to-decimal" hidden class="grid grid-cols-3 gap-3">
        <x-calc.field name="degrees" label="Degrees" value="40" suffix="°" placeholder="0" />
        <x-calc.field name="minutes" label="Minutes" value="44" min="0" max="59" suffix="′" placeholder="0" />
        <x-calc.field name="seconds" label="Seconds" value="54.24" min="0" max="59.999" suffix="″" placeholder="0" />
        <x-calc.segmented name="sign" legend="Hemisphere" :options="['pos' => 'N or E (+)', 'neg' => 'S or W (−)']" selected="pos" class="col-span-3" />
    </div>

    <x-calc.result label="Degrees, minutes, seconds" />

    <x-calc.options :decimals="true" :examples="[
        'Sydney latitude' => ['mode' => 'to-dms', 'axis' => 'lat', 'decimal' => '-33.8568'],
        'Greenwich 0° 0′ 5.3″ W' => ['mode' => 'to-decimal', 'axis' => 'lon', 'degrees' => 0, 'minutes' => 0, 'seconds' => 5.3, 'sign' => 'neg'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Same angle in" :rows="[
            'decimal' => ['label' => 'Decimal degrees'],
            'dms' => ['label' => 'Degrees, minutes, seconds'],
            'dm' => ['label' => 'Degrees, decimal minutes'],
            'radians' => ['label' => 'Radians', 'unit' => 'rad'],
            'gradians' => ['label' => 'Gradians', 'unit' => 'gon'],
            'mils' => ['label' => 'NATO mils', 'unit' => 'mil'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>decimal = D + M ÷ 60 + S ÷ 3,600</li>
            <li>M = whole part of (fraction × 60)</li>
            <li>S = remainder × 60</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
