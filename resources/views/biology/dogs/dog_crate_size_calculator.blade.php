<x-calc.page
    title="Dog Crate Size Calculator - SolveKit"
    description="Free dog crate size calculator: the right crate from your dog's length and height, with a standard crate size chart."
    lede="Find the right crate size for your dog."
    about="Measure from the nose to the base of the tail, and from the floor to the top of the head (or ears if they stand up) while sitting. Add 2 to 4 inches to each. The dog should stand, turn around and lie down comfortably, but not have room to use one end as a toilet."
    :calc="['engine' => 'pets', 'tool' => 'dog_crate', 'fields' => ['length', 'height'], 'unitFields' => ['length' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'height' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Measure the length', 'text' => 'Nose to base of tail, standing.'],
        ['name' => 'Measure the height', 'text' => 'Floor to top of head or ears, sitting.'],
    ]"
    :faqs="[
        ['question' => 'How big should a dog crate be?', 'answer' => 'About 3 inches longer and taller than your dog.'],
        ['question' => 'What size crate for a puppy?', 'answer' => 'Buy for the adult size and use a divider while the puppy is small.'],
        ['question' => 'Can a crate be too big?', 'answer' => 'Yes, for house training; extra space may become a toilet area.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="length" label="Length, nose to tail base" value="26" min="0" placeholder="Length, nose to tail base">
            <label for="calc-length-unit" class="sr-only">Length, nose to tail base unit</label>
            <select id="calc-length-unit" name="length-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="height" label="Height, floor to head" value="22" min="0" placeholder="Height, floor to head">
            <label for="calc-height-unit" class="sr-only">Height, floor to head unit</label>
            <select id="calc-height-unit" name="height-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Crate size" />

    <x-calc.options :examples="[
        'Medium dog' => ['length' => 26, 'length-unit' => 'in', 'height' => 22, 'height-unit' => 'in'],
        'Large dog' => ['length' => 36, 'length-unit' => 'in', 'height' => 28, 'height-unit' => 'in'],
        'Small dog' => ['length' => 14, 'length-unit' => 'in', 'height' => 12, 'height-unit' => 'in'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'length' => ['label' => 'Inside length needed'],
            'height' => ['label' => 'Inside height needed'],
        ]" />
        <x-calc.quick-ref heading="Standard crate sizes" name="crates" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>crate length ≥ dog length + 2 to 4 in</li>
            <li>crate height ≥ dog height + 2 to 4 in</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
