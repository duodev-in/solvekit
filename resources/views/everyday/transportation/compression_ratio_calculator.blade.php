<x-calc.page
    title="Compression Ratio Calculator - SolveKit"
    description="Free compression ratio calculator: static compression ratio of an engine from bore, stroke, chamber, gasket, deck clearance and piston volume."
    lede="Work out an engine's static compression ratio."
    about="Compression ratio = (swept volume + clearance volume) ÷ clearance volume. Swept volume = π ÷ 4 × bore² × stroke. Clearance volume = chamber + head gasket (π ÷ 4 × gasket bore² × compressed thickness) + deck clearance (piston below the deck) + piston volume (positive for a dish or valve reliefs, negative for a dome)."
    :calc="['engine' => 'ev-transport', 'tool' => 'compression_ratio', 'fields' => ['bore', 'stroke', 'cylinders', 'chamber', 'piston', 'gasket_bore', 'gasket', 'deck'], 'unitFields' => ['bore' => collect(config('units.length'))->only(['mm', 'in', 'cm'])->all(), 'stroke' => collect(config('units.length'))->only(['mm', 'in', 'cm'])->all(), 'gasket_bore' => collect(config('units.length'))->only(['mm', 'in', 'cm'])->all(), 'gasket' => collect(config('units.length'))->only(['mm', 'in', 'cm'])->all(), 'deck' => collect(config('units.length'))->only(['mm', 'in', 'cm'])->all()]]"
    :how-to="[
        ['name' => 'Enter bore and stroke', 'text' => 'And the number of cylinders.'],
        ['name' => 'Enter the clearance volumes', 'text' => 'Chamber, piston, gasket and deck.'],
    ]"
    :faqs="[
        ['question' => 'How is compression ratio calculated?', 'answer' => '(Swept + clearance volume) ÷ clearance volume.'],
        ['question' => 'What does a thicker head gasket do?', 'answer' => 'It adds clearance volume and lowers the ratio.'],
        ['question' => 'Is a dome positive or negative?', 'answer' => 'Enter a dome as negative: it takes away clearance volume.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="bore" label="Bore" value="4.03" min="0" placeholder="Bore">
            <label for="calc-bore-unit" class="sr-only">Bore unit</label>
            <select id="calc-bore-unit" name="bore-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['mm', 'in', 'cm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="stroke" label="Stroke" value="3.48" min="0" placeholder="Stroke">
            <label for="calc-stroke-unit" class="sr-only">Stroke unit</label>
            <select id="calc-stroke-unit" name="stroke-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['mm', 'in', 'cm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="cylinders" label="Cylinders" value="8" min="1" step="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="chamber" label="Combustion chamber" value="64" min="1" suffix="cc" />
        <x-calc.field name="piston" label="Piston dish (+) or dome (−)" value="5" step="0.1" suffix="cc" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="gasket_bore" label="Gasket bore" value="4.1" min="0" placeholder="Gasket bore">
            <label for="calc-gasket_bore-unit" class="sr-only">Gasket bore unit</label>
            <select id="calc-gasket_bore-unit" name="gasket_bore-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['mm', 'in', 'cm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="gasket" label="Gasket thickness" value="0.04" min="0" placeholder="Gasket thickness">
            <label for="calc-gasket-unit" class="sr-only">Gasket thickness unit</label>
            <select id="calc-gasket-unit" name="gasket-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['mm', 'in', 'cm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="deck" label="Deck clearance" value="0.02" min="0" placeholder="Deck clearance">
            <label for="calc-deck-unit" class="sr-only">Deck clearance unit</label>
            <select id="calc-deck-unit" name="deck-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['mm', 'in', 'cm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Static compression ratio" />

    <x-calc.options :examples="[
        'Small-block V8' => ['bore' => 4.03, 'bore-unit' => 'in', 'stroke' => 3.48, 'stroke-unit' => 'in', 'cylinders' => 8, 'chamber' => 64, 'piston' => 5, 'gasket_bore' => 4.1, 'gasket_bore-unit' => 'in', 'gasket' => 0.04, 'gasket-unit' => 'in', 'deck' => 0.02, 'deck-unit' => 'in'],
        '2.0 L four, metric' => ['bore' => 86, 'bore-unit' => 'mm', 'stroke' => 86, 'stroke-unit' => 'mm', 'cylinders' => 4, 'chamber' => 42, 'piston' => -2, 'gasket_bore' => 88, 'gasket_bore-unit' => 'mm', 'gasket' => 1.1, 'gasket-unit' => 'mm', 'deck' => 0.2, 'deck-unit' => 'mm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'swept' => ['label' => 'Swept volume'],
            'clearance' => ['label' => 'Clearance volume'],
            'displacement' => ['label' => 'Displacement'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>CR = (V swept + V clearance) ÷ V clearance</li>
            <li>V swept = π/4 × bore² × stroke</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
