<x-calc.page
    title="The Lord of the Rings Calculator - SolveKit"
    description="Free Lord of the Rings calculator: how long a Middle-earth movie marathon takes, theatrical or extended, with The Hobbit and The War of the Rohirrim, and your finish time."
    lede="Plan a Middle-earth movie marathon."
    about="Theatrical runtimes are from each film's Wikipedia entry; the extended editions add new scenes and long fan-club credits (The Fellowship of the Ring extended runs 228 minutes in all). Story order runs The War of the Rohirrim, The Hobbit and then The Lord of the Rings; release order starts with The Fellowship of the Ring."
    :calc="['engine' => 'ev-fun', 'tool' => 'middle_earth', 'fields' => ['lotr', 'hobbit', 'rohirrim', 'version', 'order', 'break', 'start'], 'data' => ['middle_earth' => config('everyday_data.middle_earth')]]"
    :how-to="[
        ['name' => 'Pick the films', 'text' => 'And the version.'],
        ['name' => 'Set breaks and a start time', 'text' => 'For a schedule.'],
    ]"
    :faqs="[
        ['question' => 'How long is the Lord of the Rings trilogy?', 'answer' => '9 h 18 min theatrical, 11 h 55 min extended.'],
        ['question' => 'How long are all six Peter Jackson films?', 'answer' => 'About 17 h 12 min theatrical, without breaks.'],
        ['question' => 'What order should I watch them in?', 'answer' => 'Release order keeps the original reveals; story order starts with The Hobbit.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.checkbox name="lotr" label="The Lord of the Rings" :checked="true" />
        <x-calc.checkbox name="hobbit" label="The Hobbit" :checked="false" />
        <x-calc.checkbox name="rohirrim" label="The War of the Rohirrim" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.segmented name="version" legend="Version" :options="['theatrical' => 'Theatrical', 'extended' => 'Extended']" selected="theatrical" />
        <x-calc.segmented name="order" legend="Order" :options="['story' => 'Story', 'release' => 'Release']" selected="story" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="break" label="Break between films" value="15" min="0" step="5" suffix="min" />
        <x-calc.field name="start" label="Start (optional)" value="2026-12-26T10:00" type="datetime-local" />
    </div>

    <x-calc.result label="Marathon length" />

    <x-calc.options :decimals="false" :examples="[
        'Trilogy, theatrical' => ['lotr' => true, 'hobbit' => false, 'rohirrim' => false, 'version' => 'theatrical', 'order' => 'story', 'break' => 15, 'start' => '2026-12-26T10:00'],
        'Trilogy, extended' => ['lotr' => true, 'hobbit' => false, 'rohirrim' => false, 'version' => 'extended', 'order' => 'story', 'break' => 20, 'start' => '2026-12-26T09:00'],
        'All seven in story order' => ['lotr' => true, 'hobbit' => true, 'rohirrim' => true, 'version' => 'theatrical', 'order' => 'story', 'break' => 15, 'start' => '2026-12-26T08:00'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'finish' => ['label' => 'Finish'],
            'days' => ['label' => 'Nonstop'],
            'evenings' => ['label' => 'Spread out'],
        ]" />
        <x-calc.quick-ref heading="Schedule" name="schedule" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>total = Σ runtimes + breaks</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
