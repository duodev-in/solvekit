<x-calc.page
    title="Stroke Volume Calculator - SolveKit"
    description="Free stroke volume calculator: blood pumped per beat from end-diastolic and end-systolic volumes, from cardiac output and heart rate, or from Doppler LVOT diameter and VTI."
    lede="Calculate stroke volume."
    about="Stroke volume is the blood ejected with each heartbeat, normally 60–100 mL. It equals EDV − ESV, cardiac output ÷ heart rate, or on Doppler echo the LVOT area (π × (diameter ÷ 2)²) × the LVOT velocity-time integral. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-clinical', 'tool' => 'stroke_volume', 'fields' => ['mode', 'edv', 'esv', 'co', 'hr', 'lvot', 'vti']]"
    :how-to="[
        ['name' => 'Choose the method', 'text' => ''],
        ['name' => 'Enter the measurements', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the stroke volume for EDV 120 mL and ESV 50 mL?', 'answer' => '70 mL.'],
        ['question' => 'And from a 2.0 cm LVOT with a 20 cm VTI?', 'answer' => '63 mL.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Method" :options="['volumes' => 'EDV − ESV', 'cohr' => 'CO ÷ heart rate', 'doppler' => 'Doppler LVOT']" selected="volumes" />

    <div data-show-when="mode:volumes">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="edv" label="End-diastolic volume" value="120" min="0" step="any" suffix="mL" />
            <x-calc.field name="esv" label="End-systolic volume" value="50" min="0" step="any" suffix="mL" />
        </div>
    </div>

    <div data-show-when="mode:cohr" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="co" label="Cardiac output" value="5" min="0" step="any" suffix="L/min" />
            <x-calc.field name="hr" label="Heart rate" value="75" min="0" max="300" step="1" suffix="bpm" />
        </div>
    </div>

    <div data-show-when="mode:doppler" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="lvot" label="LVOT diameter" value="2.0" min="0" step="any" suffix="cm" />
            <x-calc.field name="vti" label="LVOT VTI" value="20" min="0" step="any" suffix="cm" />
        </div>
    </div>

    <x-calc.result label="Stroke volume" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'volumes', 'edv' => 120, 'esv' => 50, 'co' => 5, 'hr' => 75, 'lvot' => 2, 'vti' => 20],
        'Doppler' => ['mode' => 'doppler', 'edv' => 120, 'esv' => 50, 'co' => 5, 'hr' => 75, 'lvot' => 2, 'vti' => 20],
        'From CO' => ['mode' => 'cohr', 'edv' => 120, 'esv' => 50, 'co' => 5, 'hr' => 75, 'lvot' => 2, 'vti' => 20],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'method' => ['label' => 'Method'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>SV = EDV − ESV = CO ÷ HR = π (d/2)² × VTI</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
