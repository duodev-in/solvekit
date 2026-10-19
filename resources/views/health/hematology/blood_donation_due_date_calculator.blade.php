<x-calc.page
    title="Blood Donation Due Date Calculator - SolveKit"
    description="Free blood donation due date calculator: when you can donate again after whole blood, Power Red, platelets or plasma, by US, UK or Indian rules."
    lede="Find your next blood donation date."
    about="Minimum intervals between donations: American Red Cross 56 days for whole blood, 112 days for Power Red, 7 days for platelets and 28 days for plasma; NHS Blood and Transplant 12 weeks (men) or 16 weeks (women) for whole blood; India's NBTC guidelines 90 days (men) or 120 days (women). The blood service makes the final check on the day. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-labs', 'tool' => 'donation_due', 'fields' => ['last', 'today', 'country', 'type', 'sex']]"
    :how-to="[
        ['name' => 'Enter the last donation date', 'text' => ''],
        ['name' => 'Choose the country and type', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'When can I give whole blood again after 20 August 2026 (US)?', 'answer' => 'Oct 15, 2026.'],
        ['question' => 'And in the UK as a woman?', 'answer' => 'Dec 10, 2026.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="last" label="Last donation" value="2026-08-20" type="date" />
        <x-calc.field name="today" label="As of" value="{{ now()->toDateString() }}" type="date" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.select name="country" label="Country" :options="['us' => 'United States', 'uk' => 'United Kingdom', 'in' => 'India']" selected="us" />
        <x-calc.select name="type" label="Donation type (US)" :options="['whole' => 'Whole blood', 'power' => 'Power Red', 'platelets' => 'Platelets', 'plasma' => 'Plasma']" selected="whole" />
        <x-calc.segmented name="sex" legend="Sex" :options="['male' => 'Male', 'female' => 'Female']" selected="male" />
    </div>

    <x-calc.result label="Next donation" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['last' => '2026-08-20', 'today' => '2026-10-19', 'country' => 'us', 'type' => 'whole', 'sex' => 'male'],
        'UK woman' => ['last' => '2026-08-20', 'today' => '2026-10-19', 'country' => 'uk', 'type' => 'whole', 'sex' => 'female'],
        'Power Red' => ['last' => '2026-08-20', 'today' => '2026-10-19', 'country' => 'us', 'type' => 'power', 'sex' => 'male'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'interval' => ['label' => 'Interval'],
            'note' => ['label' => 'Note'],
            'check' => ['label' => 'On the day'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>next = last + interval</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
