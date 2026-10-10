<x-tool-page-layout
    title="Length Calculator - ConvertPro"
    description="Professional length calculator to convert between meters, feet, inches, kilometers, and other length units. Fast and accurate conversions."
>
    <x-slot name="toolUi">
        <!-- Calculator Card -->
                        <div class="space-y-2">
                            
                            <!-- Calculator Header -->
                            <div class="rounded-md bg-white p-2.5 shadow-sm">
                                <h1 class="text-sm font-semibold text-slate-900">Length Converter</h1>
                            </div>

                            <!-- Calculator Body -->
                            <div class="rounded-md bg-white p-3 shadow-sm">
                                
                                <div class="grid gap-3 lg:grid-cols-5">
                                    <div class="lg:col-span-3">
                                        <form class="space-y-3" id="calculatorForm">

                                                                            <!-- Value and Units -->
                                                                            <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
                                                                            <div class="space-y-2">
                                                                                <label for="value" class="block text-xs font-semibold text-slate-700">
                                                                                    Enter Length Value
                                                                                </label>
                                                                                <input 
                                                                                    type="number" 
                                                                                    id="value" 
                                                                                    class="w-full rounded-md border border-slate-300 bg-white" 
                                                                                    placeholder="Enter length value"
                                                                                    step="any"
                                                                                    min="0"
                                                                                >
                                                                            </div>

                                                                            <!-- From Unit -->
                                                                            <div class="space-y-2">
                                                                                <label for="from" class="block text-xs font-semibold text-slate-700">
                                                                                    From Unit
                                                                                </label>
                                                                                <select 
                                                                                    id="from" 
                                                                                    class="w-full rounded-md border border-slate-300 bg-white"
                                                                                >
                                                                                    <option value="m">Meters (m)</option>
                                                                                    <option value="ft">Feet (ft)</option>
                                                                                    <option value="in">Inches (in)</option>
                                                                                    <option value="cm">Centimeters (cm)</option>
                                                                                    <option value="mm">Millimeters (mm)</option>
                                                                                    <option value="km">Kilometers (km)</option>
                                                                                    <option value="yd">Yards (yd)</option>
                                                                                    <option value="mi">Miles (mi)</option>
                                                                                    <option value="nm">Nanometers (nm)</option>
                                                                                    <option value="um">Micrometers (μm)</option>
                                                                                </select>
                                                                            </div>

                                                                            <!-- To Unit -->
                                                                            <div class="space-y-2">
                                                                                <label for="to" class="block text-xs font-semibold text-slate-700">
                                                                                    To Unit
                                                                                </label>
                                                                                <select 
                                                                                    id="to" 
                                                                                    class="w-full rounded-md border border-slate-300 bg-white"
                                                                                >
                                                                                    <option value="m">Meters (m)</option>
                                                                                    <option value="ft">Feet (ft)</option>
                                                                                    <option value="in">Inches (in)</option>
                                                                                    <option value="cm">Centimeters (cm)</option>
                                                                                    <option value="mm">Millimeters (mm)</option>
                                                                                    <option value="km">Kilometers (km)</option>
                                                                                    <option value="yd">Yards (yd)</option>
                                                                                    <option value="mi">Miles (mi)</option>
                                                                                    <option value="nm">Nanometers (nm)</option>
                                                                                    <option value="um">Micrometers (μm)</option>
                                                                                </select>
                                                                            </div>

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
                                    <div class="space-y-4 lg:col-span-2">
                                        <!-- Result Display -->
                                                                        <div class="mt-8 space-y-4">
                                                                            <h3 class="text-lg font-semibold text-slate-900 text-center mb-4">Converted Values</h3>
                                                                            <div class="rounded-md border border-slate-200 bg-slate-50 p-2.5">
                                                                                <div class="flex items-center justify-between">
                                                                                    <div>
                                                                                        <h4 class="text-xs font-semibold text-slate-900" id="result-title">Converted Length</h4>
                                                                                        <p class="text-[11px] text-slate-500" id="result-description">Enter a value to convert</p>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <div class="font-serif text-3xl font-bold leading-none text-indigo-700" id="output">--</div>
                                                                                        <div class="text-xs text-slate-500 font-medium" id="unit-display">Select units</div>
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
                            <h3 class="text-lg font-semibold text-slate-900 mb-4">About Length Conversion</h3>
                            <div class="grid md:grid-cols-2 gap-6 text-[11px] text-slate-500">
                                <div>
                                    <h4 class="font-semibold text-slate-700 mb-2">Common Applications</h4>
                                    <p>Length calculations are essential for construction projects, engineering designs, scientific measurements, sports tracking, and everyday measurements in both professional and personal contexts.</p>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-slate-700 mb-2">Precision & Standards</h4>
                                    <p>Our calculator uses internationally recognized conversion factors based on the meter as the fundamental SI unit, ensuring accuracy across all measurement systems.</p>
                                </div>
                            </div>
                            <div class="mt-4 rounded-md bg-indigo-50 p-3 text-xs text-indigo-800">
                                <p class="text-sm text-indigo-800">
                                    <strong>Did You Know?</strong> The meter was originally defined as one ten-millionth of the distance from the equator to the North Pole!
                                </p>
                            </div>
                        </div>

                        <div class="rounded-xl border border-slate-200 bg-white p-3 shadow-sm">
                            <h3 class="text-base font-semibold text-slate-900 mb-3">Quick Reference</h3>
                            <div class="grid grid-cols-1 gap-2 text-xs text-slate-600 sm:grid-cols-2">
                                <div>• 1 m = 3.28084 ft</div>
                                <div>• 1 ft = 12 in</div>
                                <div>• 1 km = 1000 m</div>
                                <div>• 1 mi = 5280 ft</div>
                                <div>• 1 yd = 3 ft</div>
                                <div>• 1 m = 100 cm</div>
                            </div>
                        </div>

                        <!-- Common Length Examples -->
                        <div class="rounded-xl border border-slate-200 bg-white p-3">
                            <h3 class="text-lg font-semibold text-slate-900 mb-4">Common Length Examples</h3>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Credit Card</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-length="8.5" data-unit="cm">8.5 cm</div>
                                </div>
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Average Person</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-length="5.7" data-unit="ft">5.7 ft</div>
                                </div>
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Basketball Court</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-length="28" data-unit="m">28 m</div>
                                </div>
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Marathon</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-length="26.2" data-unit="mi">26.2 mi</div>
                                </div>
                            </div>
                        </div>
    </x-slot>

    <x-slot name="scripts">
        <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const valueInput = document.getElementById('value');
                        const fromSelect = document.getElementById('from');
                        const toSelect = document.getElementById('to');
                        const clearButton = document.getElementById('clearButton');
                        const output = document.getElementById('output');
                        const unitDisplay = document.getElementById('unit-display');
                        const resultTitle = document.getElementById('result-title');
                        const resultDescription = document.getElementById('result-description');

                        // Conversion rates to meters
                        const conversionRates = {
                            m: { toMeters: 1, symbol: 'm', name: 'Meters' },
                            ft: { toMeters: 0.3048, symbol: 'ft', name: 'Feet' },
                            in: { toMeters: 0.0254, symbol: 'in', name: 'Inches' },
                            cm: { toMeters: 0.01, symbol: 'cm', name: 'Centimeters' },
                            mm: { toMeters: 0.001, symbol: 'mm', name: 'Millimeters' },
                            km: { toMeters: 1000, symbol: 'km', name: 'Kilometers' },
                            yd: { toMeters: 0.9144, symbol: 'yd', name: 'Yards' },
                            mi: { toMeters: 1609.34, symbol: 'mi', name: 'Miles' },
                            nm: { toMeters: 1e-9, symbol: 'nm', name: 'Nanometers' },
                            um: { toMeters: 1e-6, symbol: 'μm', name: 'Micrometers' }
                        };

                        function convert() {
                            const value = parseFloat(valueInput.value);
                            const fromUnit = fromSelect.value;
                            const toUnit = toSelect.value;

                            if (!isNaN(value) && value >= 0) {
                                // Convert to meters first, then to target unit
                                const inMeters = value * conversionRates[fromUnit].toMeters;
                                const result = inMeters / conversionRates[toUnit].toMeters;
                                
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
                                unitDisplay.textContent = conversionRates[toUnit].symbol;
                                resultTitle.textContent = 'Length in ' + conversionRates[toUnit].name;
                                resultDescription.textContent = `${value} ${conversionRates[fromUnit].symbol} = ${formattedResult} ${conversionRates[toUnit].symbol}`;
                            } else {
                                output.textContent = "--";
                                unitDisplay.textContent = "Select units";
                                resultTitle.textContent = 'Converted Length';
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
                            if (valueInput.value === '' || isNaN(parseFloat(valueInput.value))) {
                                unitDisplay.textContent = conversionRates[toUnit].symbol;
                            }
                        }

                        // Event listeners
                        valueInput.addEventListener('input', convert);
                        fromSelect.addEventListener('change', function() {
                            convert();
                            updateUnitDisplay();
                        });
                        toSelect.addEventListener('change', function() {
                            convert();
                            updateUnitDisplay();
                        });
                        clearButton.addEventListener('click', clearInput);

                        // Add clickable functionality to example lengths
                        const exampleLengths = document.querySelectorAll('[data-length]');
                        exampleLengths.forEach(element => {
                            element.addEventListener('click', function() {
                                const lengthValue = this.getAttribute('data-length');
                                const unitValue = this.getAttribute('data-unit');
                                
                                valueInput.value = lengthValue;
                                fromSelect.value = unitValue;
                                convert();
                                valueInput.focus();
                            });
                        });

                        // Initialize
                        updateUnitDisplay();
                        
                        // Focus on input when page loads
                        valueInput.focus();
                        
                        // Set default values
                        fromSelect.value = 'ft';
                        toSelect.value = 'm';

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
