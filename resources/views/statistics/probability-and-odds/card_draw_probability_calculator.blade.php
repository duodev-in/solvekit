<x-calc.page
    title="Card Draw Probability Calculator - SolveKit"
    description="Free card draw probability calculator: the chance of drawing at least, exactly or at most k cards of a kind from a deck (hypergeometric)."
    lede="Find card draw odds."
    about="Drawing cards without replacement follows the hypergeometric distribution. It answers questions such as the chance of an ace in a five-card hand."
    :calc="['engine' => 'st-prob', 'tool' => 'card_draw', 'fields' => ['N', 'K', 'n', 'mode', 'k'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is the chance of at least one ace in 5 cards?', 'answer' => '0.341158.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="N" label="Cards in the deck" value="52" min="1" step="any" />
        <x-calc.field name="K" label="Cards of interest in the deck (e.g. aces)" value="4" min="0" step="any" />
        <x-calc.field name="n" label="Cards drawn" value="5" min="1" step="any" />
        <x-calc.select name="mode" label="You want" :options="['eq' => 'Exactly', 'le' => 'At most', 'ge' => 'At least', 'lt' => 'Fewer than', 'gt' => 'More than']" selected="ge" />
        <x-calc.field name="k" label="Number of those cards" value="1" min="0" step="any" />
    </div>

    <x-calc.result label="Probability" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['N' => 52, 'K' => 4, 'n' => 5, 'mode' => 'ge', 'k' => 1],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Cards of interest drawn" name="dist" />
        <x-calc.rows heading="Details" :rows="[
            'odds' => ['label' => 'Odds'],
            'exact' => ['label' => 'P(exactly k)'],
            'none' => ['label' => 'P(none of them)'],
            'mean' => ['label' => 'Expected number'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
