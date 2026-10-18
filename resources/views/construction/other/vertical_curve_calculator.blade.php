<x-calc.page
    title="Vertical Curve Calculator - SolveKit"
    description="Free vertical curve calculator: elevations along a symmetrical parabolic road curve, BVC and EVC, high or low point and K value."
    lede="Work out elevations along a vertical curve."
    about="Road crests and sags use parabolic vertical curves (AASHTO). From the beginning of the curve (BVC), the elevation x along it is BVC elevation + g₁x + (g₂ − g₁)x² ÷ 2L. The high or low point is at x = −g₁L ÷ (g₂ − g₁) when that falls on the curve. K = L ÷ |g₂ − g₁| measures how gentle the curve is."
    :calc="['engine' => 'con-trig', 'tool' => 'vertical_curve', 'fields' => ['units', 'g1', 'g2', 'length', 'pvi_station', 'pvi_elevation', 'interval']]"
    :how-to="[
        ['name' => 'Enter the grades and length', 'text' => 'In percent and feet or meters.'],
        ['name' => 'Enter the PVI', 'text' => 'Station and elevation.'],
    ]"
    :faqs="[
        ['question' => 'Where is the high point?', 'answer' => 'At x = −g₁L ÷ (g₂ − g₁) from the BVC: 240 ft for +3% to −2% over 400 ft.'],
        ['question' => 'What is K?', 'answer' => 'Curve length per percent of grade change; design tables give minimum K for sight distance.'],
        ['question' => 'What is a PVI?', 'answer' => 'The point where the two straight grades would intersect.'],
    ]"
>
    <x-calc.select name="units" label="Units" :options="['ft' => 'Feet (stations of 100 ft)', 'm' => 'Meters']" selected="ft" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="g1" label="Incoming grade g₁" value="3" suffix="%" />
        <x-calc.field name="g2" label="Outgoing grade g₂" value="-2" suffix="%" />
        <x-calc.field name="length" label="Curve length L" value="400" min="0" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="pvi_station" label="PVI station" value="1500" min="0" />
        <x-calc.field name="pvi_elevation" label="PVI elevation" value="250" />
        <x-calc.field name="interval" label="Table interval" value="50" min="0" />
    </div>

    <x-calc.result label="High point elevation" />

    <x-calc.options :examples="[
        'Crest +3% to −2%, 400 ft' => ['units' => 'ft', 'g1' => 3, 'g2' => -2, 'length' => 400, 'pvi_station' => 1500, 'pvi_elevation' => 250, 'interval' => 50],
        'Sag −4% to +2%, 300 ft' => ['units' => 'ft', 'g1' => -4, 'g2' => 2, 'length' => 300, 'pvi_station' => 2200, 'pvi_elevation' => 180, 'interval' => 50],
        'Metric 120 m' => ['units' => 'm', 'g1' => 2.5, 'g2' => -1.5, 'length' => 120, 'pvi_station' => 800, 'pvi_elevation' => 64.5, 'interval' => 20],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'bvc' => ['label' => 'BVC'],
            'evc' => ['label' => 'EVC'],
            'turn' => ['label' => 'High or low point'],
            'k' => ['label' => 'K value'],
        ]" />
        <x-calc.quick-ref heading="Elevations" name="stations" :generated="true" :collapse="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>y = BVC + g₁x + (g₂ − g₁)x² ÷ 2L</li>
            <li>x(turn) = −g₁L ÷ (g₂ − g₁)</li>
            <li>K = L ÷ |g₂ − g₁|</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
