<x-tool-page-layout
    title="Acreage Calculator - SolveKit"
    description="Professional acreage calculator to convert acres to square meters, hectares, square feet, and square yards. Accurate and fast conversions for land measurement."
>
    <x-slot name="toolUi">
        <!-- Calculator Card -->
                        <div class="space-y-2">
                            
                            <!-- Calculator Header -->
                            <div class="rounded-md bg-white p-2.5 shadow-sm">
                                <h1 class="text-sm font-semibold text-slate-900">Acreage Calculator</h1>
                            </div>

                            <!-- Calculator Body -->
                            <div class="rounded-md bg-white p-3 shadow-sm">
                                
                                <div class="grid gap-3 lg:grid-cols-9">
                                    <div class="lg:col-span-5">
                                        <form class="space-y-3" id="calculatorForm">

                                                                            <!-- Input Value -->
                                                                            <div class="space-y-2">
                                                                                <label for="value" class="block text-xs font-semibold text-slate-700">
                                                                                    Area in Acres
                                                                                </label>
                                                                                <div class="relative">
                                                                                    <input 
                                                                                        type="number" 
                                                                                        id="value" 
                                                                                        class="w-full rounded-md border border-slate-300 bg-white" 
                                                                                        placeholder="Enter acres (e.g., 5.5)"
                                                                                        step="any"
                                                                                        min="0"
                                                                                    >
                                                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                        <span class="text-slate-500 text-sm font-medium">acres</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Convert To -->
                                                                            <div class="space-y-2">
                                                                                <label for="to" class="block text-xs font-semibold text-slate-700">
                                                                                    Convert To
                                                                                </label>
                                                                                <select 
                                                                                    id="to" 
                                                                                    class="w-full rounded-md border border-slate-300 bg-white"
                                                                                >
                                                                                    <option value="sqm">Square Meters (m²)</option>
                                                                                    <option value="hectare">Hectares (ha)</option>
                                                                                    <option value="sqft">Square Feet (ft²)</option>
                                                                                    <option value="sqyd">Square Yards (yd²)</option>
                                                                                    <option value="sqkm">Square Kilometers (km²)</option>
                                                                                    <option value="sqin">Square Inches (in²)</option>
                                                                                    <option value="ares">Ares (a)</option>
                                                                                </select>
                                                                            </div>

                                                                            <div class="flex items-center justify-between gap-3 rounded-md border border-slate-200 bg-slate-50 px-2 py-1.5">
                                                                                <p class="text-[11px] text-slate-500">Shortcut: Ctrl + Shift + C to clear</p>
                                                                                <button
                                                                                    type="button"
                                                                                    id="clearButton"
                                                                                    class="rounded-md bg-indigo-100 px-3 py-1 text-xs font-semibold text-indigo-700"
                                                                                >
                                                                                    Clear
                                                                                </button>
                                                                            </div>

                                                                        </form>
                                    </div>
                                    <div class="space-y-4 lg:col-span-4">
                                        <!-- Result Display -->
                                                                        <div class="mt-8 space-y-4">
                                                                            <h3 class="text-lg font-semibold text-slate-900 text-center mb-4">Converted Values</h3>
                                                                            <div class="rounded-md border border-slate-200 bg-slate-50 p-2.5">
                                                                                <div class="flex items-center justify-between">
                                                                                    <div>
                                                                                        <h4 class="text-xs font-semibold text-slate-900" id="result-title">Converted Area</h4>
                                                                                        <p class="text-[11px] text-slate-500" id="result-description">Enter a value to convert</p>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <div class="font-serif text-3xl font-bold leading-none text-indigo-700" id="output">--</div>
                                                                                        <div class="text-xs text-slate-500 font-medium" id="unit-display">Select unit</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
    

