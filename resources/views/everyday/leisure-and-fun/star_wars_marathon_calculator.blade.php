<x-calc.page
    title="Star Wars Marathon Calculator - SolveKit"
    description="Free Star Wars marathon calculator: how long it takes to watch the Skywalker saga, Rogue One, Solo and The Clone Wars in release or story order, with your finish time."
    lede="Plan a Star Wars movie marathon."
    about="Runtimes are each film's theatrical runtime from Wikipedia. Story (chronological) order runs Episodes I and II, The Clone Wars, III, Solo, Rogue One and IV–IX; release order starts with A New Hope (1977). Add breaks between films for food and stretching."
    :calc="['engine' => 'ev-fun', 'tool' => 'star_wars', 'fields' => ['saga', 'anthology', 'clone_wars', 'order', 'break', 'start'], 'data' => ['star_wars' => config('everyday_data.star_wars')]]"
    :how-to="[
        ['name' => 'Pick the films', 'text' => 'Saga, anthology, animated film.'],
        ['name' => 'Choose the order and breaks', 'text' => 'And when you start.'],
    ]"
    :faqs="[
        ['question' => 'How long is the Skywalker saga?', 'answer' => 'About 20 h 24 min for the nine episodes.'],
        ['question' => 'How long with Rogue One and Solo?', 'answer' => 'About 24 h 53 min without breaks.'],
        ['question' => 'What order should I watch Star Wars in?', 'answer' => 'Release order keeps the twists; story order follows the timeline.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.checkbox name="saga" label="Skywalker saga (I–IX)" :checked="true" />
        <x-calc.checkbox name="anthology" label="Rogue One and Solo" :checked="false" />
        <x-calc.checkbox name="clone_wars" label="The Clone Wars (2008)" :checked="false" />
    </div>

    <x-calc.segmented name="order" legend="Order" :options="['release' => 'Release', 'story' => 'Story']" selected="release" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="break" label="Break between films" value="15" min="0" step="5" suffix="min" />
        <x-calc.field name="start" label="Start (optional)" value="2026-12-26T10:00" type="datetime-local" />
    </div>

    <x-calc.result label="Marathon length" />

    <x-calc.options :decimals="false" :examples="[
        'Nine episodes, release order' => ['saga' => true, 'anthology' => false, 'clone_wars' => false, 'order' => 'release', 'break' => 15, 'start' => '2026-12-26T08:00'],
        'Everything, story order' => ['saga' => true, 'anthology' => true, 'clone_wars' => true, 'order' => 'story', 'break' => 15, 'start' => '2026-12-26T07:00'],
        'Anthology only' => ['saga' => false, 'anthology' => true, 'clone_wars' => false, 'order' => 'release', 'break' => 10, 'start' => '2026-10-24T19:00'],
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
