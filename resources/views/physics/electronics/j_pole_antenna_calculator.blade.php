<x-calc.page
    title="J-Pole Antenna Calculator - SolveKit"
    description="Free J-pole antenna calculator: element lengths and feed point for any frequency."
    lede="Cut a J-pole antenna."
    about="A J-pole is an end-fed half-wave radiator matched by a quarter-wave stub. It is popular for VHF and UHF base stations."
    :calc="['engine' => 'ph-elec', 'tool' => 'jpole', 'fields' => ['f', 'vf', 'out'], 'unitFields' => ['f' => collect(config('units.frequency_hz'))->only(['hz', 'khz', 'mhz', 'ghz', 'thz', 'mhz_milli', 'rpm'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'frequency_hz', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'How long is a 2 m band J-pole at 146 MHz?', 'answer' => 'The long element is 146.303 cm.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="f" label="Frequency" value="146" min="0" placeholder="Frequency">
            <label for="calc-f-unit" class="sr-only">Frequency unit</label>
            <select id="calc-f-unit" name="f-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.frequency_hz'))->only(['hz', 'khz', 'mhz', 'ghz', 'thz', 'mhz_milli', 'rpm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mhz')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="vf" label="Velocity factor of the element" value="0.95" min="0" step="any" />
        <x-calc.select name="out" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'cm' => 'cm', 'mm' => 'mm', 'um' => 'µm', 'nm' => 'nm', 'mi' => 'mi', 'yd' => 'yd', 'ft' => 'ft', 'in' => 'in', 'nmi' => 'nmi']" selected="cm" />
    </div>

    <x-calc.result label="Long element" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'cm', 'f' => 146, 'f-unit' => 'mhz', 'vf' => 0.95],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'radiator' => ['label' => 'Half-wave radiator section'],
            'stub' => ['label' => 'Quarter-wave matching stub (short element)'],
            'feed' => ['label' => 'Feed point above the shorted end (start, then adjust)'],
            'gap' => ['label' => 'Element spacing'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
