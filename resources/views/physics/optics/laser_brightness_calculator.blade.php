<x-calc.page
    title="Laser Brightness Calculator - SolveKit"
    description="Free laser brightness calculator: radiance of a laser beam in W/(m²·sr), compared with the Sun."
    lede="Find the radiance of a laser."
    about="Brightness (radiance) is power per area per solid angle. Because lasers are both small and highly directional, even a 5 mW pointer is far brighter than the Sun’s surface. Never look into a laser beam."
    :calc="['engine' => 'ph-wave', 'tool' => 'laser_brightness', 'fields' => ['P', 'w0', 'th'], 'unitFields' => ['P' => collect(config('units.power'))->only(['w', 'kw', 'mw', 'gw', 'milliwatt', 'hp', 'ps', 'btuh', 'tr', 'ftlbfs'])->all(), 'w0' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'th' => collect(config('units.angle'))->only(['deg', 'rad', 'arcmin', 'arcsec', 'mrad', 'turn'])->all()], 'data' => ['units' => collect(config('units'))->only(['angle', 'energy', 'force', 'length', 'mass', 'power', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'How bright is a 5 mW laser with a 0.5 mm waist and 0.5 mrad divergence?', 'answer' => '8,105,690,000 W/(m²·sr).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="P" label="Output power" value="5" min="0" placeholder="Output power">
            <label for="calc-P-unit" class="sr-only">Output power unit</label>
            <select id="calc-P-unit" name="P-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.power'))->only(['w', 'kw', 'mw', 'gw', 'milliwatt', 'hp', 'ps', 'btuh', 'tr', 'ftlbfs']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'milliwatt')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="w0" label="Waist radius w₀" value="0.5" placeholder="Waist radius w₀">
            <label for="calc-w0-unit" class="sr-only">Waist radius w₀ unit</label>
            <select id="calc-w0-unit" name="w0-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="th" label="Half-angle divergence" value="0.5" placeholder="Half-angle divergence">
            <label for="calc-th-unit" class="sr-only">Half-angle divergence unit</label>
            <select id="calc-th-unit" name="th-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.angle'))->only(['deg', 'rad', 'arcmin', 'arcsec', 'mrad', 'turn']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mrad')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Radiance (brightness)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['P' => 5, 'P-unit' => 'milliwatt', 'w0' => 0.5, 'w0-unit' => 'mm', 'th' => 0.5, 'th-unit' => 'mrad'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'sun' => ['label' => 'Compared with the Sun’s surface'],
            'intensity' => ['label' => 'Peak irradiance at the waist'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
