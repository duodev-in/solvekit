<x-calc.page
    title="Round Pool Volume Calculator - SolveKit"
    description="Free round pool volume calculator: gallons and liters in an above-ground or round pool from its diameter and water depth."
    lede="Work out how many gallons a round pool holds."
    about="A round pool holds π ÷ 4 × diameter² × water depth. Use the water depth, usually a few inches below the top wall."
    :calc="['engine' => 'con-water', 'tool' => 'round_pool', 'fields' => ['diameter', 'depth', 'flow'], 'unitFields' => ['diameter' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'depth' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Enter the diameter', 'text' => 'Inside the wall.'],
        ['name' => 'Enter the water depth', 'text' => 'Not the wall height.'],
    ]"
    :faqs="[
        ['question' => 'How many gallons in a 24 ft round pool 4 ft deep?', 'answer' => 'About 13,500 gallons.'],
        ['question' => 'How many gallons in a 15 ft pool 48 in deep?', 'answer' => 'About 5,300 gallons.'],
        ['question' => 'How much does the water weigh?', 'answer' => 'About 8.33 lb per gallon.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="diameter" label="Diameter" value="24" min="0" placeholder="Diameter">
            <label for="calc-diameter-unit" class="sr-only">Diameter unit</label>
            <select id="calc-diameter-unit" name="diameter-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="depth" label="Water depth" value="48" min="0" placeholder="Water depth">
            <label for="calc-depth-unit" class="sr-only">Water depth unit</label>
            <select id="calc-depth-unit" name="depth-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="flow" label="Fill rate (optional)" value="10" min="0" suffix="gal/min" />
    </div>

    <x-calc.result label="Pool volume" />

    <x-calc.options :examples="[
        '24 ft, 48 in' => ['diameter' => 24, 'diameter-unit' => 'ft', 'depth' => 48, 'depth-unit' => 'in', 'flow' => 10],
        '15 ft, 42 in' => ['diameter' => 15, 'diameter-unit' => 'ft', 'depth' => 42, 'depth-unit' => 'in', 'flow' => 8],
        '4.5 m, 1.1 m' => ['diameter' => 4.5, 'diameter-unit' => 'm', 'depth' => 1.1, 'depth-unit' => 'm', 'flow' => 0],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'liters' => ['label' => 'Liters'],
            'ft3' => ['label' => 'Cubic feet'],
            'weight' => ['label' => 'Water weight'],
            'fill' => ['label' => 'Fill time'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>V = π ÷ 4 × D² × depth</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
