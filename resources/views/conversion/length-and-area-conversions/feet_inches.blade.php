<x-tool-page-layout
    title="Feet &amp; Inches Calculator - SolveKit"
    description="Professional feet and inches calculator to convert imperial measurements to metric units. Convert feet and inches to centimeters, meters, and total inches."
>
    <x-slot name="toolUi">
        <!-- Calculator Card -->
                        <div class="space-y-2">
                            
                            <!-- Calculator Header -->
                            <div class="rounded-md bg-white p-2.5 shadow-sm">
                                <h1 class="text-sm font-semibold text-slate-900">Feet &amp; Inches</h1>
                            </div>

                            <!-- Calculator Body -->
                            <div class="rounded-md bg-white p-3 shadow-sm">
                                
                                <div class="grid gap-3 lg:grid-cols-9">
                                    <div class="lg:col-span-5">
                                        <form class="space-y-3" id="calculatorForm">

                                                                            <!-- Feet and Inches Input -->
                                                                            <div class="space-y-2">
                                                                                <label class="block text-xs font-semibold text-slate-700">
                                                                                    Enter Feet and Inches
                                                                                </label>
                                                                                <div class="grid grid-cols-2 gap-4">
                                                                                    <div class="relative">
                                                                                        <input 
                                                                                            type="number" 
                                                                                            id="feet" 
                                                                                            class="w-full rounded-md border border-slate-300 bg-white" 
                                                                                            placeholder="0"
                                                                                            step="any"
                                                                                            min="0"
                                                                                        >
                                                                                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                            <span class="text-slate-500 text-sm font-medium">ft</span>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="relative">
                                                                                        <input 
                                                                                            type="number" 
                                                                                            id="inches" 
                                                                                            class="w-full rounded-md border border-slate-300 bg-white" 
                                                                                            placeholder="0"
                                                                                            step="any"
                                                                                            min="0"
                                                                                            max="11.99"
                                                                                        >
                                                                                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                            <span class="text-slate-500 text-sm font-medium">in</span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <p class="text-[11px] text-slate-500">Enter feet and inches (e.g., 5 feet 9 inches)</p>
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
                                        <!-- Results Display -->
                                                                        <div class="mt-8 space-y-4">
                                                                            <h3 class="text-lg font-semibold text-slate-900 text-center mb-4">Converted Values</h3>

                                                                            <!-- Total Inches -->
                                                                            <div class="rounded-md border border-slate-200 bg-slate-50 p-2.5">
                                                                                <div class="flex items-center justify-between">
                                                                                    <div>
                                                                                        <h4 class="text-xs font-semibold text-slate-900">Total Inches</h4>
                                                                                        <p class="text-[11px] text-slate-500">Combined measurement</p>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <div class="font-serif text-3xl font-bold leading-none text-indigo-700" id="totalInches">--</div>
                                                                                        <div class="text-xs text-slate-500 font-medium">inches</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Centimeters -->
                                                                            <div class="rounded-md border border-slate-200 bg-slate-50 p-2.5">
                                                                                <div class="flex items-center justify-between">
                                                                                    <div>
                                                                                        <h4 class="text-xs font-semibold text-slate-900">Centimeters</h4>
                                                                                        <p class="text-[11px] text-slate-500">Metric equivalent</p>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <div class="font-serif text-3xl font-bold leading-none text-indigo-700" id="centimeters">--</div>
                                                                                        <div class="text-xs text-slate-500 font-medium">cm</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Meters -->
                                                                            <div class="rounded-md border border-slate-200 bg-slate-50 p-2.5">
                                                                                <div class="flex items-center justify-between">
                                                                                    <div>
                                                                                        <h4 class="text-xs font-semibold text-slate-900">Meters</h4>
                                                                                        <p class="text-[11px] text-slate-500">Base metric unit</p>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <div class="font-serif text-3xl font-bold leading-none text-indigo-700" id="meters">--</div>
                                                                                        <div class="text-xs text-slate-500 font-medium">m</div>
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
                            <h3 class="text-lg font-semibold text-slate-900 mb-4">About Feet & Inches Conversion</h3>
                            <div class="grid md:grid-cols-2 gap-6 text-[11px] text-slate-500">
                                <div>
                                    <h4 class="font-semibold text-slate-700 mb-2">Imperial System</h4>
                                    <p>The foot and inch are traditional units of length in the imperial system, commonly used in the United States, United Kingdom, and other countries for measuring height, construction, and everyday distances.</p>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-slate-700 mb-2">Common Applications</h4>
                                    <p>These conversions are essential for international trade, construction projects, height measurements, sports statistics, and converting between imperial and metric systems.</p>
                                </div>
                            </div>
                            <div class="mt-4 rounded-md bg-indigo-50 p-3 text-xs text-indigo-800">
                                <p class="text-sm text-indigo-800">
                                    <strong>Fun Fact:</strong> The foot was originally based on the length of a human foot, and there are 12 inches in a foot!
                                </p>
                            </div>
                        </div>

                        <div class="rounded-xl border border-slate-200 bg-white p-3 shadow-sm">
                            <h3 class="text-base font-semibold text-slate-900 mb-3">Quick Reference</h3>
                            <div class="grid grid-cols-1 gap-2 text-xs text-slate-600 sm:grid-cols-2">
                                <div>• 1 foot = 12 inches</div>
                                <div>• 1 inch = 2.54 cm</div>
                                <div>• 1 foot = 30.48 cm</div>
                                <div>• 1 meter = 3.28084 feet</div>
                            </div>
                        </div>

                        <!-- Common Heights Examples -->
                        <div class="rounded-xl border border-slate-200 bg-white p-3">
                            <h3 class="text-lg font-semibold text-slate-900 mb-4">Common Height Examples</h3>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Average Woman</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-feet="5" data-inches="4">5'4"</div>
                                </div>
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Average Man</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-feet="5" data-inches="9">5'9"</div>
                                </div>
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Door Height</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-feet="6" data-inches="8">6'8"</div>
                                </div>
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Basketball Hoop</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-feet="10" data-inches="0">10'0"</div>
                                </div>
                            </div>
                        </div>
    </x-slot>

    <x-slot name="scripts">
        <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const feetInput = document.getElementById('feet');
                        const inchesInput = document.getElementById('inches');
                        const clearButton = document.getElementById('clearButton');
                        const totalInches = document.getElementById('totalInches');
                        const centimeters = document.getElementById('centimeters');
                        const meters = document.getElementById('meters');

                        function formatMeasurement(value, fractionDigits) {
                            if (value !== 0 && Math.abs(value) < 0.000001) {
                                return Number(value.toPrecision(4)).toExponential();
                            } else if (Math.abs(value) < 1) {
                                return value.toLocaleString(undefined, { maximumSignificantDigits: 4 });
                            }

                            return value.toLocaleString(undefined, { maximumFractionDigits: fractionDigits });
                        }

                        function convert() {
                            const feet = parseFloat(feetInput.value) || 0;
                            const inches = parseFloat(inchesInput.value) || 0;

                            // Calculate conversions
                            const total = (feet * 12) + inches;
                            const cm = total * 2.54;
                            const m = cm / 100;

                            // Format and display results
                            if (feet === 0 && inches === 0) {
                                totalInches.textContent = "--";
                                centimeters.textContent = "--";
                                meters.textContent = "--";
                            } else {
                                totalInches.textContent = formatMeasurement(total, 2);
                                centimeters.textContent = formatMeasurement(cm, 2);
                                meters.textContent = formatMeasurement(m, 4);
                            }
                        }

                        function clearInputs() {
                            feetInput.value = '';
                            inchesInput.value = '';
                            convert();
                            feetInput.focus();
                        }

                        // Event listeners
                        feetInput.addEventListener('input', convert);
                        inchesInput.addEventListener('input', convert);
                        clearButton.addEventListener('click', clearInputs);

                        // Add clickable functionality to example heights
                        const exampleHeights = document.querySelectorAll('[data-feet]');
                        exampleHeights.forEach(element => {
                            element.addEventListener('click', function() {
                                const feetValue = this.getAttribute('data-feet');
                                const inchesValue = this.getAttribute('data-inches');
                                
                                feetInput.value = feetValue;
                                inchesInput.value = inchesValue;
                                convert();
                                feetInput.focus();
                            });
                        });

                        // Initialize
                        feetInput.focus();

                        // Add keyboard shortcuts
                        document.addEventListener('keydown', function(e) {
                            if (e.key === 'Escape' || (e.ctrlKey && e.shiftKey && (e.key === 'C' || e.key === 'c'))) {
                                if (e.ctrlKey && e.shiftKey) {
                                    e.preventDefault();
                                }
                                clearInputs();
                            } else if (e.key === 'Tab' && e.target === feetInput) {
                                // Allow natural tab navigation to inches input
                            }
                        });

                        // Auto-convert inches > 12 to feet + inches
                        inchesInput.addEventListener('blur', function() {
                            const inches = parseFloat(inchesInput.value) || 0;
                            if (inches >= 12) {
                                const extraFeet = Math.floor(inches / 12);
                                const remainingInches = inches % 12;
                                const currentFeet = parseFloat(feetInput.value) || 0;
                                
                                feetInput.value = currentFeet + extraFeet;
                                inchesInput.value = remainingInches.toFixed(2).replace('.00', '');
                                convert();
                            }
                        });

                        // Initialize conversion
                        convert();
                    });
                </script>
    </x-slot>
</x-tool-page-layout>
