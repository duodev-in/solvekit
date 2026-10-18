<x-calc.page
    title="Pipe Volume Calculator - SolveKit"
    description="Free pipe volume calculator: gallons and liters of water a pipe holds from its inside diameter or NPS and schedule, and its length."
    lede="Work out how much water a pipe holds."
    about="Volume = π ÷ 4 × inside diameter² × length. For steel pipe, the inside diameter comes from the ASME B36.10M outside diameter and wall for the schedule you choose."
    :calc="['engine' => 'con-water', 'tool' => 'pipe_volume', 'fields' => ['mode', 'id', 'nps', 'schedule', 'length'], 'unitFields' => ['id' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'length' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all()], 'data' => ['pipe' => config('construction_data.pipe')]]"
    :how-to="[
        ['name' => 'Enter the inside diameter', 'text' => 'Or pick a steel pipe size.'],
        ['name' => 'Enter the length', 'text' => 'Of the run.'],
    ]"
    :faqs="[
        ['question' => 'How many gallons in 100 ft of 2 in pipe?', 'answer' => 'About 16.3 gallons for a 2 in bore.'],
        ['question' => 'How much water in 1 in pipe per foot?', 'answer' => 'About 0.041 gal per foot for a 1 in bore.'],
        ['question' => 'Why use the inside diameter?', 'answer' => 'The water fills the bore, not the wall.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Pipe" :options="['id' => 'Inside diameter', 'nps' => 'NPS and schedule']" selected="id" />

    <div data-show-when="mode:id">
        <x-calc.field name="id" label="Inside diameter" value="2" min="0" placeholder="Inside diameter">
            <label for="calc-id-unit" class="sr-only">Inside diameter unit</label>
            <select id="calc-id-unit" name="id-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div data-show-when="mode:nps" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.select name="nps" label="Nominal pipe size" :options="collect(config('construction_data.pipe.sizes'))->mapWithKeys(fn ($p, $k) => [$k => 'NPS '.$k])->all()" selected="2" />
            <x-calc.select name="schedule" label="Schedule" :options="config('construction_data.pipe.schedules')" selected="40" />
        </div>
    </div>

    <x-calc.field name="length" label="Length" value="100" min="0" placeholder="Length">
        <label for="calc-length-unit" class="sr-only">Length unit</label>
        <select id="calc-length-unit" name="length-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
            @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
            @endforeach
        </select>
    </x-calc.field>

    <x-calc.result label="Pipe volume" />

    <x-calc.options :examples="[
        '2 in bore, 100 ft' => ['mode' => 'id', 'id' => 2, 'id-unit' => 'in', 'length' => 100, 'length-unit' => 'ft'],
        'NPS 4 sch 40, 50 ft' => ['mode' => 'nps', 'nps' => '4', 'schedule' => '40', 'length' => 50, 'length-unit' => 'ft'],
        '25 mm, 30 m' => ['mode' => 'id', 'id' => 25, 'id-unit' => 'mm', 'length' => 30, 'length-unit' => 'm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'per_foot' => ['label' => 'Per length'],
            'id' => ['label' => 'Inside diameter'],
            'liters' => ['label' => 'Liters'],
            'ft3' => ['label' => 'Cubic feet'],
            'weight' => ['label' => 'Water weight'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>V = π ÷ 4 × ID² × L</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
