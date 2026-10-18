<x-calc.page
    title="Mortar Calculator - SolveKit"
    description="Free mortar calculator: mortar volume and cement, lime and sand for brick or block walls by ASTM C270 mortar type."
    lede="Work out the mortar, cement, lime and sand for a brick or block wall."
    about="Mortar is the volume of the joints: full bed and head joints for brick, face-shell bedding for hollow block. Cement, lime and sand follow the ASTM C270 proportion specification with sand at three times the cementitious volume; sand makes about its own volume of mortar because the paste fills its voids. Mortar droppings and leftovers are usually 10–25%, so add waste."
    :calc="['engine' => 'con-concrete', 'tool' => 'mortar', 'fields' => ['area', 'unit_type', 'joint', 'type', 'face_shell', 'waste'], 'unitFields' => ['area' => collect(config('units.area'))->only(['ft2', 'yd2', 'm2', 'acre', 'ha'])->all(), 'joint' => collect(config('units.length'))->only(['in', 'mm', 'cm'])->all(), 'face_shell' => collect(config('units.length'))->only(['in', 'mm', 'cm'])->all()], 'data' => collect(config('construction_data'))->only(['units', 'mortar'])->all()]"
    :how-to="[
        ['name' => 'Enter the wall area', 'text' => 'And pick the brick or block.'],
        ['name' => 'Set the joint and mortar type', 'text' => 'Type N for most above-grade walls, S below grade.'],
    ]"
    :faqs="[
        ['question' => 'How much mortar per 100 bricks?', 'answer' => 'About 0.8 ft³ of joints for modular brick with ⅜ in joints, before waste.'],
        ['question' => 'Which mortar type should I use?', 'answer' => 'Type N for general above-grade work, type S for below grade and higher strength, type M for heavy loads.'],
        ['question' => 'How much sand per bag of cement?', 'answer' => 'For type N (1 : 1 : 6), about 6 ft³ of sand per 94 lb bag of cement, with 1 ft³ (40 lb) of lime.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="area" label="Wall area" value="200" min="0" placeholder="Wall area">
            <label for="calc-area-unit" class="sr-only">Wall area unit</label>
            <select id="calc-area-unit" name="area-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.area'))->only(['ft2', 'yd2', 'm2', 'acre', 'ha']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft2')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="unit_type" label="Unit" :options="collect(config('construction_data.units'))->map(fn ($u) => $u['name'])->all()" selected="modular" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="joint" label="Joint thickness" value="0.375" min="0" placeholder="Joint thickness">
            <label for="calc-joint-unit" class="sr-only">Joint thickness unit</label>
            <select id="calc-joint-unit" name="joint-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'mm', 'cm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="type" label="Mortar type" :options="collect(config('construction_data.mortar'))->map(fn ($m) => $m['name'])->all()" selected="n" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="face_shell" label="Block face shell (hollow units)" value="1.25" min="0" placeholder="Block face shell (hollow units)">
            <label for="calc-face_shell-unit" class="sr-only">Block face shell (hollow units) unit</label>
            <select id="calc-face_shell-unit" name="face_shell-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'mm', 'cm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="waste" label="Extra for waste" value="15" min="0" max="100" suffix="%" />
    </div>

    <x-calc.result label="Mortar needed" />

    <x-calc.options :examples="[
        '200 ft² modular brick' => ['area' => 200, 'area-unit' => 'ft2', 'unit_type' => 'modular', 'joint' => 0.375, 'joint-unit' => 'in', 'type' => 'n', 'waste' => 15],
        '8 in block wall 320 ft²' => ['area' => 320, 'area-unit' => 'ft2', 'unit_type' => 'cmu_8', 'joint' => 0.375, 'joint-unit' => 'in', 'type' => 's', 'face_shell' => 1.25, 'face_shell-unit' => 'in', 'waste' => 15],
        'Queen brick 30 m²' => ['area' => 30, 'area-unit' => 'm2', 'unit_type' => 'queen', 'joint' => 10, 'joint-unit' => 'mm', 'type' => 'n', 'waste' => 15],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'units' => ['label' => 'Units'],
            'yd3' => ['label' => 'Volume'],
            'cement' => ['label' => 'Portland cement'],
            'lime' => ['label' => 'Hydrated lime'],
            'sand' => ['label' => 'Sand'],
            'proportion' => ['label' => 'Proportion'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>brick: per unit = W × ((L + j)(H + j) − L H)</li>
            <li>block: per unit = j × 2 shells × (L + j + H)</li>
            <li>ASTM C270: cement 94, lime 40, sand 80 lb/ft³</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
