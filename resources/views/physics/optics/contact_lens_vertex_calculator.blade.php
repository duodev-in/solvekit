<x-calc.page
    title="Contact Lens Vertex Calculator - SolveKit"
    description="Free contact lens vertex calculator: convert a glasses prescription to contact lens power, including cylinder."
    lede="Convert glasses power to contact lens power."
    about="Glasses sit about 12 mm in front of the eye, contact lenses on it. Moving a lens changes its effective power, F_c = F ÷ (1 − dF), which matters above about ±4 D. Each principal meridian is converted separately. This is an optics calculation, not a prescription."
    :calc="['engine' => 'ph-wave', 'tool' => 'contact_vertex', 'fields' => ['S', 'C', 'axis', 'd'], 'unitFields' => ['d' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What contact lens power matches −5.00 / −1.50 glasses?', 'answer' => '−4.75 / −1.25 × 180.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="S" label="Spectacle sphere (D)" value="-5" step="any" />
        <x-calc.field name="C" label="Spectacle cylinder (D)" value="-1.5" step="any" />
        <x-calc.field name="axis" label="Axis (degrees)" value="180" step="any" />
        <x-calc.field name="d" label="Vertex distance" value="12" placeholder="Vertex distance">
            <label for="calc-d-unit" class="sr-only">Vertex distance unit</label>
            <select id="calc-d-unit" name="d-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Contact lens sphere" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['S' => -5, 'C' => -1.5, 'axis' => 180, 'd' => 12, 'd-unit' => 'mm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'cyl' => ['label' => 'Contact lens cylinder'],
            'rounded' => ['label' => 'Rounded to 0.25 D steps'],
            'note' => ['label' => 'Note'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
