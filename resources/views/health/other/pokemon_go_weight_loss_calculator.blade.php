<x-calc.page
    title="Pokémon GO Weight Loss Calculator - SolveKit"
    description="Free Pokémon GO calculator: the distance you walked hatching eggs and the calories it burned."
    lede="Count the calories behind your egg hatches."
    about="Eggs hatch after 2, 5, 7, 10 or 12 km of walking. The calories use the Compendium of Physical Activities (walking 3 mph = 3.5 METs): METs × body weight × hours. The fat equivalent uses the 7,700 kcal per kg rule of thumb. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-life', 'tool' => 'pokemon', 'fields' => ['eggs2', 'eggs5', 'eggs7', 'eggs10', 'eggs12', 'extra_km', 'weight', 'pace', 'height'], 'unitFields' => ['weight' => collect(config('units.mass'))->only(['kg', 'lb', 'st'])->all(), 'height' => collect(config('units.length'))->only(['cm', 'in', 'ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Enter the eggs you hatched', 'text' => ''],
        ['name' => 'Enter your weight and pace', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How many calories did four 2 km, three 5 km, one 7 km and one 10 km egg burn?', 'answer' => '2,144 kcal.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="eggs2" label="2 km eggs" value="4" min="0" step="1" />
        <x-calc.field name="eggs5" label="5 km eggs" value="3" min="0" step="1" />
        <x-calc.field name="eggs7" label="7 km eggs" value="1" min="0" step="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="eggs10" label="10 km eggs" value="1" min="0" step="1" />
        <x-calc.field name="eggs12" label="12 km eggs" value="0" min="0" step="1" />
        <x-calc.field name="extra_km" label="Other walking (km)" value="2" min="0" step="any" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="weight" label="Weight" value="70" min="0" placeholder="Weight">
            <label for="calc-weight-unit" class="sr-only">Weight unit</label>
            <select id="calc-weight-unit" name="weight-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'lb', 'st']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="pace" label="Pace" :options="['slow' => 'Slow (2 mph, 3.2 km/h)', 'moderate' => 'Moderate (3 mph, 4.8 km/h)', 'brisk' => 'Brisk (3.5 mph, 5.6 km/h)', 'fast' => 'Fast (4 mph, 6.4 km/h)']" selected="moderate" />
    </div>

    <x-calc.field name="height" label="Height" value="170" min="0" placeholder="Height">
        <label for="calc-height-unit" class="sr-only">Height unit</label>
        <select id="calc-height-unit" name="height-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
            @foreach(collect(config('units.length'))->only(['cm', 'in', 'ft', 'm']) as $key => $unit)
                <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
            @endforeach
        </select>
    </x-calc.field>

    <x-calc.result label="Calories burned walking" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['eggs2' => 4, 'eggs5' => 3, 'eggs7' => 1, 'eggs10' => 1, 'eggs12' => 0, 'extra_km' => 2, 'weight' => 70, 'weight-unit' => 'kg', 'pace' => 'moderate', 'height' => 170, 'height-unit' => 'cm'],
        'Big week' => ['eggs2' => 0, 'eggs5' => 6, 'eggs7' => 2, 'eggs10' => 2, 'eggs12' => 1, 'extra_km' => 0, 'weight' => 80, 'weight-unit' => 'kg', 'pace' => 'brisk', 'height' => 180, 'height-unit' => 'cm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'distance' => ['label' => 'Distance'],
            'time' => ['label' => 'Time'],
            'steps' => ['label' => 'Steps'],
            'net' => ['label' => 'Above resting'],
            'fat' => ['label' => 'Fat equivalent'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>km = Σ eggs × distance</li>
            <li>kcal = METs × kg × h</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
