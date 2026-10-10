<x-tool-page-layout
    title="Astronomical Unit Calculator - SolveKit"
    description="Professional astronomical unit calculator to convert AU to kilometers, miles, light years, and parsecs. Accurate space distance conversions for astronomy and education."
>
    <x-slot name="toolUi">
        <!-- Calculator Card -->
                        <div class="space-y-2">
                            
                            <!-- Calculator Header -->
                            <div class="rounded-md bg-white p-2.5 shadow-sm">
                                <h1 class="text-sm font-semibold text-slate-900">Astronomical Units</h1>
                            </div>

                            <!-- Calculator Body -->
                            <div class="rounded-md bg-white p-3 shadow-sm">
                                
                                <div class="grid gap-3 lg:grid-cols-9">
                                    <div class="lg:col-span-5">
                                        <form class="space-y-3" id="calculatorForm">

                                                                            <!-- Input Value -->
                                                                            <div class="space-y-2">
                                                                                <label for="value" class="block text-xs font-semibold text-slate-700">
                                                                                    Distance in Astronomical Units
                                                                                </label>
                                                                                <div class="relative">
                                                                                    <input 
                                                                                        type="number" 
                                                                                        id="value" 
                                                                                        class="w-full rounded-md border border-slate-300 bg-white" 
                                                                                        placeholder="Enter AU value (e.g., 1.5)"
                                                                                        step="any"
                                                                                        min="0"
                                                                                    >
                                                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                        <span class="text-slate-500 text-sm font-medium">AU</span>
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
                                                                                    <option value="km">Kilometers (km)</option>
                                                                                    <option value="miles">Miles (mi)</option>
                                                                                    <option value="lightyears">Light Years (ly)</option>
                                                                                    <option value="parsecs">Parsecs (pc)</option>
                                                                                    <option value="meters">Meters (m)</option>
                                                                                    <option value="feet">Feet (ft)</option>
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
                                                                                        <h4 class="text-xs font-semibold text-slate-900" id="result-title">Converted Distance</h4>
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
                            <h3 class="text-lg font-semibold text-slate-900 mb-4">About Astronomical Unit Conversion</h3>
                            <div class="grid md:grid-cols-2 gap-6 text-[11px] text-slate-500">
                                <div>
                                    <h4 class="font-semibold text-slate-700 mb-2">What is an AU?</h4>
                                    <p>An Astronomical Unit (AU) is the average distance between Earth and the Sun, approximately 149.6 million kilometers or 93 million miles. It's the standard unit for measuring distances within our solar system.</p>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-slate-700 mb-2">Common Uses</h4>
                                    <p>AU calculations are essential for astronomy, space mission planning, educational purposes, and understanding planetary distances and spacecraft trajectories.</p>
                                </div>
                            </div>
                            <div class="mt-4 rounded-md bg-indigo-50 p-3 text-xs text-indigo-800">
                                <p class="text-sm text-indigo-800">
                                    <strong>Fun Fact:</strong> Light from the Sun takes about 8 minutes and 20 seconds to travel 1 AU to reach Earth!
                                </p>
                            </div>
                        </div>

                        <div class="rounded-xl border border-slate-200 bg-white p-3 shadow-sm">
                            <h3 class="text-base font-semibold text-slate-900 mb-3">Quick Reference</h3>
                            <div class="grid grid-cols-1 gap-2 text-xs text-slate-600 sm:grid-cols-2">
                                <div>• 1 AU = 149,597,871 km</div>
                                <div>• 1 AU = 92,955,807 miles</div>
                                <div>• 1 AU = 1.58 × 10⁻⁵ light years</div>
                                <div>• 1 AU = 4.85 × 10⁻⁶ parsecs</div>
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
                            km: { rate: 149597870.7, symbol: 'km', name: 'Kilometers' },
                            miles: { rate: 92955807.3, symbol: 'mi', name: 'Miles' },
                            lightyears: { rate: 1.58125e-5, symbol: 'ly', name: 'Light Years' },
                            parsecs: { rate: 4.84814e-6, symbol: 'pc', name: 'Parsecs' },
                            meters: { rate: 149597870700, symbol: 'm', name: 'Meters' },
                            feet: { rate: 490806662402.374, symbol: 'ft', name: 'Feet' }
                        };

                        function convert() {
                            const au = parseFloat(valueInput.value);
                            const toUnit = toSelect.value;
                            const conversion = conversionRates[toUnit];

                            if (!isNaN(au) && au >= 0) {
                                const result = au * conversion.rate;
                                
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
                                resultTitle.textContent = 'Distance in ' + conversion.name;
                                resultDescription.textContent = `${au} AU = ${formattedResult} ${conversion.symbol}`;
                            } else {
                                output.textContent = "--";
                                unitDisplay.textContent = "Select unit";
                                resultTitle.textContent = 'Converted Distance';
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
