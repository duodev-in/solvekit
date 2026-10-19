<x-calc.page
    title="Dog Walking Benefits Calculator - SolveKit"
    description="Free dog walking calculator: weekly active minutes and calories from walking your dog, against the WHO 150-minute guideline."
    lede="See what dog walking does for you."
    about="Walking a dog counts as moderate activity: about 3.0 METs, or 4.3 at a brisk pace (Compendium of Physical Activities). Calories = METs × body weight (kg) × hours. WHO recommends 150–300 minutes of moderate activity a week; regular dog walkers reach it far more often. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-life', 'tool' => 'dog_walk', 'fields' => ['walks', 'minutes', 'weight', 'pace'], 'unitFields' => ['weight' => collect(config('units.mass'))->only(['kg', 'lb', 'st'])->all()]]"
    :how-to="[
        ['name' => 'Enter walks and minutes', 'text' => ''],
        ['name' => 'Enter your weight', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How active are 10 walks of 25 minutes a week?', 'answer' => '250 min a week: Meets the WHO 150 minutes of moderate activity a week.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="walks" label="Walks a week" value="10" min="0" step="1" />
        <x-calc.field name="minutes" label="Minutes per walk" value="25" min="0" step="5" />
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
        <x-calc.select name="pace" label="Pace" :options="['easy' => 'Easy, with stops', 'brisk' => 'Brisk']" selected="easy" />
    </div>

    <x-calc.result label="Activity a week" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['walks' => 10, 'minutes' => 25, 'weight' => 70, 'weight-unit' => 'kg', 'pace' => 'easy'],
        'Brisk' => ['walks' => 7, 'minutes' => 40, 'weight' => 180, 'weight-unit' => 'lb', 'pace' => 'brisk'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'who' => ['label' => 'WHO guideline'],
            'kcal' => ['label' => 'Calories'],
            'met' => ['label' => 'Intensity'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>kcal = METs × kg × h</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
