<x-calc.page
    title="Tree Diameter Calculator - SolveKit"
    description="Free tree diameter calculator: DBH from trunk circumference, with radius and basal area."
    lede="Work out a tree's diameter (DBH) from its circumference."
    about="Diameter at breast height (DBH) is measured 4.5 ft (1.37 m) above the ground. Wrap a tape around the trunk at that height and divide the circumference by π."
    :calc="['engine' => 'forestry', 'tool' => 'diameter', 'fields' => ['circumference'], 'unitFields' => ['circumference' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Measure at breast height', 'text' => '4.5 ft above the ground on the uphill side.'],
        ['name' => 'Wrap a tape', 'text' => 'Enter the circumference.'],
    ]"
    :faqs="[
        ['question' => 'What is DBH?', 'answer' => 'Diameter at breast height, 4.5 ft (1.37 m) above ground.'],
        ['question' => 'What if the trunk forks below 4.5 ft?', 'answer' => 'Measure each stem separately.'],
        ['question' => 'Can I use a diameter tape?', 'answer' => 'Yes; it reads diameter directly by dividing by π for you.'],
    ]"
>
    <x-calc.field name="circumference" label="Circumference at 4.5 ft" value="60" min="0" placeholder="Circumference at 4.5 ft">
        <label for="calc-circumference-unit" class="sr-only">Circumference at 4.5 ft unit</label>
        <select id="calc-circumference-unit" name="circumference-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
            @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
            @endforeach
        </select>
    </x-calc.field>

    <x-calc.result label="Diameter at breast height (DBH)" />

    <x-calc.options :examples="[
        'Oak 94 in round' => ['circumference' => 94],
        'Young maple 20 in' => ['circumference' => 20],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'cm' => ['label' => 'Centimeters', 'unit' => 'cm'],
            'radius' => ['label' => 'Radius'],
            'basal' => ['label' => 'Basal area'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>DBH = circumference ÷ π</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
