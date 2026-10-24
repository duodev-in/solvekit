<x-calc.page
    title="RAID Calculator - SolveKit"
    description="Free RAID calculator: usable capacity, fault tolerance and write penalty of RAID 0, 1, 5, 6, 10, 50 and 60."
    lede="Plan a RAID array."
    about="RAID levels trade capacity for redundancy and speed: RAID 5 survives one failed drive, RAID 6 two."
    :calc="['engine' => 'tc-elec', 'tool' => 'raid', 'fields' => ['level', 'drives', 'size', 'groups'], 'unitFields' => ['size' => collect(config('units.data'))->only(['b', 'kb', 'mb', 'gb', 'tb', 'kib', 'mib', 'gib', 'tib', 'bit'])->all()], 'data' => ['units' => collect(config('units'))->only(['data'])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'How much space do six 8 TB drives give in RAID 5?', 'answer' => '40 TB (36.38 TiB).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="level" label="RAID level" :options="['0' => 'RAID 0 (striping)', '1' => 'RAID 1 (mirror)', '5' => 'RAID 5 (single parity)', '6' => 'RAID 6 (double parity)', '10' => 'RAID 10 (striped mirrors)', '50' => 'RAID 50', '60' => 'RAID 60']" selected="5" />
        <x-calc.field name="drives" label="Number of drives" value="6" min="1" step="any" />
        <x-calc.field name="size" label="Size of each drive" value="8" min="0" placeholder="Size of each drive">
            <label for="calc-size-unit" class="sr-only">Size of each drive unit</label>
            <select id="calc-size-unit" name="size-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.data'))->only(['b', 'kb', 'mb', 'gb', 'tb', 'kib', 'mib', 'gib', 'tib', 'bit']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'tb')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <div data-show-when="level:50,60">
            <x-calc.field name="groups" label="Groups (RAID 50/60)" value="2" min="1" step="any" />
        </div>
    </div>

    <x-calc.result label="Usable capacity" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['level' => '5', 'drives' => 6, 'size' => 8, 'size-unit' => 'tb', 'groups' => 2],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'raw' => ['label' => 'Raw capacity'],
            'efficiency' => ['label' => 'Storage efficiency'],
            'tolerance' => ['label' => 'Drive failures survived'],
            'penalty' => ['label' => 'Write penalty (I/O per write)'],
            'reads' => ['label' => 'Read speed (× one drive, ideal)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
