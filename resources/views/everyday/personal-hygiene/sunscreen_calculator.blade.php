<x-calc.page
    title="Sunscreen Calculator - SolveKit"
    description="Free sunscreen calculator: how much sunscreen to apply for the labeled SPF, from your body size and the areas you cover, and how many bottles a trip needs."
    lede="Work out how much sunscreen you need."
    about="SPF is measured with 2 mg of sunscreen per square centimeter of skin (the FDA test amount); most people apply far less and get less protection. Skin area comes from the Mosteller body surface formula, and the share covered from the rule of nines (face and neck 9%, arms 18%, chest and belly 18%, back 18%, legs 36%). Reapply at least every 2 hours and after swimming or sweating."
    :calc="['engine' => 'ev-care', 'tool' => 'sunscreen', 'fields' => ['height', 'weight', 'face', 'arms', 'front', 'back', 'legs', 'per_day', 'days', 'people', 'bottle'], 'unitFields' => ['height' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'weight' => collect(config('units.mass'))->only(['lb', 'kg'])->all(), 'bottle' => collect(config('units.volume'))->only(['floz_us', 'ml', 'l'])->all()]]"
    :how-to="[
        ['name' => 'Enter height and weight', 'text' => 'For your skin area.'],
        ['name' => 'Tick what you cover', 'text' => 'And how often you apply.'],
    ]"
    :faqs="[
        ['question' => 'How much sunscreen should I use?', 'answer' => 'About 36 g (1.2 fl oz) for a 170 cm, 70 kg adult in a swimsuit at the SPF test amount: more than the often-quoted 1 oz.'],
        ['question' => 'How much for the face?', 'answer' => 'About 3 g for face and neck, roughly ⅗ teaspoon.'],
        ['question' => 'How often to reapply?', 'answer' => 'At least every 2 hours, and after swimming or sweating.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="height" label="Height" value="170" min="0" placeholder="Height">
            <label for="calc-height-unit" class="sr-only">Height unit</label>
            <select id="calc-height-unit" name="height-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="weight" label="Weight" value="70" min="0" placeholder="Weight">
            <label for="calc-weight-unit" class="sr-only">Weight unit</label>
            <select id="calc-weight-unit" name="weight-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['lb', 'kg']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.checkbox name="face" label="Face and neck" :checked="true" />
        <x-calc.checkbox name="arms" label="Arms" :checked="true" />
        <x-calc.checkbox name="front" label="Chest and belly" :checked="true" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="back" label="Back" :checked="true" />
        <x-calc.checkbox name="legs" label="Legs" :checked="true" />
    </div>

    <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
        <x-calc.field name="per_day" label="Applications a day" value="3" min="1" step="1" />
        <x-calc.field name="days" label="Days" value="7" min="1" step="1" />
        <x-calc.field name="people" label="People" value="1" min="1" step="1" />
        <x-calc.field name="bottle" label="Bottle size" value="8" min="0" placeholder="Bottle size">
            <label for="calc-bottle-unit" class="sr-only">Bottle size unit</label>
            <select id="calc-bottle-unit" name="bottle-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.volume'))->only(['floz_us', 'ml', 'l']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'floz_us')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Sunscreen per application" />

    <x-calc.options :examples="[
        'Adult in a swimsuit' => ['height' => 170, 'height-unit' => 'cm', 'weight' => 70, 'weight-unit' => 'kg', 'face' => true, 'arms' => true, 'front' => true, 'back' => true, 'legs' => true, 'per_day' => 3, 'days' => 7, 'people' => 1, 'bottle' => 8, 'bottle-unit' => 'floz_us'],
        'Face only' => ['height' => 165, 'height-unit' => 'cm', 'weight' => 60, 'weight-unit' => 'kg', 'face' => true, 'arms' => false, 'front' => false, 'back' => false, 'legs' => false, 'per_day' => 1, 'days' => 30, 'people' => 1, 'bottle' => 50, 'bottle-unit' => 'ml'],
        'Family beach week' => ['height' => 5.6, 'height-unit' => 'ft', 'weight' => 160, 'weight-unit' => 'lb', 'face' => true, 'arms' => true, 'front' => true, 'back' => true, 'legs' => true, 'per_day' => 3, 'days' => 7, 'people' => 4, 'bottle' => 8, 'bottle-unit' => 'floz_us'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'ml' => ['label' => 'In mL'],
            'trip' => ['label' => 'Whole trip'],
            'bottles' => ['label' => 'Bottles'],
            'note' => ['label' => 'Reapply'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>BSA = √(cm × kg ÷ 3,600) m²</li>
            <li>grams = BSA × 10,000 × share × 0.002</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
