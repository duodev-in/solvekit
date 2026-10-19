<x-calc.page
    title="Steak Cook Time Calculator - SolveKit"
    description="Free steak cook time calculator: minutes per side for rare to well-done steaks by thickness on the grill, in a pan or under the broiler, or a reverse sear, with the internal temperatures."
    lede="Find how long to cook a steak."
    about="Doneness is set by internal temperature: rare about 125 °F, medium rare 135, medium 145, medium well 150 and well done 160. Over high heat a 1 in steak takes about 4 minutes a side for rare up to 8 for well done; thicker steaks take proportionally longer, and very thick ones do better with a reverse sear. Pull the steak about 5 °F early (it keeps rising as it rests). USDA's safe minimum for whole-muscle beef is 145 °F with a 3-minute rest. Times are guides: check doneness with a food thermometer."
    :calc="['engine' => 'fd-other', 'tool' => 'steak', 'fields' => ['thickness', 'doneness', 'method'], 'unitFields' => ['thickness' => collect(config('units.length'))->only(['in', 'mm', 'cm'])->all()]]"
    :how-to="[
        ['name' => 'Enter the thickness', 'text' => ''],
        ['name' => 'Choose doneness and method', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How long to grill a 1 in steak medium rare?', 'answer' => '5 min a side.'],
        ['question' => 'A 1½ in steak medium?', 'answer' => '9 min a side.'],
        ['question' => 'A 2 in steak by reverse sear?', 'answer' => '40–50 min in the oven.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="thickness" label="Thickness" value="1" min="0" placeholder="Thickness">
            <label for="calc-thickness-unit" class="sr-only">Thickness unit</label>
            <select id="calc-thickness-unit" name="thickness-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'mm', 'cm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="doneness" label="Doneness" :options="['rare' => 'Rare', 'mediumrare' => 'Medium rare', 'medium' => 'Medium', 'mediumwell' => 'Medium well', 'well' => 'Well done']" selected="mediumrare" />
        <x-calc.select name="method" label="Method" :options="['grill' => 'Grill or pan (high heat)', 'broil' => 'Broiler', 'reverse' => 'Reverse sear (oven, then pan)']" selected="grill" />
    </div>

    <x-calc.result label="Each side, over high heat" />

    <x-calc.options :decimals="false" :examples="[
        '1 in medium rare' => ['thickness' => 1, 'thickness-unit' => 'in', 'doneness' => 'mediumrare', 'method' => 'grill'],
        '1½ in medium' => ['thickness' => 1.5, 'thickness-unit' => 'in', 'doneness' => 'medium', 'method' => 'grill'],
        '2 in reverse sear' => ['thickness' => 2, 'thickness-unit' => 'in', 'doneness' => 'mediumrare', 'method' => 'reverse'],
        '3 cm well done' => ['thickness' => 3, 'thickness-unit' => 'cm', 'doneness' => 'well', 'method' => 'broil'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'target' => ['label' => 'Target'],
            'pull' => ['label' => 'Take it off at'],
            'rest' => ['label' => 'Resting'],
            'usda' => ['label' => 'USDA'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>minutes a side ≈ minutes per inch × thickness</li>
            <li>pull at target − 5 °F</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
