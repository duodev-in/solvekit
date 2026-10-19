<x-calc.page
    title="ECG Boxes to Seconds Calculator - SolveKit"
    description="Free ECG boxes to seconds calculator: convert small or large ECG paper boxes to milliseconds at 25 or 50 mm/s."
    lede="Convert ECG boxes to time."
    about="At the standard paper speed of 25 mm/s, one small (1 mm) box is 40 ms and one large (5 mm) box is 200 ms; at 50 mm/s they are 20 ms and 100 ms. Normal intervals: PR 120–200 ms, QRS under 120 ms. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-clinical', 'tool' => 'ecg_boxes', 'fields' => ['boxes', 'size', 'speed']]"
    :how-to="[
        ['name' => 'Count the boxes', 'text' => ''],
        ['name' => 'Choose box size and paper speed', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How long are 4 small boxes at 25 mm/s?', 'answer' => '160 ms.'],
        ['question' => 'And 2 large boxes?', 'answer' => '400 ms.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="boxes" label="Number of boxes" value="4" min="0" step="any" />
        <x-calc.segmented name="size" legend="Box size" :options="['small' => 'Small (1 mm)', 'large' => 'Large (5 mm)']" selected="small" />
        <x-calc.select name="speed" label="Paper speed" :options="['25' => '25 mm/s', '50' => '50 mm/s']" selected="25" />
    </div>

    <x-calc.result label="Duration" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['boxes' => 4, 'size' => 'small', 'speed' => '25'],
        'Large' => ['boxes' => 2, 'size' => 'large', 'speed' => '25'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'small' => ['label' => 'Small box'],
            'large' => ['label' => 'Large box'],
            'normals' => ['label' => 'Normal intervals'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>ms = boxes × mm per box × 1000 ÷ speed</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
