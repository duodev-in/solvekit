<x-calc.page
    title="Occupancy Rate Calculator - SolveKit"
    description="Free Occupancy Rate Calculator: occupancy = occupied ÷ available. Occupancy is the share of units or room-nights filled."
    lede="Work out the occupancy rate from occupied units (or nights) and total available units."
    about="Occupancy is the share of units or room-nights filled. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'occupancy_rate', 'fields' => ['occupied', 'total']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Occupied units (or nights), Total available units.'],
        ['name' => 'Read the result', 'text' => 'The occupancy rate appears as you type, with vacancy rate below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the occupancy rate?', 'answer' => 'Occupancy = occupied ÷ available.'],
        ['question' => 'What is the occupancy rate for occupied units 92, total available units 100?', 'answer' => '92%. Vacancy rate: 8%.'],
        ['question' => 'And for occupied units 268, total available units 310?', 'answer' => '86.45%. Vacancy rate: 13.55%.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Vacancy rate = 1 − occupancy.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="occupied" label="Occupied units (or nights)" value="92" step="any" />
        <x-calc.field name="total" label="Total available units" value="100" step="any" />
    </div>

    <x-calc.result label="Occupancy rate" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['occupied' => 92, 'total' => 100],
        'Example B' => ['occupied' => 268, 'total' => 310],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Vacancy rate'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>occupancy = occupied ÷ available</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
