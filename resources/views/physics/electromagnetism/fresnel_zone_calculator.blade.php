<x-calc.page
    title="Fresnel Zone Calculator - SolveKit"
    description="Free Fresnel zone calculator: clearance radius for a radio link at any point along the path."
    lede="Find Fresnel zone clearance."
    about="A radio link needs more than line of sight: obstacles inside the first Fresnel zone reflect and diffract the signal. Keep at least 60% of it clear."
    :calc="['engine' => 'ph-em', 'tool' => 'fresnel', 'fields' => ['D', 'f', 'd1', 'n', 'out'], 'unitFields' => ['D' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'f' => collect(config('units.frequency_hz'))->only(['hz', 'khz', 'mhz', 'ghz', 'thz', 'mhz_milli', 'rpm'])->all(), 'd1' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'frequency_hz', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What radius at the middle of a 10 km 5.8 GHz link?', 'answer' => '11.3675 m.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="D" label="Link distance" value="10" placeholder="Link distance">
            <label for="calc-D-unit" class="sr-only">Link distance unit</label>
            <select id="calc-D-unit" name="D-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'km')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="f" label="Frequency" value="5.8" min="0" placeholder="Frequency">
            <label for="calc-f-unit" class="sr-only">Frequency unit</label>
            <select id="calc-f-unit" name="f-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.frequency_hz'))->only(['hz', 'khz', 'mhz', 'ghz', 'thz', 'mhz_milli', 'rpm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ghz')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="d1" label="Obstacle distance from one end" value="5" placeholder="Obstacle distance from one end">
            <label for="calc-d1-unit" class="sr-only">Obstacle distance from one end unit</label>
            <select id="calc-d1-unit" name="d1-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'km')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="n" label="Zone number" value="1" min="1" step="any" />
        <x-calc.select name="out" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'cm' => 'cm', 'mm' => 'mm', 'um' => 'µm', 'nm' => 'nm', 'mi' => 'mi', 'yd' => 'yd', 'ft' => 'ft', 'in' => 'in', 'nmi' => 'nmi']" selected="m" />
    </div>

    <x-calc.result label="Fresnel zone radius at the obstacle" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'm', 'D' => 10, 'D-unit' => 'km', 'f' => 5.8, 'f-unit' => 'ghz', 'd1' => 5, 'd1-unit' => 'km', 'n' => 1],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'clear' => ['label' => '60% clearance needed'],
            'max' => ['label' => 'Largest radius (mid-path)'],
            'earth' => ['label' => 'Earth bulge there (k = 4/3)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
