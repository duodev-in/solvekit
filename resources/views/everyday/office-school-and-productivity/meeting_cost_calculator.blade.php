<x-calc.page
    title="Meeting Cost Calculator - SolveKit"
    description="Free meeting cost calculator: what a meeting costs in salaries and overhead per minute, per meeting and per year."
    lede="See what a meeting really costs."
    about="Hourly cost = annual pay × (1 + overhead) ÷ 2,080 working hours. Overhead (benefits, payroll taxes, space) often adds 25–40%. Meeting cost = Σ people × hourly cost × hours."
    :calc="['engine' => 'ev-office', 'tool' => 'meeting', 'fields' => ['people', 'minutes', 'overhead', 'per_year']]"
    :how-to="[
        ['name' => 'List the attendees', 'text' => 'Count and annual pay.'],
        ['name' => 'Enter length and overhead', 'text' => 'And how often it meets.'],
    ]"
    :faqs="[
        ['question' => 'What does an hour-long meeting of 8 cost?', 'answer' => 'About $500 for these salaries with 30% overhead.'],
        ['question' => 'How do I turn salary into an hourly cost?', 'answer' => 'Annual pay ÷ 2,080 hours, plus overhead.'],
        ['question' => 'What is overhead?', 'answer' => 'Benefits, taxes and other costs on top of pay.'],
    ]"
>
    <x-calc.rows-editor name="people" label="Attendees" :columns="['role' => 'Role', 'count' => 'People', 'salary' => 'Annual pay $']" :rows="[['Managers', 2, 120000], ['Engineers', 5, 95000], ['Designer', 1, 85000]]" add-label="Add group" :text="['role']" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="minutes" label="Length" value="60" min="1" step="5" suffix="min" />
        <x-calc.field name="overhead" label="Overhead" value="30" min="0" max="200" step="5" suffix="%" />
        <x-calc.field name="per_year" label="Meetings a year" value="50" min="0" step="1" />
    </div>

    <x-calc.result label="Cost of the meeting" />

    <x-calc.options :decimals="false" :examples="[
        'Weekly team meeting' => ['people' => 'Managers	2	120000
Engineers	5	95000
Designer	1	85000', 'minutes' => 60, 'overhead' => 30, 'per_year' => 50],
        'Daily stand-up' => ['people' => 'Developers	8	100000', 'minutes' => 15, 'overhead' => 30, 'per_year' => 250],
        'Executive offsite' => ['people' => 'Executives	6	250000', 'minutes' => 480, 'overhead' => 40, 'per_year' => 2],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'minute' => ['label' => 'Per minute'],
            'year' => ['label' => 'Per year'],
            'hours' => ['label' => 'Person-hours'],
        ]" />
        <x-calc.quick-ref heading="By group" name="groups" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>hourly = pay × (1 + overhead) ÷ 2,080</li>
            <li>cost = Σ count × hourly × hours</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