</x-slot>

    <x-slot name="aboutContent">
        <!-- Additional Information -->
                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-3">
                            <h3 class="text-lg font-semibold text-slate-900 mb-4">About Acreage Conversion</h3>
                            <div class="grid md:grid-cols-2 gap-6 text-[11px] text-slate-500">
                                <div>
                                    <h4 class="font-semibold text-slate-700 mb-2">What is an Acre?</h4>
                                    <p>An acre is a unit of area measurement equal to 43,560 square feet or 4,047 square meters. It's commonly used in the United States and United Kingdom for measuring land parcels and agricultural areas.</p>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-slate-700 mb-2">Common Uses</h4>
                                    <p>Acreage calculations are essential for real estate transactions, farming operations, land development projects, property assessment, and agricultural planning and zoning.</p>
                                </div>
                            </div>
                            <div class="mt-4 rounded-md bg-indigo-50 p-3 text-xs text-indigo-800">
                                <p class="text-sm text-indigo-800">
                                    <strong>Historical Fact:</strong> An acre was originally defined as the amount of land that could be plowed by one ox in one day!
                                </p>
                            </div>
                        </div>

                        <div class="rounded-xl border border-slate-200 bg-white p-3 shadow-sm">
                            <h3 class="text-base font-semibold text-slate-900 mb-3">Quick Reference</h3>
                            <div class="grid grid-cols-1 gap-2 text-xs text-slate-600 sm:grid-cols-2">
                                <div>• 1 acre = 4,047 m²</div>
                                <div>• 1 acre = 0.405 hectares</div>
                                <div>• 1 acre = 43,560 ft²</div>
                                <div>• 1 acre = 4,840 yd²</div>
                                <div>• 1 acre = 40.47 ares</div>
                                <div>• 1 acre = 0.004047 km²</div>
                            </div>
                        </div>

                        <!-- Common Land Sizes -->
                        <div class="rounded-xl border border-slate-200 bg-white p-3">
                            <h3 class="text-lg font-semibold text-slate-900 mb-4">Common Land Size Examples</h3>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Small Lot</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-acres="0.25">0.25 acres</div>
                                </div>
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Typical Home</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-acres="0.5">0.5 acres</div>
                                </div>
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Large Lot</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-acres="2">2 acres</div>
                                </div>
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Small Farm</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-acres="10">10 acres</div>
                                </div>
                            </div>
                        </div>
    </x-slot>

    <x-slot name="scripts">
        <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const valueInput = document.getElementById('value');
                        const toSelect = document.getElementById('to');
                        const clearButton = document.getElementById('clearButton');
                        const output = document.getElementById('output');
                        const unitDisplay = document.getElementById('unit-display');
                        const resultTitle = document.getElementById('result-title');
                        const resultDescription = document.getElementById('result-description');

                        const conversionRates = {
                            sqm: { rate: 4046.86, symbol: 'm²', name: 'Square Meters' },
                            hectare: { rate: 0.404686, symbol: 'ha', name: 'Hectares' },
                            sqft: { rate: 43560, symbol: 'ft²', name: 'Square Feet' },
                            sqyd: { rate: 4840, symbol: 'yd²', name: 'Square Yards' },
                            sqkm: { rate: 0.00404686, symbol: 'km²', name: 'Square Kilometers' },
                            sqin: { rate: 6272640, symbol: 'in²', name: 'Square Inches' },
                            ares: { rate: 40.4686, symbol: 'a', name: 'Ares' }
                        };

                        function convert() {
                            const acres = parseFloat(valueInput.value);
                            const toUnit = toSelect.value;
                            const conversion = conversionRates[toUnit];

                            if (!isNaN(acres) && acres >= 0) {
                                const result = acres * conversion.rate;
                                
                                // Format the result appropriately
                                let formattedResult;
                                if (result >= 1000000) {
                                    formattedResult = Number(result.toPrecision(5)).toExponential();
                                } else if (result >= 1000) {
                                    formattedResult = result.toLocaleString(undefined, { maximumFractionDigits: 2 });
                                } else if (result >= 1) {
                                    formattedResult = result.toLocaleString(undefined, { maximumFractionDigits: 4 });
                                } else if (result > 0 && result < 0.000001) {
                                    formattedResult = Number(result.toPrecision(4)).toExponential();
                                } else {
                                    formattedResult = result.toLocaleString(undefined, { maximumSignificantDigits: 6 });
                                }
                                
                                output.textContent = formattedResult;
                                unitDisplay.textContent = conversion.symbol;
                                resultTitle.textContent = 'Area in ' + conversion.name;
                                resultDescription.textContent = `${acres} ac = ${formattedResult} ${conversion.symbol}`;
                            } else {
                                output.textContent = "--";
                                unitDisplay.textContent = "Select unit";
                                resultTitle.textContent = 'Converted Area';
                                resultDescription.textContent = 'Enter a value to convert';
                            }
                        }

                        function updateUnitDisplay() {
                            const toUnit = toSelect.value;
                            const conversion = conversionRates[toUnit];
                            if (valueInput.value === '' || isNaN(parseFloat(valueInput.value))) {
                                unitDisplay.textContent = conversion.symbol;
                            }
                        }

                        function clearInput() {
                            valueInput.value = '';
                            convert();
                            valueInput.focus();
                        }

                        // Event listeners
                        valueInput.addEventListener('input', convert);
                        toSelect.addEventListener('change', function() {
                            convert();
                            updateUnitDisplay();
                        });
                        clearButton.addEventListener('click', clearInput);

                        // Add clickable functionality to example land sizes
                        const exampleAcres = document.querySelectorAll('[data-acres]');
                        exampleAcres.forEach(element => {
                            element.addEventListener('click', function() {
                                const acreValue = this.getAttribute('data-acres');
                                valueInput.value = acreValue;
                                convert();
                                valueInput.focus();
                            });
                        });

                        // Initialize
                        updateUnitDisplay();
                        
                        // Focus on input when page loads
                        valueInput.focus();

                        // Add keyboard shortcuts
                        document.addEventListener('keydown', function(e) {
                            if (e.key === 'Escape' || (e.ctrlKey && e.shiftKey && (e.key === 'C' || e.key === 'c'))) {
                                if (e.ctrlKey && e.shiftKey) {
                                    e.preventDefault();
                                }
                                clearInput();
                            }
                        });
                    });
                </script>
    </x-slot>
</x-tool-page-layout>
