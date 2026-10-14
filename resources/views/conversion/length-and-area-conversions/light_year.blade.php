<x-tool-page-layout
    title="Light Year Converter - SolveKit"
    description="Professional light year converter to convert light years to kilometers, miles, astronomical units, and parsecs. Accurate space distance conversions for astronomy."
>
    <x-slot name="toolUi">
        <!-- Calculator Card -->
                        <div class="space-y-2">
                            
                            <!-- Calculator Header -->
                            <div class="rounded-md bg-white p-2.5 shadow-sm">
                                <h1 class="text-sm font-semibold text-slate-900">Light Year Converter</h1>
                            </div>

                            <!-- Calculator Body -->
                            <div class="rounded-md bg-white p-3 shadow-sm">
                                
                                <div class="grid gap-3 lg:grid-cols-9">
                                    <div class="lg:col-span-5">
                                        <form class="space-y-3" id="calculatorForm">

                                                                            <!-- Input Value -->
                                                                            <div class="space-y-2">
                                                                                <label for="value" class="block text-xs font-semibold text-slate-700">
                                                                                    Distance in Light Years
                                                                                </label>
                                                                                <div class="relative">
                                                                                    <input 
                                                                                        type="number" 
                                                                                        id="value" 
                                                                                        class="w-full rounded-md border border-slate-300 bg-white" 
                                                                                        placeholder="Enter light years (e.g., 4.37)"
                                                                                        step="any"
                                                                                        min="0"
                                                                                    >
                                                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                        <span class="text-slate-500 text-sm font-medium">ly</span>
                                                                                    </div>
                                                                                </div>
                                                                                <p class="text-[11px] text-slate-500">Nearest star is 4.37 light years away</p>
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
                                                                                    <option value="mi">Miles (mi)</option>
                                                                                    <option value="au">Astronomical Units (AU)</option>
                                                                                    <option value="pc">Parsecs (pc)</option>
                                                                                    <option value="m">Meters (m)</option>
                                                                                    <option value="ft">Feet (ft)</option>
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
                            <h3 class="text-lg font-semibold text-slate-900 mb-4">About Light Year Conversion</h3>
                            <div class="grid md:grid-cols-2 gap-6 text-[11px] text-slate-500">
                                <div>
                                    <h4 class="font-semibold text-slate-700 mb-2">What is a Light Year?</h4>
                                    <p>A light year is the distance that light travels in one year in a vacuum, approximately 9.46 trillion kilometers. It's used to measure vast interstellar and intergalactic distances in astronomy.</p>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-slate-700 mb-2">Astronomical Applications</h4>
                                    <p>Light years help astronomers describe distances to nearby stars, stellar distances within galaxies, and are essential for understanding the scale of the universe and cosmic phenomena.</p>
                                </div>
                            </div>
                            <div class="mt-4 rounded-md bg-indigo-50 p-3 text-xs text-indigo-800">
                                <p class="text-sm text-indigo-800">
                                    <strong>Cosmic Fact:</strong> The nearest star to Earth (Proxima Centauri) is 4.37 light years away - that's about 25 trillion miles!
                                </p>
                            </div>
                        </div>

                        <div class="rounded-xl border border-slate-200 bg-white p-3 shadow-sm">
                            <h3 class="text-base font-semibold text-slate-900 mb-3">Quick Reference</h3>
                            <div class="grid grid-cols-1 gap-2 text-xs text-slate-600 sm:grid-cols-2">
                                <div>• 1 ly = 9.46 × 10¹² km</div>
                                <div>• 1 ly = 5.88 × 10¹² miles</div>
                                <div>• 1 ly = 63,241 AU</div>
                                <div>• 1 ly = 0.307 parsecs</div>
                            </div>
                        </div>

                        <!-- Famous Distances Examples -->
                        <div class="rounded-xl border border-slate-200 bg-white p-3">
                            <h3 class="text-lg font-semibold text-slate-900 mb-4">Famous Cosmic Distances</h3>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Proxima Centauri</div>
                                    <div class="text-indigo-600 cursor-pointer hover:text-indigo-800 transition-colors" data-distance="4.37">4.37 ly</div>
                                    <div class="text-[11px] text-slate-500">Nearest Star</div>
                                </div>
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Sirius</div>
                                    <div class="text-indigo-600 cursor-pointer hover:text-indigo-800 transition-colors" data-distance="8.6">8.6 ly</div>
                                    <div class="text-[11px] text-slate-500">Brightest Star</div>
                                </div>
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Vega</div>
                                    <div class="text-indigo-600 cursor-pointer hover:text-indigo-800 transition-colors" data-distance="25">25 ly</div>
                                    <div class="text-[11px] text-slate-500">Northern Star</div>
                                </div>
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Galactic Center</div>
                                    <div class="text-indigo-600 cursor-pointer hover:text-indigo-800 transition-colors" data-distance="26000">26,000 ly</div>
                                    <div class="text-[11px] text-slate-500">Milky Way Center</div>
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
                            km: { rate: 9.461e+12, symbol: 'km', name: 'Kilometers' },
                            mi: { rate: 5.879e+12, symbol: 'mi', name: 'Miles' },
                            au: { rate: 63241.1, symbol: 'AU', name: 'Astronomical Units' },
                            pc: { rate: 0.306601, symbol: 'pc', name: 'Parsecs' },
                            m: { rate: 9.461e+15, symbol: 'm', name: 'Meters' },
                            ft: { rate: 3.104e+16, symbol: 'ft', name: 'Feet' }
                        };

                        function convert() {
                            const lightYears = parseFloat(valueInput.value);
                            const toUnit = toSelect.value;
                            const conversion = conversionRates[toUnit];

                            if (!isNaN(lightYears) && lightYears >= 0) {
                                const result = lightYears * conversion.rate;
                                
                                // Format the result appropriately
                                let formattedResult;
                                if (result >= 1e15) {
                                    formattedResult = Number(result.toPrecision(5)).toExponential();
                                } else if (result >= 1000000) {
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
                                resultDescription.textContent = `${lightYears} ly = ${formattedResult} ${conversion.symbol}`;
                            } else {
                                output.textContent = "--";
                                unitDisplay.textContent = "Select unit";
                                resultTitle.textContent = 'Converted Distance';
                                resultDescription.textContent = 'Enter a value to convert';
                            }
                        }

                        function clearInput() {
                            valueInput.value = '';
                            convert();
                            valueInput.focus();
                        }

                        function updateUnitDisplay() {
                            const toUnit = toSelect.value;
                            const conversion = conversionRates[toUnit];
                            if (valueInput.value === '' || isNaN(parseFloat(valueInput.value))) {
                                unitDisplay.textContent = conversion.symbol;
                            }
                        }

                        // Event listeners
                        valueInput.addEventListener('input', convert);
                        toSelect.addEventListener('change', function() {
                            convert();
                            updateUnitDisplay();
                        });
                        clearButton.addEventListener('click', clearInput);

                        // Add clickable functionality to example distances
                        const exampleDistances = document.querySelectorAll('[data-distance]');
                        exampleDistances.forEach(element => {
                            element.addEventListener('click', function() {
                                const distanceValue = this.getAttribute('data-distance');
                                valueInput.value = distanceValue;
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

                        // Initialize conversion
                        convert();
                    });
                </script>
    </x-slot>
</x-tool-page-layout>
