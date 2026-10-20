<x-calc.page
    title="Inductors In Series Calculator - SolveKit"
    description="Free inductors in series calculator: total inductance with optional mutual coupling."
    lede="Add inductors in series."
    about="Inductors in series add, plus or minus twice the mutual inductance if their fields interact."
    :calc="['engine' => 'ph-elec', 'tool' => 'inductors_series', 'fields' => ['list', 'unit', 'M', 'aiding'], 'unitFields' => ['M' => collect(config('units.inductance'))->only(['h', 'mh', 'uh', 'nh'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'inductance', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is 10 mH plus 22 mH?', 'answer' => '32 mH.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.textarea name="list" label="Inductances (comma or line separated; suffixes allowed)" value="10, 22" rows="3" />
        <x-calc.select name="unit" label="Plain numbers are in" :options="['nh' => 'nH', 'uh' => 'µH', 'mh' => 'mH', 'h' => 'H']" selected="mh" />
        <x-calc.field name="M" label="Mutual inductance between two coils (optional)" value="0" min="0" placeholder="Mutual inductance between two coils (optional)">
            <label for="calc-M-unit" class="sr-only">Mutual inductance between two coils (optional) unit</label>
            <select id="calc-M-unit" name="M-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.inductance'))->only(['h', 'mh', 'uh', 'nh']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mh')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="aiding" label="Coupling" :options="['aiding' => 'Aiding (fields add)', 'opposing' => 'Opposing']" selected="aiding" />
    </div>

    <x-calc.result label="Total inductance" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['list' => '10, 22', 'unit' => 'mh', 'M' => 0, 'M-unit' => 'mh', 'aiding' => 'aiding'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'sum' => ['label' => 'Without coupling'],
            'k' => ['label' => 'Coupling coefficient (two coils)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
