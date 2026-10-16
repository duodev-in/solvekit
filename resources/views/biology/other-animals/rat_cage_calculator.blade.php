<x-calc.page
    title="Rat Cage Calculator - SolveKit"
    description="Free rat cage calculator: how many pet rats fit in a cage from its width, depth and height."
    lede="Work out how many rats a cage can house."
    about="A common guide is about 2 cubic feet of cage per rat, using the outside width × depth × height. Rats are social and should live in at least pairs, and they climb, so tall cages with levels suit them."
    :calc="['engine' => 'animals', 'tool' => 'rat_cage', 'fields' => ['width', 'depth', 'height'], 'unitFields' => ['width' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'depth' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'height' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Measure the cage', 'text' => 'Width, depth and height.'],
        ['name' => 'Read the number', 'text' => 'At about 2 ft³ per rat.'],
    ]"
    :faqs="[
        ['question' => 'How much space does a rat need?', 'answer' => 'About 2 ft³ (57 L) each.'],
        ['question' => 'Can a rat live alone?', 'answer' => 'Rats are social and should be kept in pairs or groups of the same sex.'],
        ['question' => 'What bar spacing do rats need?', 'answer' => 'No more than ½ in for adults and ⅜ in for babies and small females.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="width" label="Width" value="36" min="0" placeholder="Width">
            <label for="calc-width-unit" class="sr-only">Width unit</label>
            <select id="calc-width-unit" name="width-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="depth" label="Depth" value="24" min="0" placeholder="Depth">
            <label for="calc-depth-unit" class="sr-only">Depth unit</label>
            <select id="calc-depth-unit" name="depth-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="height" label="Height" value="36" min="0" placeholder="Height">
            <label for="calc-height-unit" class="sr-only">Height unit</label>
            <select id="calc-height-unit" name="height-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Rats that fit" />

    <x-calc.options :examples="[
        'Large double cage' => ['width' => 36, 'width-unit' => 'in', 'depth' => 24, 'depth-unit' => 'in', 'height' => 36, 'height-unit' => 'in'],
        'Small cage' => ['width' => 24, 'width-unit' => 'in', 'depth' => 14, 'depth-unit' => 'in', 'height' => 18, 'height-unit' => 'in'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'volume' => ['label' => 'Cage volume'],
            'bars' => ['label' => 'Bar spacing'],
            'floor' => ['label' => 'Floors'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>ft³ = width × depth × height ÷ 1728 (inches)</li>
            <li>rats = ⌊ft³ ÷ 2⌋</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
