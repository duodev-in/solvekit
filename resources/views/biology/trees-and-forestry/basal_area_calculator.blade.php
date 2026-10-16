<x-calc.page
    title="Basal Area Calculator - SolveKit"
    description="Free basal area calculator: square feet per tree and per acre from DBH and stand density."
    lede="Work out basal area per tree and per acre."
    about="Basal area is the cross-section of a trunk at breast height. In US units it is 0.005454 × DBH² square feet, with DBH in inches. Multiplied by trees per acre, it measures how crowded a stand is."
    :calc="['engine' => 'forestry', 'tool' => 'basal_area', 'fields' => ['dbh', 'trees'], 'unitFields' => ['dbh' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Enter the DBH', 'text' => 'Average diameter at breast height.'],
        ['name' => 'Add trees per acre', 'text' => 'For the stand basal area.'],
    ]"
    :faqs="[
        ['question' => 'What is a typical basal area?', 'answer' => 'Managed hardwood stands often carry 60 to 120 ft² per acre.'],
        ['question' => 'Where does 0.005454 come from?', 'answer' => 'It is π ÷ (4 × 144), converting inches² to square feet.'],
        ['question' => 'How is basal area used?', 'answer' => 'Foresters use it to decide when and how much to thin.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="dbh" label="DBH" value="14" min="0" placeholder="DBH">
            <label for="calc-dbh-unit" class="sr-only">DBH unit</label>
            <select id="calc-dbh-unit" name="dbh-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="trees" label="Trees per acre (optional)" value="120" min="0" step="1" />
    </div>

    <x-calc.result label="Basal area per tree" />

    <x-calc.options :examples="[
        '14 in × 120 trees' => ['dbh' => 14, 'trees' => 120],
        '20 in × 60 trees' => ['dbh' => 20, 'trees' => 60],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'm2' => ['label' => 'Square meters', 'unit' => 'm²'],
            'stand_ac' => ['label' => 'Stand per acre'],
            'stand_ha' => ['label' => 'Stand per hectare'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>BA (ft²) = 0.005454 × DBH²</li>
            <li>BA (m²) = π ÷ 4 × DBH²</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
