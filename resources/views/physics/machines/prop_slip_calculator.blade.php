<x-calc.page
    title="Prop Slip Calculator - SolveKit"
    description="Free propeller slip calculator: slip from pitch, rpm, gear ratio and actual boat speed."
    lede="Find propeller slip."
    about="Slip compares how far the boat actually moves with how far the propeller’s pitch says it should."
    :calc="['engine' => 'ph-mach', 'tool' => 'prop_slip', 'fields' => ['pitch', 'rpm', 'gear', 'v'], 'unitFields' => ['pitch' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'v' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the slip in the example?', 'answer' => '30.56%.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="pitch" label="Propeller pitch" value="21" placeholder="Propeller pitch">
            <label for="calc-pitch-unit" class="sr-only">Propeller pitch unit</label>
            <select id="calc-pitch-unit" name="pitch-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="rpm" label="Engine speed (rpm)" value="5000" min="0" step="any" />
        <x-calc.field name="gear" label="Gear ratio" value="2" min="0" step="any" />
        <x-calc.field name="v" label="Actual boat speed" value="30" placeholder="Actual boat speed">
            <label for="calc-v-unit" class="sr-only">Actual boat speed unit</label>
            <select id="calc-v-unit" name="v-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'knot')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Propeller slip" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['pitch' => 21, 'pitch-unit' => 'in', 'rpm' => 5000, 'gear' => 2, 'v' => 30, 'v-unit' => 'knot'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'theory' => ['label' => 'Theoretical speed'],
            'typical' => ['label' => 'Typical slip'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
