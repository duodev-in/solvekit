<x-calc.page
    title="Pipe Weight Calculator - SolveKit"
    description="Free pipe weight calculator: weight of steel pipe per foot by NPS and schedule (ASME B36.10M), or any OD and wall, empty or full of water, with a check-your-answer mode."
    lede="Work out the weight of pipe by size and schedule, or from its OD and wall."
    about="Pipe weight per length = π ÷ 4 × (OD² − ID²) × density. Outside diameters and walls for schedules 10, STD, 40, XS, 80, 160 and XXS are from ASME B36.10M. For carbon steel this matches the familiar 10.69 × (OD − t) × t lb/ft. Enter your own answer to check a calculation."
    :calc="['engine' => 'con-weight', 'tool' => 'pipe_weight', 'fields' => ['mode', 'nps', 'schedule', 'od', 'wall', 'length', 'count', 'metal', 'density', 'answer'], 'unitFields' => ['od' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'wall' => collect(config('units.length'))->only(['in', 'mm', 'cm'])->all(), 'length' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'density' => collect(config('units.density'))->only(['lbft3', 'kgm3', 'gcm3'])->all(), 'answer' => collect(config('units.mass'))->only(['lb', 'kg'])->all()], 'data' => ['metals' => config('construction_data.metals'), 'pipe' => config('construction_data.pipe')]]"
    :how-to="[
        ['name' => 'Pick the size and schedule', 'text' => 'Or enter OD and wall.'],
        ['name' => 'Enter the length', 'text' => 'And the number of pieces.'],
        ['name' => 'Check an answer', 'text' => 'Optional: type your own weight to check it.'],
    ]"
    :faqs="[
        ['question' => 'How much does 2 in schedule 40 pipe weigh?', 'answer' => '3.65 lb per foot.'],
        ['question' => 'What is the difference between STD and schedule 40?', 'answer' => 'They are the same up to NPS 10; above that STD stays at 0.375 in wall.'],
        ['question' => 'Why does NPS not equal the outside diameter?', 'answer' => 'NPS is a nominal size; from NPS 14 up the OD equals the NPS in inches.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Pipe" :options="['table' => 'NPS and schedule', 'custom' => 'OD and wall']" selected="table" />

    <div data-show-when="mode:table">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.select name="nps" label="Nominal pipe size" :options="collect(config('construction_data.pipe.sizes'))->mapWithKeys(fn ($p, $k) => [$k => 'NPS '.$k.' ('.$p['od'].' in OD)'])->all()" selected="2" />
            <x-calc.select name="schedule" label="Schedule" :options="config('construction_data.pipe.schedules')" selected="40" />
        </div>
    </div>

    <div data-show-when="mode:custom" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="od" label="Outside diameter" value="2.375" min="0" placeholder="Outside diameter">
                <label for="calc-od-unit" class="sr-only">Outside diameter unit</label>
                <select id="calc-od-unit" name="od-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
            <x-calc.field name="wall" label="Wall thickness" value="0.154" min="0" placeholder="Wall thickness">
                <label for="calc-wall-unit" class="sr-only">Wall thickness unit</label>
                <select id="calc-wall-unit" name="wall-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['in', 'mm', 'cm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="length" label="Length" value="21" min="0" placeholder="Length">
            <label for="calc-length-unit" class="sr-only">Length unit</label>
            <select id="calc-length-unit" name="length-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="count" label="Pieces" value="1" min="1" step="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="metal" label="Material" :options="collect(config('construction_data.metals'))->map(fn ($m) => $m['name'])->all()" selected="steel" />
        <x-calc.field name="density" label="Your density (optional)" value="" min="0" placeholder="Your density (optional)">
            <label for="calc-density-unit" class="sr-only">Your density (optional) unit</label>
            <select id="calc-density-unit" name="density-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.density'))->only(['lbft3', 'kgm3', 'gcm3']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'gcm3')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.field name="answer" label="Your answer, to check (optional)" value="" min="0" placeholder="Your answer, to check (optional)">
        <label for="calc-answer-unit" class="sr-only">Your answer, to check (optional) unit</label>
        <select id="calc-answer-unit" name="answer-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
            @foreach(collect(config('units.mass'))->only(['lb', 'kg']) as $key => $unit)
                <option value="{{ $key }}" @selected($key === 'lb')>{{ $unit['symbol'] }}</option>
            @endforeach
        </select>
    </x-calc.field>

    <x-calc.result label="Pipe weight" />

    <x-calc.options :examples="[
        'NPS 2 sch 40, 21 ft' => ['mode' => 'table', 'nps' => '2', 'schedule' => '40', 'length' => 21, 'length-unit' => 'ft', 'count' => 1, 'metal' => 'steel'],
        'NPS 6 sch 80, full of water' => ['mode' => 'table', 'nps' => '6', 'schedule' => '80', 'length' => 20, 'length-unit' => 'ft', 'count' => 1, 'metal' => 'steel'],
        'Stainless tube 60.3 × 2.77 mm' => ['mode' => 'custom', 'od' => 60.3, 'od-unit' => 'mm', 'wall' => 2.77, 'wall-unit' => 'mm', 'length' => 6, 'length-unit' => 'm', 'count' => 1, 'metal' => 'stainless_304'],
        'Check: NPS 4 sch 40, 10 ft' => ['mode' => 'table', 'nps' => '4', 'schedule' => '40', 'length' => 10, 'length-unit' => 'ft', 'count' => 1, 'metal' => 'steel', 'answer' => 108, 'answer-unit' => 'lb'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'per_foot' => ['label' => 'Per foot'],
            'id' => ['label' => 'Inside diameter'],
            'od' => ['label' => 'Size'],
            'water' => ['label' => 'Water inside'],
            'filled' => ['label' => 'Full of water'],
            'density' => ['label' => 'Density'],
            'answer' => ['label' => 'Your answer'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>ID = OD − 2t</li>
            <li>w = π ÷ 4 × (OD² − ID²) × ρ</li>
            <li>carbon steel: 10.69 (OD − t) t lb/ft</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
