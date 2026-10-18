<x-calc.page
    title="Ticket Optimizer - SolveKit"
    description="Free ticket optimizer: compare single tickets with weekly, monthly or other passes to find the cheapest way to pay for your trips."
    lede="Find the cheapest ticket for how often you travel."
    about="Singles cost fare × trips. A pass valid for D days costs its price for each D-day block in your period. A pass pays off once you make more than price ÷ fare trips in its validity. Enter each pass as its price and its days of validity, one per line."
    :calc="['engine' => 'ev-transport', 'tool' => 'ticket', 'fields' => ['fare', 'trips', 'weeks', 'passes']]"
    :how-to="[
        ['name' => 'Enter the fare and trips', 'text' => 'Trips a week and over how many weeks.'],
        ['name' => 'List the passes', 'text' => 'Price and days, e.g. 34 7 for a $34 weekly pass.'],
    ]"
    :faqs="[
        ['question' => 'Is a monthly pass worth it?', 'answer' => 'A $127 30-day pass with $2.90 fares pays off above about 10.2 trips a week.'],
        ['question' => 'What about weeks I travel less?', 'answer' => 'Average your trips over the whole period.'],
        ['question' => 'Are daily caps included?', 'answer' => 'No; enter a cap as a 1-day pass.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="fare" label="Single fare" value="2.9" min="0" step="0.01" suffix="$" />
        <x-calc.field name="trips" label="Trips a week" value="10" min="0" step="1" />
        <x-calc.field name="weeks" label="Weeks" value="12" min="1" step="1" />
    </div>

    <x-calc.textarea name="passes" label="Passes: price and days valid, one per line" value="34 7
127 30" rows="3" />

    <x-calc.result label="Cheapest option" />

    <x-calc.options :examples="[
        'Commuter, 12 trips a week' => ['fare' => 2.9, 'trips' => 12, 'weeks' => 12, 'passes' => '34 7
127 30'],
        'Occasional, 4 trips' => ['fare' => 2.9, 'trips' => 4, 'weeks' => 12, 'passes' => '34 7
127 30'],
        'Daily cap' => ['fare' => 2.75, 'trips' => 14, 'weeks' => 4, 'passes' => '5.5 1
34 7'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'saving' => ['label' => 'Saving'],
            'per' => ['label' => 'Per trip'],
        ]" />
        <x-calc.quick-ref heading="Each option" name="options" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>singles = fare × trips</li>
            <li>pass = price × ⌈days ÷ validity⌉</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
