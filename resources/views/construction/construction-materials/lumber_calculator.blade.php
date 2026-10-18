<x-calc.page
    title="Lumber Calculator - SolveKit"
    description="Free lumber calculator: board feet, actual dressed sizes, linear feet and cost for a list of lumber pieces."
    lede="Work out board feet, actual sizes and cost for a lumber list."
    about="A board foot is 1 in × 12 in × 1 ft of nominal size. Lumber is sold by nominal size, but dressed dry softwood is smaller: a 2×4 is 1½ × 3½ in and a 2×10 is 1½ × 9¼ in (American Softwood Lumber Standard PS 20)."
    :calc="['engine' => 'con-weight', 'tool' => 'lumber', 'fields' => ['pieces', 'pieces_unit', 'price'], 'data' => ['lumber_dressed' => config('construction_data.lumber_dressed')], 'rowUnits' => ['pieces' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all()]]"
    :how-to="[
        ['name' => 'List each size', 'text' => 'Nominal thickness and width in inches, length and count.'],
        ['name' => 'Add a price', 'text' => 'Per board foot, if you want the cost.'],
    ]"
    :faqs="[
        ['question' => 'How many board feet in a 2×4×8?', 'answer' => '5.33 bf.'],
        ['question' => 'What are the actual sizes of a 2×6?', 'answer' => '1½ × 5½ in.'],
        ['question' => 'Why is lumber smaller than its name?', 'answer' => 'The nominal size is the rough-sawn green size; drying and planing remove about ½ in.'],
    ]"
>
    <x-calc.rows-editor name="pieces" label="Lumber list" :columns="['thickness' => 'Nominal thick (in)', 'width' => 'Nominal width (in)', 'length' => 'Length', 'count' => 'Pieces']" :rows="[[2, 4, 8, 20], [2, 6, 12, 10], [4, 4, 8, 4]]" :units="collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all()" unit="ft" unit-label="Length unit" add-label="Add piece" />

    <x-calc.field name="price" label="Price per board foot (optional)" value="" min="0" step="0.01" suffix="$" placeholder="Optional" />

    <x-calc.result label="Board feet" />

    <x-calc.options :examples="[
        'Deck framing list' => ['pieces' => '2 4 8 20
2 6 12 10
4 4 8 4', 'pieces_unit' => 'ft'],
        'Joists 2×10' => ['pieces' => '2 10 16 12', 'pieces_unit' => 'ft', 'price' => 1.1],
        'Metric lengths' => ['pieces' => '2 4 2.4 30', 'pieces_unit' => 'm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'cost' => ['label' => 'Cost'],
            'nominal' => ['label' => 'Nominal volume'],
            'actual' => ['label' => 'Actual volume'],
            'linear' => ['label' => 'Linear length'],
        ]" />
        <x-calc.quick-ref heading="Each size" name="pieces" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>bf = thickness (in) × width (in) × length (ft) ÷ 12</li>
            <li>dressed: 2 → 1½, 4 → 3½, 6 → 5½, 8 → 7¼, 10 → 9¼, 12 → 11¼ in</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
