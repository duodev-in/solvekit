<x-calc.page
    title="Electric Field Calculator - SolveKit"
    description="Free electric field calculator: field of a point charge or several charges anywhere in a plane."
    lede="Find the electric field."
    about="A point charge makes a field kq/r² pointing away from it if positive. For several charges the fields add as vectors."
    :calc="['engine' => 'ph-em', 'tool' => 'electric_field', 'fields' => ['mode', 'q', 'r', 'list', 'px', 'py', 'out'], 'unitFields' => ['q' => collect(config('units.charge'))->only(['c', 'mc', 'uc', 'nc', 'ah', 'mah', 'e'])->all(), 'r' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['charge', 'electric_field', 'energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the field 10 cm from 10 nC?', 'answer' => '8,987.55 V/m.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mode" label="Source" :options="['point' => 'One point charge', 'many' => 'Several point charges']" selected="point" />
        <div data-show-when="mode:point">
            <x-calc.field name="q" label="Charge" value="10" placeholder="Charge">
                <label for="calc-q-unit" class="sr-only">Charge unit</label>
                <select id="calc-q-unit" name="q-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.charge'))->only(['c', 'mc', 'uc', 'nc', 'ah', 'mah', 'e']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'nc')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:point">
            <x-calc.field name="r" label="Distance" value="10" placeholder="Distance">
                <label for="calc-r-unit" class="sr-only">Distance unit</label>
                <select id="calc-r-unit" name="r-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:many">
            <x-calc.textarea name="list" label="Charges: q in µC, x, y in metres (one per line)" value="1, 0, 0
-1, 0.1, 0" rows="3" />
        </div>
        <div data-show-when="mode:many">
            <x-calc.field name="px" label="Point x (m)" value="0.05" step="any" />
        </div>
        <div data-show-when="mode:many">
            <x-calc.field name="py" label="Point y (m)" value="0.05" step="any" />
        </div>
        <x-calc.select name="out" label="Show the result in" :options="['vpm' => 'V/m', 'kvpm' => 'kV/m', 'vpcm' => 'V/cm', 'kvpcm' => 'kV/cm', 'mvpm' => 'MV/m']" selected="vpm" />
    </div>

    <x-calc.result label="Electric field strength" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'vpm', 'mode' => 'point', 'q' => 10, 'q-unit' => 'nc', 'r' => 10, 'r-unit' => 'cm', 'list' => '1, 0, 0
-1, 0.1, 0', 'px' => 0.05, 'py' => 0.05],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'dir' => ['label' => 'Direction'],
            'F' => ['label' => 'Force on a proton there'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
