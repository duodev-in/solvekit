<x-calc.page
    title="Ape Index Calculator - SolveKit"
    description="Free ape index calculator: arm span compared with height."
    lede="Find your ape index."
    about="The ape index compares arm span with height. A positive index (longer arms) helps in climbing, swimming and boxing."
    :calc="['engine' => 'sp-fit', 'tool' => 'ape_index', 'fields' => ['span', 'h'], 'unitFields' => ['span' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'h' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the ape index for a 180 cm span and 175 cm height?', 'answer' => '1.029.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="span" label="Arm span (fingertip to fingertip)" value="180" placeholder="Arm span (fingertip to fingertip)">
            <label for="calc-span-unit" class="sr-only">Arm span (fingertip to fingertip) unit</label>
            <select id="calc-span-unit" name="span-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="h" label="Height" value="175" placeholder="Height">
            <label for="calc-h-unit" class="sr-only">Height unit</label>
            <select id="calc-h-unit" name="h-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Ape index" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['span' => 180, 'span-unit' => 'cm', 'h' => 175, 'h-unit' => 'cm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'diff' => ['label' => 'Span minus height'],
            'note' => ['label' => 'Meaning'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
