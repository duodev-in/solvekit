<x-calc.page
    title="Prop Pitch Calculator - SolveKit"
    description="Free propeller pitch calculator: the pitch needed for a boat speed at a given rpm, gear ratio and slip."
    lede="Find the propeller pitch you need."
    about="Pitch is how far a propeller would advance per turn in a solid. Real boats slip, so pitch = speed ÷ (prop rpm × (1 − slip))."
    :calc="['engine' => 'ph-mach', 'tool' => 'prop_pitch', 'fields' => ['v', 'rpm', 'gear', 'slip', 'out'], 'unitFields' => ['v' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What pitch gives 30 knots at 5,000 rpm with a 2:1 gearbox?', 'answer' => '16.203 in.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="v" label="Boat speed" value="30" placeholder="Boat speed">
            <label for="calc-v-unit" class="sr-only">Boat speed unit</label>
            <select id="calc-v-unit" name="v-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'knot')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="rpm" label="Engine speed (rpm)" value="5000" min="0" step="any" />
        <x-calc.field name="gear" label="Gear ratio" value="2" min="0" step="any" />
        <x-calc.field name="slip" label="Slip (%)" value="10" min="0" step="any" />
        <x-calc.select name="out" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'cm' => 'cm', 'mm' => 'mm', 'um' => 'µm', 'nm' => 'nm', 'mi' => 'mi', 'yd' => 'yd', 'ft' => 'ft', 'in' => 'in', 'nmi' => 'nmi']" selected="in" />
    </div>

    <x-calc.result label="Propeller pitch" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'in', 'v' => 30, 'v-unit' => 'knot', 'rpm' => 5000, 'gear' => 2, 'slip' => 10],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'prpm' => ['label' => 'Propeller rpm'],
            'theory' => ['label' => 'Theoretical speed for that pitch'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
