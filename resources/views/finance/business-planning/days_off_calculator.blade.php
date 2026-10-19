<x-calc.page
    title="Days Off Calculator - SolveKit"
    description="Free days off calculator: paid leave accrued, used and remaining for the year from your entitlement, months worked and carried-over days."
    lede="Track your leave balance."
    about="Leave usually accrues evenly: entitlement ÷ 12 per month worked. Remaining = accrued + carried over − used. Your employer's policy may accrue per pay period or grant leave up front. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-biz', 'tool' => 'days_off', 'fields' => ['entitlement', 'months', 'used', 'carried', 'hours']]"
    :how-to="[
        ['name' => 'Enter your entitlement', 'text' => ''],
        ['name' => 'Enter months worked and days used', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How many days are left with 25 a year after 8 months, 9 used and 3 carried over?', 'answer' => '10.67 days.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="entitlement" label="Days a year" value="25" min="0" step="any" />
        <x-calc.field name="months" label="Months worked this year" value="8" min="0" max="12" step="any" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="used" label="Days used" value="9" min="0" step="any" />
        <x-calc.field name="carried" label="Carried over" value="3" min="0" step="any" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="hours" label="Hours in a day" value="8" min="1" step="any" />
    </div>

    <x-calc.result label="Leave remaining" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['entitlement' => 25, 'months' => 8, 'used' => 9, 'carried' => 3, 'hours' => 8],
        'US two weeks' => ['entitlement' => 10, 'months' => 6, 'used' => 2, 'carried' => 0, 'hours' => 8],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'accrued' => ['label' => 'Accrued'],
            'used' => ['label' => 'Used'],
            'rate' => ['label' => 'Accrual rate'],
            'hours' => ['label' => 'In hours'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>accrued = days × months ÷ 12 + carried</li>
            <li>left = accrued − used</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
