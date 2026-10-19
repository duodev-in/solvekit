<x-calc.page
    title="Time and a Half Calculator - SolveKit"
    description="Free time and a half calculator: the overtime rate (1.5× your hourly rate) and pay for overtime hours."
    lede="Find your time-and-a-half rate."
    about="Time and a half = hourly rate × 1.5; double time = × 2. Overtime pay = overtime hours × the time-and-a-half rate. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-pay', 'tool' => 'time_and_half', 'fields' => ['rate', 'hours']]"
    :how-to="[
        ['name' => 'Enter your rate', 'text' => ''],
        ['name' => 'Enter overtime hours', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is time and a half on $20?', 'answer' => '$30.00; 8 hours pay $240.00.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="rate" label="Hourly rate" value="20" step="0.01" suffix="$" />
        <x-calc.field name="hours" label="Overtime hours" value="8" min="0" step="any" />
    </div>

    <x-calc.result label="Time-and-a-half rate" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['rate' => 20, 'hours' => 8],
        'Higher rate' => ['rate' => 35, 'hours' => 12],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'pay' => ['label' => 'Pay for the hours'],
            'double' => ['label' => 'Double-time rate'],
            'extra' => ['label' => 'Premium over regular pay'],
            'daily' => ['label' => '8 hours at time and a half'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>OT rate = 1.5 × rate</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
