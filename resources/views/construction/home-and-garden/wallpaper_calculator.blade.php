<x-calc.page
    title="Wallpaper Calculator - SolveKit"
    description="Free wallpaper calculator: rolls of wallpaper by roll width and length, wall height and pattern repeat."
    lede="Work out how many rolls of wallpaper you need."
    about="Wallpaper hangs in strips: each wall needs its width ÷ roll width strips. Each strip is the wall height plus a trimming allowance, rounded up to the pattern repeat so the pattern lines up. A roll gives as many whole strips as fit its length. Openings save whole strips only."
    :calc="['engine' => 'con-finish', 'tool' => 'wallpaper', 'fields' => ['walls', 'walls_unit', 'openings', 'openings_unit', 'roll_width', 'roll_length', 'repeat', 'allowance', 'price'], 'unitFields' => ['roll_width' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'roll_length' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'repeat' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'allowance' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()], 'rowUnits' => ['walls' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'openings' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all()]]"
    :how-to="[
        ['name' => 'Add each wall', 'text' => 'Length and height.'],
        ['name' => 'Enter the roll and repeat', 'text' => 'From the label: US double rolls are often 20½ in × 33 ft.'],
    ]"
    :faqs="[
        ['question' => 'How many rolls for a 12 × 14 room?', 'answer' => 'About 11 US double rolls (20½ in × 33 ft) with a 21 in repeat, 8 ft walls and one door.'],
        ['question' => 'What is a pattern repeat?', 'answer' => 'The vertical distance before the pattern repeats; strips are cut to multiples of it.'],
        ['question' => 'What size is a European roll?', 'answer' => '0.53 m × 10.05 m.'],
    ]"
>
    <x-calc.rows-editor name="walls" label="Walls" :columns="['length' => 'Length', 'height' => 'Height']" :rows="[[12, 8], [14, 8], [12, 8], [14, 8]]" :units="collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all()" unit="ft" add-label="Add wall" />

    <x-calc.rows-editor name="openings" label="Doors and windows" :columns="['width' => 'Width', 'height' => 'Height', 'count' => 'Count']" :rows="[[3, 6.67, 1]]" :units="collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all()" unit="ft" add-label="Add opening" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="roll_width" label="Roll width" value="20.5" min="0" placeholder="Roll width">
            <label for="calc-roll_width-unit" class="sr-only">Roll width unit</label>
            <select id="calc-roll_width-unit" name="roll_width-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="roll_length" label="Roll length" value="33" min="0" placeholder="Roll length">
            <label for="calc-roll_length-unit" class="sr-only">Roll length unit</label>
            <select id="calc-roll_length-unit" name="roll_length-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="repeat" label="Pattern repeat" value="21" min="0" placeholder="Pattern repeat">
            <label for="calc-repeat-unit" class="sr-only">Pattern repeat unit</label>
            <select id="calc-repeat-unit" name="repeat-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="allowance" label="Trim allowance per strip" value="4" min="0" placeholder="Trim allowance per strip">
            <label for="calc-allowance-unit" class="sr-only">Trim allowance per strip unit</label>
            <select id="calc-allowance-unit" name="allowance-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="price" label="Price per roll (optional)" value="" min="0" step="0.01" suffix="$" placeholder="Optional" />
    </div>

    <x-calc.result label="Wallpaper rolls" />

    <x-calc.options :examples="[
        '12 × 14 room' => ['walls' => '12 8
14 8
12 8
14 8', 'walls_unit' => 'ft', 'openings' => '3 6.67 1', 'openings_unit' => 'ft', 'roll_width' => 20.5, 'roll_width-unit' => 'in', 'roll_length' => 33, 'roll_length-unit' => 'ft', 'repeat' => 21, 'repeat-unit' => 'in', 'allowance' => 4, 'allowance-unit' => 'in'],
        'Euro roll, 64 cm repeat' => ['walls' => '4 2.5
3.5 2.5
4 2.5
3.5 2.5', 'walls_unit' => 'm', 'openings' => '0.9 2.1 1
1.2 1.2 1', 'openings_unit' => 'm', 'roll_width' => 0.53, 'roll_width-unit' => 'm', 'roll_length' => 10.05, 'roll_length-unit' => 'm', 'repeat' => 64, 'repeat-unit' => 'cm', 'allowance' => 10, 'allowance-unit' => 'cm'],
        'Feature wall, no repeat' => ['walls' => '14 8', 'walls_unit' => 'ft', 'openings' => '', 'roll_width' => 20.5, 'roll_width-unit' => 'in', 'roll_length' => 33, 'roll_length-unit' => 'ft', 'repeat' => 0, 'repeat-unit' => 'in', 'allowance' => 4, 'allowance-unit' => 'in'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'strips' => ['label' => 'Strips'],
            'drop' => ['label' => 'Strip length'],
            'area' => ['label' => 'Wall area'],
            'cost' => ['label' => 'Cost'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>strips = Σ ⌈wall length ÷ roll width⌉</li>
            <li>strip = ⌈(height + allowance) ÷ repeat⌉ × repeat</li>
            <li>rolls = ⌈strips ÷ ⌊roll length ÷ strip⌋⌉</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
