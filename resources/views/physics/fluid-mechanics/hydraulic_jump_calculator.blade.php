<x-calc.page
    title="Hydraulic Jump Calculator - SolveKit"
    description="Free hydraulic jump calculator: downstream depth, energy loss and jump type in a rectangular channel."
    lede="Find hydraulic jump depths."
    about="Fast shallow flow suddenly becomes slow and deep in a hydraulic jump, losing energy in turbulence. Spillways use jumps to protect riverbeds."
    :calc="['engine' => 'ph-fluid', 'tool' => 'hydraulic_jump', 'fields' => ['y1', 'v1', 'out'], 'unitFields' => ['y1' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'v1' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What depth follows 0.3 m at 6 m/s?', 'answer' => '1.34167 m.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="y1" label="Upstream depth" value="0.3" placeholder="Upstream depth">
            <label for="calc-y1-unit" class="sr-only">Upstream depth unit</label>
            <select id="calc-y1-unit" name="y1-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="v1" label="Upstream velocity" value="6" placeholder="Upstream velocity">
            <label for="calc-v1-unit" class="sr-only">Upstream velocity unit</label>
            <select id="calc-v1-unit" name="v1-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ms')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'cm' => 'cm', 'mm' => 'mm', 'um' => 'µm', 'nm' => 'nm', 'mi' => 'mi', 'yd' => 'yd', 'ft' => 'ft', 'in' => 'in', 'nmi' => 'nmi']" selected="m" />
    </div>

    <x-calc.result label="Downstream (sequent) depth" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'm', 'y1' => 0.3, 'y1-unit' => 'm', 'v1' => 6, 'v1-unit' => 'ms'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'Fr' => ['label' => 'Upstream Froude number'],
            'loss' => ['label' => 'Energy (head) loss'],
            'v2' => ['label' => 'Downstream velocity'],
            'type' => ['label' => 'Jump type'],
            'Lj' => ['label' => 'Approximate jump length'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
