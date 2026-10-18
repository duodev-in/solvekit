<x-calc.page
    title="Roll Length Calculator - SolveKit"
    description="Free roll length calculator: the length of paper, tape, film, fabric or cable on a roll from its outer diameter, core diameter and material thickness."
    lede="Work out how much material is left on a roll."
    about="The material's cross-section is a ring: π ÷ 4 × (D² − d²). Dividing by the thickness gives the length: L = π (D² − d²) ÷ (4t). It assumes tight winding; measure thickness by measuring a stack of layers and dividing."
    :calc="['engine' => 'ev-home', 'tool' => 'roll_length', 'fields' => ['outer', 'core', 'thickness'], 'unitFields' => ['outer' => collect(config('units.length'))->only(['mm', 'in', 'cm'])->all(), 'core' => collect(config('units.length'))->only(['mm', 'in', 'cm'])->all(), 'thickness' => collect(config('units.length'))->only(['mm', 'in', 'cm'])->all()]]"
    :how-to="[
        ['name' => 'Measure the diameters', 'text' => 'Outside and the core.'],
        ['name' => 'Enter the thickness', 'text' => 'Of one layer.'],
    ]"
    :faqs="[
        ['question' => 'How long is a 120 mm roll on a 76 mm core at 0.1 mm?', 'answer' => 'About 67.7 m.'],
        ['question' => 'How do I measure thin material?', 'answer' => 'Measure 10 layers and divide by 10.'],
        ['question' => 'Does it work for tape?', 'answer' => 'Yes, any wound material.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="outer" label="Outer diameter" value="120" min="0" placeholder="Outer diameter">
            <label for="calc-outer-unit" class="sr-only">Outer diameter unit</label>
            <select id="calc-outer-unit" name="outer-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['mm', 'in', 'cm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="core" label="Core diameter" value="76" min="0" placeholder="Core diameter">
            <label for="calc-core-unit" class="sr-only">Core diameter unit</label>
            <select id="calc-core-unit" name="core-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['mm', 'in', 'cm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="thickness" label="Thickness" value="0.1" min="0" placeholder="Thickness">
            <label for="calc-thickness-unit" class="sr-only">Thickness unit</label>
            <select id="calc-thickness-unit" name="thickness-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['mm', 'in', 'cm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Length on the roll" />

    <x-calc.options :examples="[
        'Paper roll' => ['outer' => 120, 'outer-unit' => 'mm', 'core' => 76, 'core-unit' => 'mm', 'thickness' => 0.1, 'thickness-unit' => 'mm'],
        'Plastic film, inches' => ['outer' => 8, 'outer-unit' => 'in', 'core' => 3, 'core-unit' => 'in', 'thickness' => 0.002, 'thickness-unit' => 'in'],
        'Fabric bolt' => ['outer' => 25, 'outer-unit' => 'cm', 'core' => 5, 'core-unit' => 'cm', 'thickness' => 0.5, 'thickness-unit' => 'mm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'feet' => ['label' => 'In feet'],
            'wraps' => ['label' => 'Wraps'],
            'note' => ['label' => 'Assumption'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>L = π (D² − d²) ÷ (4 t)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
