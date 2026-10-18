<x-calc.page
    title="Thinset Calculator - SolveKit"
    description="Free thinset calculator: 50 lb bags of thin-set mortar for a tile area by trowel notch size, from manufacturer coverage data."
    lede="Work out how many bags of thinset you need."
    about="Coverage per 50 lb bag depends on the trowel: Custom Building Products data sheets list 85–95 ft² for a ¼ × ¼ in square notch and 60–67 ft² for ¼ × ⅜ in. Large tiles often need back-buttering, which uses roughly a quarter more. For other trowels, enter the coverage printed on your bag."
    :calc="['engine' => 'con-concrete', 'tool' => 'thinset', 'fields' => ['area', 'trowel', 'coverage', 'waste', 'back_butter'], 'unitFields' => ['area' => collect(config('units.area'))->only(['ft2', 'yd2', 'm2', 'acre', 'ha'])->all()], 'data' => ['trowels' => config('construction_data.trowels') + ['custom' => null]]]"
    :how-to="[
        ['name' => 'Enter the tile area', 'text' => 'Add waste for cuts.'],
        ['name' => 'Choose the trowel', 'text' => 'Or type your bag\'s coverage.'],
    ]"
    :faqs="[
        ['question' => 'How much does a bag of thinset cover?', 'answer' => '85–95 ft² with a ¼ × ¼ in square notch, 60–67 ft² with ¼ × ⅜ in.'],
        ['question' => 'Which trowel for 12 in tile?', 'answer' => '¼ × ⅜ in square notch is common for 12 in tile; check the tile maker\'s advice.'],
        ['question' => 'What is back-buttering?', 'answer' => 'Spreading a thin coat on the back of the tile too, for full coverage under large tiles.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="area" label="Tile area" value="120" min="0" placeholder="Tile area">
            <label for="calc-area-unit" class="sr-only">Tile area unit</label>
            <select id="calc-area-unit" name="area-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.area'))->only(['ft2', 'yd2', 'm2', 'acre', 'ha']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft2')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="trowel" label="Trowel" :options="collect(config('construction_data.trowels'))->map(fn ($t) => $t['name'].' ('.$t['min'].'–'.$t['max'].' ft²)')->all() + ['custom' => 'Coverage from my bag']" selected="1/4x1/4" />
    </div>

    <div data-show-when="trowel:custom" hidden>
        <x-calc.field name="coverage" label="Coverage per bag" value="50" min="1" suffix="ft²" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="waste" label="Extra for waste" value="10" min="0" max="100" suffix="%" />
        <x-calc.checkbox name="back_butter" label="Back-butter the tiles (+25%)" :checked="false" />
    </div>

    <x-calc.result label="Thinset (50 lb bags)" />

    <x-calc.options :examples="[
        '120 ft², ¼ × ¼ notch' => ['area' => 120, 'area-unit' => 'ft2', 'trowel' => '1/4x1/4', 'waste' => 10, 'back_butter' => false],
        '200 ft², ¼ × ⅜ notch' => ['area' => 200, 'area-unit' => 'ft2', 'trowel' => '1/4x3/8', 'waste' => 10, 'back_butter' => false],
        'Large tile, back-buttered' => ['area' => 15, 'area-unit' => 'm2', 'trowel' => 'custom', 'coverage' => 40, 'waste' => 10, 'back_butter' => true],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'coverage' => ['label' => 'Coverage'],
            'area' => ['label' => 'Area'],
            'weight' => ['label' => 'Weight'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>bags = area × (1 + waste) ÷ coverage per bag</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
