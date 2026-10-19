<x-calc.page
    title="Egg Boiling Calculator - SolveKit"
    description="Free egg boiling calculator: boiling time for soft, jammy, medium or hard-boiled eggs by size, fridge or room temperature and altitude."
    lede="Find how long to boil eggs."
    about="Times start from tested kitchen guides for a large egg straight from the fridge lowered into boiling water at sea level (6 minutes soft, 7 jammy, 9 medium, 11 hard), then scale with the Williams heat-conduction model for egg size, starting temperature and the lower boiling point at altitude. Steaming takes about as long. Cool the eggs in ice water to stop the cooking. Times are guides: check doneness with a food thermometer."
    :calc="['engine' => 'fd-other', 'tool' => 'egg_boil', 'fields' => ['size', 'doneness', 'start', 'altitude'], 'unitFields' => ['altitude' => collect(config('units.length'))->only(['ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Choose the egg size and doneness', 'text' => ''],
        ['name' => 'Say where the eggs start', 'text' => ''],
        ['name' => 'Enter your altitude', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How long to hard boil a large egg?', 'answer' => '11 min.'],
        ['question' => 'A jammy egg at 5,000 ft?', 'answer' => '8 min.'],
        ['question' => 'Soft-boiled from room temperature?', 'answer' => '4 min.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.select name="size" label="Egg size" :options="['small' => 'Small', 'medium' => 'Medium', 'large' => 'Large', 'xl' => 'Extra large', 'jumbo' => 'Jumbo']" selected="large" />
        <x-calc.select name="doneness" label="Doneness" :options="['soft' => 'Soft', 'jammy' => 'Jammy', 'medium' => 'Medium', 'hard' => 'Hard']" selected="medium" />
        <x-calc.select name="start" label="Eggs from" :options="['fridge' => 'The fridge', 'room' => 'Room temperature']" selected="fridge" />
    </div>

    <x-calc.field name="altitude" label="Altitude" value="0" min="0" placeholder="Altitude">
        <label for="calc-altitude-unit" class="sr-only">Altitude unit</label>
        <select id="calc-altitude-unit" name="altitude-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
            @foreach(collect(config('units.length'))->only(['ft', 'm']) as $key => $unit)
                <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
            @endforeach
        </select>
    </x-calc.field>

    <x-calc.result label="Boiling time" />

    <x-calc.options :decimals="false" :examples="[
        'Hard large' => ['size' => 'large', 'doneness' => 'hard', 'start' => 'fridge', 'altitude' => 0, 'altitude-unit' => 'ft'],
        'Jammy, 5,000 ft' => ['size' => 'large', 'doneness' => 'jammy', 'start' => 'fridge', 'altitude' => 5000, 'altitude-unit' => 'ft'],
        'Soft, room temp' => ['size' => 'medium', 'doneness' => 'soft', 'start' => 'room', 'altitude' => 0, 'altitude-unit' => 'ft'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'steam' => ['label' => 'Steaming'],
            'cold' => ['label' => 'Cold-water start'],
            'ice' => ['label' => 'Ice bath'],
            'safety' => ['label' => 'Safety'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>t = tested time × Williams(size, start, altitude) ÷ Williams(large, fridge, sea level)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
