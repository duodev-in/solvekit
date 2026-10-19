<x-calc.page
    title="ECG Heart Rate Calculator - SolveKit"
    description="Free ECG heart rate calculator: heart rate from the RR interval in small or large boxes, in seconds, or by the 6-second method."
    lede="Work out heart rate from an ECG."
    about="At 25 mm/s: heart rate = 1,500 ÷ small boxes between R waves, or 300 ÷ large boxes. For irregular rhythms count the QRS complexes in a 6-second strip (30 large boxes) and multiply by 10. Normal resting rate is 60–100 bpm. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-clinical', 'tool' => 'ecg_rate', 'fields' => ['method', 'value', 'speed']]"
    :how-to="[
        ['name' => 'Choose the method', 'text' => ''],
        ['name' => 'Enter the boxes, seconds or count', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the heart rate with 4 large boxes between R waves?', 'answer' => '75 bpm.'],
        ['question' => 'And 9 QRS complexes in 6 seconds?', 'answer' => '90 bpm.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.select name="method" label="Method" :options="['small' => 'RR in small boxes', 'large' => 'RR in large boxes', 'seconds' => 'RR in seconds', 'six' => 'QRS in 6 seconds']" selected="large" />
        <x-calc.field name="value" label="Measurement" value="4" min="0" step="any" />
        <x-calc.select name="speed" label="Paper speed" :options="['25' => '25 mm/s', '50' => '50 mm/s']" selected="25" />
    </div>

    <x-calc.result label="Heart rate" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['method' => 'large', 'value' => 4, 'speed' => '25'],
        'Small boxes' => ['method' => 'small', 'value' => 20, 'speed' => '25'],
        'Six seconds' => ['method' => 'six', 'value' => 9, 'speed' => '25'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'rr' => ['label' => 'RR interval'],
            'rule' => ['label' => 'Rule'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>HR = 300 ÷ large boxes = 1,500 ÷ small boxes</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
