<x-calc.page
    title="Pulley Calculator - SolveKit"
    description="Free pulley calculator: belt-drive speeds and ratios, or the pull needed with a block and tackle including friction."
    lede="Solve pulley speeds or lifting force."
    about="On a belt drive the belt speed is the same on both pulleys, so D₁n₁ = D₂n₂. A block and tackle divides the load among its supporting lines, less friction in each sheave."
    :calc="['engine' => 'ph-mach', 'tool' => 'pulley', 'fields' => ['mode', 'D1', 'n1', 'D2', 'W', 'lines', 'e'], 'unitFields' => ['D1' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'D2' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'W' => collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'How fast does a 250 mm pulley turn when driven by a 100 mm pulley at 1,450 rpm?', 'answer' => '580 rpm.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mode" label="Set-up" :options="['belt' => 'Two pulleys on a belt', 'block' => 'Block and tackle']" selected="belt" />
        <div data-show-when="mode:belt">
            <x-calc.field name="D1" label="Driver pulley diameter" value="100" placeholder="Driver pulley diameter">
                <label for="calc-D1-unit" class="sr-only">Driver pulley diameter unit</label>
                <select id="calc-D1-unit" name="D1-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:belt">
            <x-calc.field name="n1" label="Driver speed (rpm)" value="1450" min="0" step="any" />
        </div>
        <div data-show-when="mode:belt">
            <x-calc.field name="D2" label="Driven pulley diameter" value="250" placeholder="Driven pulley diameter">
                <label for="calc-D2-unit" class="sr-only">Driven pulley diameter unit</label>
                <select id="calc-D2-unit" name="D2-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:block">
            <x-calc.field name="W" label="Load" value="200" min="0" placeholder="Load">
                <label for="calc-W-unit" class="sr-only">Load unit</label>
                <select id="calc-W-unit" name="W-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:block">
            <x-calc.field name="lines" label="Supporting lines" value="4" min="1" step="any" />
        </div>
        <div data-show-when="mode:block">
            <x-calc.field name="e" label="Efficiency per sheave (%)" value="96" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Result" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'belt', 'D1' => 100, 'D1-unit' => 'mm', 'n1' => 1450, 'D2' => 250, 'D2-unit' => 'mm', 'W' => 200, 'W-unit' => 'kg', 'lines' => 4, 'e' => 96],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'a' => ['label' => 'Ratio'],
            'b' => ['label' => 'Detail'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
