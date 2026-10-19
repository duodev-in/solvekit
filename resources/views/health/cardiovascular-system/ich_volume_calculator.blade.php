<x-calc.page
    title="ICH Volume Calculator - SolveKit"
    description="Free ICH volume calculator: intracerebral haemorrhage volume from CT by the ABC/2 method."
    lede="Estimate haematoma volume (ABC/2)."
    about="ABC/2 (Kothari et al., Stroke 1996): A is the largest diameter of the bleed on the slice where it is biggest, B the diameter at right angles to A, and C the number of slices with blood × slice thickness (counting slices with 25–75% of the area as half). Volume = A × B × C ÷ 2. 30 mL or more scores a point on the ICH score. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-clinical', 'tool' => 'ich_volume', 'fields' => ['a', 'b', 'c']]"
    :how-to="[
        ['name' => 'Measure A and B on the largest slice', 'text' => ''],
        ['name' => 'Work out C from the slices', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What volume is 4 × 3 × 3 cm?', 'answer' => '18.0 mL.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="a" label="A (largest diameter)" value="4" min="0" step="any" suffix="cm" />
        <x-calc.field name="b" label="B (perpendicular)" value="3" min="0" step="any" suffix="cm" />
        <x-calc.field name="c" label="C (depth)" value="3" min="0" step="any" suffix="cm" />
    </div>

    <x-calc.result label="Haematoma volume" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => 4, 'b' => 3, 'c' => 3],
        'Large' => ['a' => 6, 'b' => 4.5, 'c' => 4],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'formula' => ['label' => 'Formula'],
            'c' => ['label' => 'Working out C'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>V = A × B × C ÷ 2</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
