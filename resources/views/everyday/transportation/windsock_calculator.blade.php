<x-calc.page
    title="Windsock Calculator - SolveKit"
    description="Free windsock calculator: wind speed from how many segments of an airport windsock are filled, in knots, mph and km/h."
    lede="Read the wind speed from a windsock."
    about="Standard airport windsocks (FAA AC 150/5345-27) fully extend at 15 knots. Five-stripe socks fill roughly one stripe for each 3 knots of wind, so 3 stripes is about 9 knots. The sock points away from where the wind comes from. Treat it as a rough reading; gusts make the sock swing."
    :calc="['engine' => 'ev-transport', 'tool' => 'windsock', 'fields' => ['segments']]"
    :how-to="[
        ['name' => 'Count the filled stripes', 'text' => 'Of five.'],
    ]"
    :faqs="[
        ['question' => 'How fast is the wind when a windsock is straight out?', 'answer' => '15 knots or more.'],
        ['question' => 'What does each stripe mean?', 'answer' => 'About 3 knots.'],
        ['question' => 'How do I read wind direction?', 'answer' => 'The wind comes from the end the sock is attached to.'],
    ]"
>
    <x-calc.field name="segments" label="Stripes filled (0–5)" value="3" min="0" max="5" step="0.5" />

    <x-calc.result label="Wind speed" />

    <x-calc.options :examples="[
        '3 stripes' => ['segments' => 3],
        'Fully out' => ['segments' => 5],
        'Barely 1' => ['segments' => 1],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'mph' => ['label' => 'In mph'],
            'kmh' => ['label' => 'In km/h'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>knots ≈ 3 × stripes, 15+ when fully extended</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
