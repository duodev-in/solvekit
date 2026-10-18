<x-calc.page
    title="Microwave Wattage Converter - SolveKit"
    description="Free microwave wattage converter: adjust a recipe or package cooking time for a microwave of a different wattage."
    lede="Adjust microwave cooking times for your oven's power."
    about="The energy delivered is power × time, so your time = recipe time × recipe watts ÷ your watts. A recipe for 1,100 W needs longer in a 700 W microwave. Wattage is on the label inside the door; stir and let food stand, and check it is hot all the way through."
    :calc="['engine' => 'ev-home', 'tool' => 'microwave', 'fields' => ['minutes', 'seconds', 'from', 'to']]"
    :how-to="[
        ['name' => 'Enter the recipe time', 'text' => 'And the wattage it was written for.'],
        ['name' => 'Enter your wattage', 'text' => 'From the door label.'],
    ]"
    :faqs="[
        ['question' => 'How long in a 700 W microwave if the box says 2 min at 1,100 W?', 'answer' => 'About 3 min 9 s.'],
        ['question' => 'Where do I find my microwave\'s wattage?', 'answer' => 'On the label inside the door or on the back.'],
        ['question' => 'Is it exact?', 'answer' => 'Close; ovens differ, so check the food.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="minutes" label="Recipe time: minutes" value="3" min="0" step="1" />
        <x-calc.field name="seconds" label="Seconds" value="30" min="0" max="59" step="5" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="from" label="Recipe wattage" value="1100" min="100" step="50" suffix="W" />
        <x-calc.field name="to" label="Your microwave" value="800" min="100" step="50" suffix="W" />
    </div>

    <x-calc.result label="Time in your microwave" />

    <x-calc.options :decimals="false" :examples="[
        '3:30 at 1,100 → 800 W' => ['minutes' => 3, 'seconds' => 30, 'from' => 1100, 'to' => 800],
        '2:00 at 1,100 → 700 W' => ['minutes' => 2, 'seconds' => 0, 'from' => 1100, 'to' => 700],
        '5:00 at 900 → 1,200 W' => ['minutes' => 5, 'seconds' => 0, 'from' => 900, 'to' => 1200],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'seconds' => ['label' => 'In seconds'],
            'note' => ['label' => 'Safety'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>your time = time × recipe W ÷ your W</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
