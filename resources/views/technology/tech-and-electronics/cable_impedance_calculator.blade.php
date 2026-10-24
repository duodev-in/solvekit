<x-calc.page
    title="Cable Impedance Calculator - SolveKit"
    description="Free cable impedance calculator: characteristic impedance of coax and twisted pair from their dimensions, with velocity factor."
    lede="Find a cable’s impedance."
    about="A cable’s characteristic impedance depends on the ratio of its conductor sizes and on the insulation between them."
    :calc="['engine' => 'tc-elec', 'tool' => 'cable_impedance', 'fields' => ['type', 'D', 'd', 'er'], 'unitFields' => ['D' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'd' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['length'])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What impedance does RG-58 have?', 'answer' => 'About 51.701 Ω.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="type" label="Cable" :options="['coax' => 'Coaxial', 'pair' => 'Twisted or parallel pair']" selected="coax" />
        <x-calc.field name="D" label="Shield inner diameter D (coax) or wire spacing s (pair, centre to centre)" value="2.95" placeholder="Shield inner diameter D (coax) or wire spacing s (pair, centre to centre)">
            <label for="calc-D-unit" class="sr-only">Shield inner diameter D (coax) or wire spacing s (pair, centre to centre) unit</label>
            <select id="calc-D-unit" name="D-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="d" label="Inner conductor diameter d (or wire diameter)" value="0.81" placeholder="Inner conductor diameter d (or wire diameter)">
            <label for="calc-d-unit" class="sr-only">Inner conductor diameter d (or wire diameter) unit</label>
            <select id="calc-d-unit" name="d-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="er" label="Dielectric constant εr" value="2.25" min="1" step="any" />
    </div>

    <x-calc.result label="Characteristic impedance Z₀" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['type' => 'coax', 'D' => 2.95, 'D-unit' => 'mm', 'd' => 0.81, 'd-unit' => 'mm', 'er' => 2.25],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'vf' => ['label' => 'Velocity factor'],
            'cap' => ['label' => 'Capacitance per metre'],
            'ind' => ['label' => 'Inductance per metre'],
            'delay' => ['label' => 'Delay per metre'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
