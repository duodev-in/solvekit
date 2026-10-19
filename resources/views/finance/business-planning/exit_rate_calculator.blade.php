<x-calc.page
    title="Exit Rate Calculator - SolveKit"
    description="Free Exit Rate Calculator: exit rate = exits ÷ page views. Exit rate is the share of a page's views that were the last in a session."
    lede="Work out the exit rate from exits from the page and page views."
    about="Exit rate is the share of a page's views that were the last in a session. Unlike bounce rate it counts sessions that began elsewhere. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'exit_rate', 'fields' => ['exits', 'views']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Exits from the page, Page views.'],
        ['name' => 'Read the result', 'text' => 'The exit rate appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the exit rate?', 'answer' => 'Exit rate = exits ÷ page views.'],
        ['question' => 'What is the exit rate for exits from the page 800, page views 3,200?', 'answer' => '25%.'],
        ['question' => 'And for exits from the page 120, page views 2,000?', 'answer' => '6%.'],
        ['question' => 'What does the result tell me?', 'answer' => 'High exit rates are normal on confirmation pages and a warning on checkout pages.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="exits" label="Exits from the page" value="800" min="0" step="1" />
        <x-calc.field name="views" label="Page views" value="3200" min="0" step="1" />
    </div>

    <x-calc.result label="Exit rate" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['exits' => 800, 'views' => 3200],
        'Example B' => ['exits' => 120, 'views' => 2000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>exit rate = exits ÷ page views</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
