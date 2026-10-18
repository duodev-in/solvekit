<x-calc.page
    title="Brick Calculator - SolveKit"
    description="Free brick calculator: number of bricks and mortar for a wall by brick size (modular, standard, queen, king, Norman and more), less openings."
    lede="Work out how many bricks and how much mortar a wall needs."
    about="Bricks per square foot = 144 ÷ ((length + joint) × (height + joint)) in inches: 6.86 for modular brick with ⅜ in joints. Brick sizes are from the Brick Industry Association Technical Note 10. Add 5% for cuts and breakage."
    :calc="['engine' => 'con-concrete', 'tool' => 'brick', 'fields' => ['input', 'length', 'height', 'area', 'unit_type', 'joint', 'openings', 'waste', 'mortar_waste', 'price'], 'unitFields' => ['length' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'height' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'area' => collect(config('units.area'))->only(['ft2', 'yd2', 'm2', 'acre', 'ha'])->all(), 'joint' => collect(config('units.length'))->only(['in', 'mm', 'cm'])->all(), 'openings' => collect(config('units.area'))->only(['ft2', 'yd2', 'm2', 'acre', 'ha'])->all()], 'data' => ['units' => config('construction_data.units')]]"
    :how-to="[
        ['name' => 'Enter the wall', 'text' => 'Size or area, and openings.'],
        ['name' => 'Choose the brick', 'text' => 'And the joint thickness.'],
    ]"
    :faqs="[
        ['question' => 'How many bricks per square foot?', 'answer' => '6.86 modular bricks with ⅜ in joints; 6.55 standard bricks.'],
        ['question' => 'How many bricks for a 20 × 8 ft wall?', 'answer' => 'About 1,100 modular bricks before waste.'],
        ['question' => 'What is a modular brick?', 'answer' => '7⅝ × 2¼ × 3⅝ in, which with ⅜ in joints lays to an 8 in module.'],
    ]"
>
    <x-calc.segmented name="input" legend="Wall" :options="['size' => 'Length × height', 'area' => 'Known area']" selected="size" />

    <div data-show-when="input:size">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="length" label="Wall length" value="20" min="0" placeholder="Wall length">
                <label for="calc-length-unit" class="sr-only">Wall length unit</label>
                <select id="calc-length-unit" name="length-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
            <x-calc.field name="height" label="Wall height" value="8" min="0" placeholder="Wall height">
                <label for="calc-height-unit" class="sr-only">Wall height unit</label>
                <select id="calc-height-unit" name="height-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <div data-show-when="input:area" hidden>
        <x-calc.field name="area" label="Wall area" value="160" min="0" placeholder="Wall area">
            <label for="calc-area-unit" class="sr-only">Wall area unit</label>
            <select id="calc-area-unit" name="area-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.area'))->only(['ft2', 'yd2', 'm2', 'acre', 'ha']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft2')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="unit_type" label="Brick" :options="collect(config('construction_data.units'))->reject(fn ($u) => $u['hollow'] ?? false)->map(fn ($u) => $u['name'])->all()" selected="modular" />
        <x-calc.field name="joint" label="Joint thickness" value="0.375" min="0" placeholder="Joint thickness">
            <label for="calc-joint-unit" class="sr-only">Joint thickness unit</label>
            <select id="calc-joint-unit" name="joint-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'mm', 'cm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="openings" label="Openings (optional)" value="" min="0" placeholder="Openings (optional)">
            <label for="calc-openings-unit" class="sr-only">Openings (optional) unit</label>
            <select id="calc-openings-unit" name="openings-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.area'))->only(['ft2', 'yd2', 'm2', 'acre', 'ha']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft2')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="waste" label="Extra bricks" value="5" min="0" max="100" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="mortar_waste" label="Extra mortar" value="15" min="0" max="100" suffix="%" />
        <x-calc.field name="price" label="Price per brick (optional)" value="" min="0" step="0.01" suffix="$" placeholder="Optional" />
    </div>

    <x-calc.result label="Bricks needed" />

    <x-calc.options :examples="[
        'Wall 20 × 8 ft' => ['input' => 'size', 'length' => 20, 'length-unit' => 'ft', 'height' => 8, 'height-unit' => 'ft', 'unit_type' => 'modular', 'joint' => 0.375, 'joint-unit' => 'in', 'waste' => 5, 'mortar_waste' => 15],
        'House front 400 ft², openings 60' => ['input' => 'area', 'area' => 400, 'area-unit' => 'ft2', 'unit_type' => 'queen', 'joint' => 0.375, 'joint-unit' => 'in', 'openings' => 60, 'openings-unit' => 'ft2', 'waste' => 5, 'mortar_waste' => 15],
        'Metric wall 6 × 2.4 m' => ['input' => 'size', 'length' => 6, 'length-unit' => 'm', 'height' => 2.4, 'height-unit' => 'm', 'unit_type' => 'standard', 'joint' => 10, 'joint-unit' => 'mm', 'waste' => 5, 'mortar_waste' => 15],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'per_ft2' => ['label' => 'Bricks per area'],
            'mortar' => ['label' => 'Mortar'],
            'area' => ['label' => 'Net wall area'],
            'cost' => ['label' => 'Cost'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>bricks per area = 1 ÷ ((L + j)(H + j))</li>
            <li>mortar per brick = W ((L + j)(H + j) − L H)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
