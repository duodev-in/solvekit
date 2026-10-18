<x-calc.page
    title="Miles to Dollars Calculator - SolveKit"
    description="Free miles to dollars calculator: mileage reimbursement or tax deduction at the IRS standard mileage rates for business, medical and charity driving, or your own rate."
    lede="Turn miles driven into a reimbursement amount."
    about="Reimbursement = miles × rate. The IRS standard mileage rates for 2026 are 72.5¢ a mile for business (1 January – 30 June) and 76¢ from 1 July; medical and military moving 20.5¢, then 23.5¢; and charity 14¢, set by law. Employers may pay a different rate; enter it as your own."
    :calc="['engine' => 'ev-transport', 'tool' => 'miles_to_dollars', 'fields' => ['miles', 'trips', 'rate', 'custom_rate'], 'data' => ['irs_mileage' => config('everyday_data.irs_mileage')]]"
    :how-to="[
        ['name' => 'Enter the miles', 'text' => 'Per trip and the number of trips.'],
        ['name' => 'Pick the rate', 'text' => 'IRS rate in force, or your employer\'s.'],
    ]"
    :faqs="[
        ['question' => 'What is the IRS mileage rate for 2026?', 'answer' => '72.5¢ a mile for business from January to June, and 76¢ from 1 July 2026.'],
        ['question' => 'How much is 960 business miles?', 'answer' => '$729.60 at 76¢.'],
        ['question' => 'Can I claim commuting miles?', 'answer' => 'No, commuting is personal, not business, travel.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="miles" label="Miles per trip" value="48" min="0" step="0.1" />
        <x-calc.field name="trips" label="Trips" value="20" min="1" step="1" />
    </div>

    <x-calc.select name="rate" label="Rate" :options="collect(config('everyday_data.irs_mileage'))->mapWithKeys(fn ($r) => [$r[0] => $r[1].' ('.$r[2].'¢)'])->all() + ['custom' => 'My own rate']" selected="business_2026b" />

    <div data-show-when="rate:custom" hidden>
        <x-calc.field name="custom_rate" label="Your rate" value="60" min="0" step="0.5" suffix="¢ per mile" />
    </div>

    <x-calc.result label="Reimbursement" />

    <x-calc.options :examples="[
        '20 trips of 48 mi' => ['miles' => 48, 'trips' => 20, 'rate' => 'business_2026b', 'custom_rate' => ''],
        'Medical trips' => ['miles' => 35, 'trips' => 6, 'rate' => 'medical_2026b', 'custom_rate' => ''],
        'Volunteer driving' => ['miles' => 120, 'trips' => 4, 'rate' => 'charity', 'custom_rate' => ''],
        'Employer pays 60¢' => ['miles' => 250, 'trips' => 1, 'rate' => 'custom', 'custom_rate' => 60],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'trip' => ['label' => 'Per trip'],
            'km' => ['label' => 'Per km'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>amount = miles × trips × rate</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
