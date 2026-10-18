<x-calc.page
    title="Wall Square Footage Calculator - SolveKit"
    description="Free wall square footage calculator: net wall area of several walls less doors and windows, with a paint estimate."
    lede="Work out the square footage of walls, less doors and windows."
    about="Each wall is length × height. Subtract each door and window (width × height) to get the net area for paint, drywall, siding or wallpaper."
    :calc="['engine' => 'con-area', 'tool' => 'wall_area', 'fields' => ['walls', 'walls_unit', 'openings', 'openings_unit', 'coverage', 'coats'], 'rowUnits' => ['walls' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'openings' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all()]]"
    :how-to="[
        ['name' => 'Add each wall', 'text' => 'Length and height.'],
        ['name' => 'Add doors and windows', 'text' => 'Width, height and how many.'],
    ]"
    :faqs="[
        ['question' => 'How do I work out wall square footage?', 'answer' => 'Multiply each wall\'s length by its height and subtract the openings.'],
        ['question' => 'What size is a standard door?', 'answer' => '3 ft × 6 ft 8 in (about 20 ft²).'],
        ['question' => 'Should I subtract windows for paint?', 'answer' => 'Yes for large ones; many painters ignore small windows as an allowance for waste.'],
    ]"
>
    <x-calc.rows-editor name="walls" label="Walls" :columns="['length' => 'Length', 'height' => 'Height']" :rows="[[14, 8], [12, 8], [14, 8], [12, 8]]" :units="collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all()" unit="ft" add-label="Add wall" />

    <x-calc.rows-editor name="openings" label="Doors and windows" :columns="['width' => 'Width', 'height' => 'Height', 'count' => 'Count']" :rows="[[3, 6.67, 1], [3, 4, 2]]" :units="collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all()" unit="ft" add-label="Add opening" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="coverage" label="Paint coverage (optional)" value="350" min="0" suffix="ft²/gal" />
        <x-calc.field name="coats" label="Coats" value="2" min="1" step="1" />
    </div>

    <x-calc.result label="Net wall area" />

    <x-calc.options :examples="[
        '12 × 14 ft room' => ['walls' => '14 8
12 8
14 8
12 8', 'walls_unit' => 'ft', 'openings' => '3 6.67 1
3 4 2', 'openings_unit' => 'ft', 'coverage' => 350, 'coats' => 2],
        'Metric room 4 × 3.5 m' => ['walls' => '4 2.5
3.5 2.5
4 2.5
3.5 2.5', 'walls_unit' => 'm', 'openings' => '0.9 2.1 1
1.2 1.2 1', 'openings_unit' => 'm', 'coverage' => 350, 'coats' => 2],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'm2' => ['label' => 'Square meters'],
            'gross' => ['label' => 'Gross wall area'],
            'openings' => ['label' => 'Openings'],
            'paint' => ['label' => 'Paint'],
        ]" />
        <x-calc.quick-ref heading="Each wall" name="walls" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>net = Σ (length × height) − Σ (width × height × count)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
