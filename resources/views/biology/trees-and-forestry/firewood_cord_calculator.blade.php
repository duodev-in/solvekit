<x-calc.page
    title="Firewood Cord Calculator - SolveKit"
    description="Free firewood cord calculator: cords and face cords in a woodpile, with cost."
    lede="Work out how many cords of firewood are in a stack."
    about="A full cord is a stack 4 ft high, 4 ft deep and 8 ft long: 128 ft³. A face cord (or rick) is 4 × 8 ft but only one log-length deep, often 16 inches, so about a third of a cord."
    :calc="['engine' => 'forestry', 'tool' => 'cord', 'fields' => ['length', 'height', 'depth', 'price'], 'unitFields' => ['length' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'height' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'depth' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all()]]"
    :how-to="[
        ['name' => 'Measure the stack', 'text' => 'Length, height and depth (log length).'],
        ['name' => 'Add a price', 'text' => 'Optional, for the value of the stack.'],
    ]"
    :faqs="[
        ['question' => 'How big is a cord of wood?', 'answer' => '4 × 4 × 8 ft, or 128 ft³ stacked.'],
        ['question' => 'What is a face cord?', 'answer' => 'A 4 × 8 ft stack one log-length deep; with 16-inch logs it is one third of a cord.'],
        ['question' => 'How much wood heats a house for winter?', 'answer' => 'Often 3 to 6 cords, depending on climate and stove.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="length" label="Stack length" value="8" min="0" placeholder="Stack length">
            <label for="calc-length-unit" class="sr-only">Stack length unit</label>
            <select id="calc-length-unit" name="length-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="height" label="Height" value="4" min="0" placeholder="Height">
            <label for="calc-height-unit" class="sr-only">Height unit</label>
            <select id="calc-height-unit" name="height-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="depth" label="Depth" value="4" min="0" placeholder="Depth">
            <label for="calc-depth-unit" class="sr-only">Depth unit</label>
            <select id="calc-depth-unit" name="depth-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.field name="price" label="Price per cord (optional)" value="" min="0" step="0.01" suffix="$" placeholder="Optional" />

    <x-calc.result label="Firewood" />

    <x-calc.options :examples="[
        'Full cord' => ['length' => 8, 'height' => 4, 'depth' => 4],
        'Face cord 16 in logs' => ['length' => 8, 'height' => 4, 'depth' => 1.333],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'face' => ['label' => 'Face cords'],
            'steres' => ['label' => 'Stacked cubic meters (steres)', 'unit' => 'm³'],
            'cost' => ['label' => 'Cost'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>cords = length × height × depth ÷ 128 ft³</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
