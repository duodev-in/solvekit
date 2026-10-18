<x-calc.page
    title="Glass Weight Calculator - SolveKit"
    description="Free glass weight calculator: weight of float, tempered, laminated or borosilicate glass panes from their size and thickness."
    lede="Work out the weight of glass panes."
    about="Weight = area × thickness × density. Float glass (clear, tinted, tempered or low-iron) is 2.5 g/cm³ (EN 572-1), so it weighs 2.5 kg per m² per mm of thickness, about 13 lb/ft² per inch. Borosilicate is 2.23 g/cm³. Laminated glass adds a PVB interlayer at about 1.07 g/cm³."
    :calc="['engine' => 'con-weight', 'tool' => 'glass_weight', 'fields' => ['length', 'width', 'thickness', 'count', 'glass', 'plies', 'interlayer'], 'unitFields' => ['length' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'width' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'thickness' => collect(config('units.length'))->only(['in', 'mm', 'cm'])->all(), 'interlayer' => collect(config('units.length'))->only(['in', 'mm', 'cm'])->all()], 'data' => ['glass' => config('construction_data.glass')]]"
    :how-to="[
        ['name' => 'Enter the pane size', 'text' => 'Height, width and thickness.'],
        ['name' => 'Set plies for laminated glass', 'text' => 'And the interlayer thickness.'],
    ]"
    :faqs="[
        ['question' => 'How much does glass weigh per square foot?', 'answer' => 'About 3.27 lb/ft² for ¼ in (6 mm) float glass.'],
        ['question' => 'Does tempered glass weigh more?', 'answer' => 'No, tempering does not change the density.'],
        ['question' => 'How much does a 6 mm sheet weigh per m²?', 'answer' => '15 kg/m².'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="length" label="Height" value="48" min="0" placeholder="Height">
            <label for="calc-length-unit" class="sr-only">Height unit</label>
            <select id="calc-length-unit" name="length-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="width" label="Width" value="36" min="0" placeholder="Width">
            <label for="calc-width-unit" class="sr-only">Width unit</label>
            <select id="calc-width-unit" name="width-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="thickness" label="Thickness of each ply" value="6" min="0" placeholder="Thickness of each ply">
            <label for="calc-thickness-unit" class="sr-only">Thickness of each ply unit</label>
            <select id="calc-thickness-unit" name="thickness-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'mm', 'cm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="count" label="Panes" value="1" min="1" step="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="glass" label="Glass" :options="collect(config('construction_data.glass'))->map(fn ($g) => $g['name'])->all()" selected="soda_lime" />
        <x-calc.field name="plies" label="Plies (laminated)" value="1" min="1" step="1" />
    </div>

    <div data-show-when="plies:2,3,4,5" hidden>
        <x-calc.field name="interlayer" label="Interlayer thickness" value="0.76" min="0" placeholder="Interlayer thickness">
            <label for="calc-interlayer-unit" class="sr-only">Interlayer thickness unit</label>
            <select id="calc-interlayer-unit" name="interlayer-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'mm', 'cm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Glass weight" />

    <x-calc.options :examples="[
        'Window 48 × 36 in, 6 mm' => ['length' => 48, 'length-unit' => 'in', 'width' => 36, 'width-unit' => 'in', 'thickness' => 6, 'thickness-unit' => 'mm', 'count' => 1, 'glass' => 'soda_lime', 'plies' => 1],
        'Laminated 2 × 6 mm' => ['length' => 2000, 'length-unit' => 'mm', 'width' => 1000, 'width-unit' => 'mm', 'thickness' => 6, 'thickness-unit' => 'mm', 'count' => 1, 'glass' => 'soda_lime', 'plies' => 2, 'interlayer' => 1.52, 'interlayer-unit' => 'mm'],
        'Shelf ⅜ in, 4 pieces' => ['length' => 36, 'length-unit' => 'in', 'width' => 12, 'width-unit' => 'in', 'thickness' => 0.375, 'thickness-unit' => 'in', 'count' => 4, 'glass' => 'soda_lime', 'plies' => 1],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'pane' => ['label' => 'Each pane'],
            'per_area' => ['label' => 'Per area'],
            'area' => ['label' => 'Area'],
            'interlayer' => ['label' => 'Interlayer'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>weight = area × thickness × plies × 2500 kg/m³ (+ interlayer × 1070 kg/m³)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
