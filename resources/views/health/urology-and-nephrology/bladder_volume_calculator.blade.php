<x-calc.page
    title="Bladder Volume Calculator - SolveKit"
    description="Free bladder volume calculator: bladder volume from ultrasound length, width and height (ellipsoid formula), with the post-void residual band."
    lede="Estimate bladder volume from ultrasound."
    about="Bladder volume ≈ length × width × height × 0.52 (the ellipsoid coefficient, Dicuio et al. 2005); other coefficients (0.625, 0.7) are used for some shapes. A post-void residual under 50 mL is normal; 200 mL or more suggests incomplete emptying. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-labs', 'tool' => 'bladder', 'fields' => ['length', 'width', 'height', 'coefficient', 'context']]"
    :how-to="[
        ['name' => 'Measure the three diameters', 'text' => 'In transverse and sagittal views.'],
        ['name' => 'Choose the coefficient', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the volume for 8 × 7 × 6 cm?', 'answer' => '175 mL: Post-void residual 50–199 mL: raised; repeat and review.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="length" label="Length" value="8" min="0" step="any" suffix="cm" />
        <x-calc.field name="width" label="Width" value="7" min="0" step="any" suffix="cm" />
        <x-calc.field name="height" label="Height" value="6" min="0" step="any" suffix="cm" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="coefficient" label="Coefficient" :options="['0.52' => '0.52 (ellipsoid)', '0.625' => '0.625', '0.7' => '0.7']" selected="0.52" />
        <x-calc.segmented name="context" legend="Scan" :options="['pvr' => 'After voiding', 'full' => 'Before voiding']" selected="pvr" />
    </div>

    <x-calc.result label="Bladder volume" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['length' => 8, 'width' => 7, 'height' => 6, 'coefficient' => '0.52', 'context' => 'pvr'],
        'Small residual' => ['length' => 4, 'width' => 3.5, 'height' => 2.5, 'coefficient' => '0.52', 'context' => 'pvr'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'formula' => ['label' => 'Formula'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>V = L × W × H × 0.52</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
