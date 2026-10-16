<x-calc.page
    title="Corn Yield Calculator - SolveKit"
    description="Free corn yield calculator: estimate bushels per acre from ear counts, kernel rows and kernels per row."
    lede="Estimate corn yield in bushels per acre before harvest."
    about="This is the yield component method: count ears in 1/1,000 of an acre, count kernel rows and kernels per row on typical ears, and divide by a kernel factor (75 to 90 kernels per bushel × 1,000). Use 90 for normal kernels, lower for large kernels."
    :calc="['engine' => 'garden', 'tool' => 'corn_yield', 'fields' => ['ears', 'rows', 'kernels', 'factor']]"
    :how-to="[
        ['name' => 'Count ears', 'text' => 'In 17 ft 5 in of row for 30-inch rows (1/1,000 acre).'],
        ['name' => 'Count kernels', 'text' => 'On every fifth ear, average the rows and kernels per row.'],
    ]"
    :faqs="[
        ['question' => 'How long is 1/1,000 acre of row?', 'answer' => '17 ft 5 in for 30-inch rows; 26 ft 2 in for 20-inch rows.'],
        ['question' => 'What kernel factor should I use?', 'answer' => '90 for average kernels; 75 to 85 if kernels are large and deep.'],
        ['question' => 'How accurate is this method?', 'answer' => 'Usually within 15 to 20%; it depends on sampling several spots.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="ears" label="Ears in 1/1,000 acre" value="32" min="0" />
        <x-calc.field name="rows" label="Kernel rows per ear" value="16" min="0" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="kernels" label="Kernels per row" value="35" min="0" />
        <x-calc.field name="factor" label="Kernel factor" value="90" min="50" max="120" />
    </div>

    <x-calc.result label="Estimated yield" />

    <x-calc.options :examples="[
        'Good stand' => ['ears' => 32, 'rows' => 16, 'kernels' => 35, 'factor' => 90],
        'Drought stress' => ['ears' => 28, 'rows' => 14, 'kernels' => 25, 'factor' => 85],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'tonnes_ha' => ['label' => 'Tonnes per hectare', 'unit' => 't/ha'],
            'ears_acre' => ['label' => 'Ears per acre'],
            'kernels_ear' => ['label' => 'Kernels per ear'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>bu/ac = ears × rows × kernels ÷ kernel factor</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
