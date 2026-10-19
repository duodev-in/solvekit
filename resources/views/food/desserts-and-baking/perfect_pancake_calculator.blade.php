<x-calc.page
    title="Perfect Pancake Calculator - SolveKit"
    description="Free pancake calculator: how many pancakes a bowl of batter makes, and how much batter each one needs, from pancake size and thickness."
    lede="Find how many pancakes your batter makes."
    about="A pancake is a thin cylinder: π ÷ 4 × diameter² × thickness. Batter rises about 1.4 times on the griddle, so ¼ cup of batter makes a 4 in (10 cm) pancake about ⅜ in (1 cm) thick. Thicker or wider pancakes need proportionally more."
    :calc="['engine' => 'fd-bake', 'tool' => 'pancake_count', 'fields' => ['batter', 'diameter', 'thickness'], 'unitFields' => ['batter' => collect(config('units.volume'))->only(['ml', 'floz_us', 'l', 'cup_us'])->all(), 'diameter' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'thickness' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Enter the batter', 'text' => ''],
        ['name' => 'Enter the size you like', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How many pancakes from 3 cups of batter?', 'answer' => '12 pancakes four-inch pancakes, 55.2 ml, about 3¾ tbsp each.'],
        ['question' => 'And 6 in pancakes?', 'answer' => '5 pancakes.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="batter" label="Batter" value="3" min="0" placeholder="Batter">
            <label for="calc-batter-unit" class="sr-only">Batter unit</label>
            <select id="calc-batter-unit" name="batter-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.volume'))->only(['ml', 'floz_us', 'l', 'cup_us']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'cup_us')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="diameter" label="Pancake diameter" value="4" min="0" placeholder="Pancake diameter">
            <label for="calc-diameter-unit" class="sr-only">Pancake diameter unit</label>
            <select id="calc-diameter-unit" name="diameter-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="thickness" label="Cooked thickness" value="0.375" min="0" placeholder="Cooked thickness">
            <label for="calc-thickness-unit" class="sr-only">Cooked thickness unit</label>
            <select id="calc-thickness-unit" name="thickness-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Pancakes" />

    <x-calc.options :decimals="false" :examples="[
        '3 cups' => ['batter' => 3, 'batter-unit' => 'cup_us', 'diameter' => 4, 'diameter-unit' => 'in', 'thickness' => 0.375, 'thickness-unit' => 'in'],
        '6 in' => ['batter' => 3, 'batter-unit' => 'cup_us', 'diameter' => 6, 'diameter-unit' => 'in', 'thickness' => 0.375, 'thickness-unit' => 'in'],
        'Metric' => ['batter' => 750, 'batter-unit' => 'ml', 'diameter' => 12, 'diameter-unit' => 'cm', 'thickness' => 1, 'thickness-unit' => 'cm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'per' => ['label' => 'Batter per pancake'],
            'leftover' => ['label' => 'Left over'],
            'servings' => ['label' => 'Servings'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>batter = π/4 × d² × t ÷ 1.4</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
