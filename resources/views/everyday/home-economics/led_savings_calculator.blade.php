<x-calc.page
    title="LED Savings Calculator - SolveKit"
    description="Free LED savings calculator: money and electricity saved a year by replacing incandescent, halogen or CFL bulbs with LEDs, and the payback time."
    lede="See how much switching to LED bulbs saves."
    about="Savings = (old watts − LED watts) × bulbs × hours a day × 365 ÷ 1,000 × price. A 9 W LED gives the light of a 60 W incandescent bulb (800 lumens). LEDs are rated for about 15,000–25,000 hours, against about 1,000 for incandescent bulbs."
    :calc="['engine' => 'ev-home', 'tool' => 'led', 'fields' => ['old_watts', 'led_watts', 'bulbs', 'hours', 'price', 'led_price', 'led_life']]"
    :how-to="[
        ['name' => 'Enter the bulbs', 'text' => 'Old and LED watts and how many.'],
        ['name' => 'Enter use and price', 'text' => 'Hours a day and $/kWh.'],
    ]"
    :faqs="[
        ['question' => 'How much do LEDs save?', 'answer' => 'Replacing 20 bulbs of 60 W with 9 W LEDs used 4 h a day saves about $253 a year at 17¢.'],
        ['question' => 'What LED replaces a 60 W bulb?', 'answer' => 'About 8–10 W (800 lumens).'],
        ['question' => 'How fast do LEDs pay back?', 'answer' => 'Often within a year or two.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="old_watts" label="Old bulb" value="60" min="0" suffix="W" />
        <x-calc.field name="led_watts" label="LED bulb" value="9" min="0" suffix="W" />
        <x-calc.field name="bulbs" label="Bulbs" value="20" min="1" step="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="hours" label="Hours a day" value="4" min="0" max="24" step="0.5" />
        <x-calc.field name="price" label="Electricity price" value="0.17" min="0" step="0.01" suffix="$/kWh" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="led_price" label="Price per LED" value="3" min="0" step="0.01" suffix="$" />
        <x-calc.field name="led_life" label="LED rated life" value="15000" min="0" suffix="hours" />
    </div>

    <x-calc.result label="Saved a year" />

    <x-calc.options :decimals="false" :examples="[
        '20 bulbs, 60 → 9 W' => ['old_watts' => 60, 'led_watts' => 9, 'bulbs' => 20, 'hours' => 4, 'price' => 0.17, 'led_price' => 3, 'led_life' => 15000],
        'Halogen spots' => ['old_watts' => 50, 'led_watts' => 5, 'bulbs' => 12, 'hours' => 5, 'price' => 0.25, 'led_price' => 4, 'led_life' => 25000],
        'CFL to LED' => ['old_watts' => 13, 'led_watts' => 9, 'bulbs' => 15, 'hours' => 4, 'price' => 0.17, 'led_price' => 3, 'led_life' => 15000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'payback' => ['label' => 'Payback'],
            'lifetime' => ['label' => 'LED life'],
            'ten' => ['label' => 'Over 10 years'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>kWh saved = ΔW × bulbs × h × 365.25 ÷ 1,000</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
